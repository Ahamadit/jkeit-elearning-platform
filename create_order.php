<?php
session_start();
require __DIR__ . '/config.php';
include __DIR__ . '/admin/../database.php';

// Get POST data
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';
$course_id = $_POST['course_id'] ?? null;

if (!$email || strlen($password) < 6 || !$course_id) {
    $_SESSION['message'] = "<div class='error'>❌ Invalid input</div>";
    header("Location: register.php?course_id=$course_id");
    exit;
}

// Save registration details in session for later (verify step)
$_SESSION['reg_email'] = $email;
$_SESSION['reg_password'] = password_hash($password, PASSWORD_DEFAULT);
$_SESSION['course_id'] = $course_id;

// Fetch course details
$stmt = $conn->prepare("SELECT course_name, price FROM add_course WHERE id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $course_price = $row['price']; // in INR
    $course_name = $row['course_name'];
} else {
    die("❌ Course not found.");
}
$stmt->close();

// Create Razorpay order
$amount_paise = $course_price * 100; // INR → paise
$receipt_id = uniqid('rcpt_');

$data = [
    'amount' => $amount_paise,
    'currency' => 'INR',
    'receipt' => $receipt_id,
    'payment_capture' => 1
];

// API request to Razorpay
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
    die("cURL Error: " . $err);
}

$order = json_decode($response, true);
$_SESSION['order_id'] = $order['id'];
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Complete Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
<script>
const options = {
    "key": "<?php echo RAZORPAY_KEY_ID; ?>",
    "amount": "<?php echo $order['amount']; ?>",
    "currency": "<?php echo $order['currency']; ?>",
    "name": "Student Registration",
    "description": "Pay for <?php echo htmlspecialchars($course_name); ?>",
    "order_id": "<?php echo $order['id']; ?>",
    "handler": function (response){
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'verify_payment.php';

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
        "email": "<?php echo htmlspecialchars($email); ?>"
    },
    "theme": { "color": "#2575fc" }
};

var rzp = new Razorpay(options);
rzp.open();
</script>
</body>
</html>
