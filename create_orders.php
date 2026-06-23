<?php
// create_orders.php
session_start();
require __DIR__ . '/config.php';
include __DIR__ . '/database.php';

// Ensure required session data exists
if (empty($_SESSION['fr_email']) || empty($_SESSION['fr_password']) || empty($_SESSION['payment_amount_inr'])) {
    $_SESSION['message'] = "<div class='alert alert-danger'>Session expired or invalid. Please register again.</div>";
    header("Location: franchisee_register.php");
    exit;
}

$amount_inr = (int) $_SESSION['payment_amount_inr'];
$amount_paise = $amount_inr * 100; // paise
$receipt_id = uniqid('rcpt_');

$data = [
    'amount' => $amount_paise,
    'currency' => 'INR',
    'receipt' => $receipt_id,
    'payment_capture' => 1
];

// create order via Razorpay API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_USERPWD, RAZORPAY_KEY_ID . ":" . RAZORPAY_KEY_SECRET);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if ($err) {
    die("cURL Error creating order: " . htmlspecialchars($err));
}

$order = json_decode($response, true);
if (empty($order['id'])) {
    die("Failed to create Razorpay order. Response: " . htmlentities($response));
}

// store order in session for verification later
$_SESSION['rzp_order_id'] = $order['id'];

// close session before opening checkout to avoid session locking issues
session_write_close();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Pay ₹<?php echo htmlspecialchars($amount_inr); ?></title>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
<script>
const options = {
    "key": "<?php echo RAZORPAY_KEY_ID; ?>",
    "amount": "<?php echo $order['amount']; ?>", // in paise
    "currency": "<?php echo $order['currency']; ?>",
    "name": "Franchisee Registration",
    "description": "Registration fee",
    "order_id": "<?php echo $order['id']; ?>",
    "handler": function (response){
        // send response to server for verification
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'varify_payments.php';

        ['razorpay_payment_id','razorpay_order_id','razorpay_signature'].forEach(function(k){
            var inp = document.createElement('input');
            inp.type = 'hidden';
            inp.name = k;
            inp.value = response[k];
            form.appendChild(inp);
        });

        document.body.appendChild(form);
        form.submit();
    },
    "prefill": {
        "email": "<?php echo htmlspecialchars($_SESSION['fr_email']); ?>",
        "name": "<?php echo htmlspecialchars($_SESSION['fr_name'] ?? ''); ?>",
        "contact": "<?php echo htmlspecialchars($_SESSION['fr_phone'] ?? ''); ?>"
    },
    "theme": {"color": "#2575fc"}
};

var rzp = new Razorpay(options);
rzp.open();

// optional: handle checkout dismiss (user closed)
rzp.on('checkout.failed', function (response){
    alert('Payment failed or cancelled.');
    window.location.href = 'franchisee_register.php';
});
</script>
</body>
</html>
