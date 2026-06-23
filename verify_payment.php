<?php
session_start();
require __DIR__ . '/config.php';
include __DIR__ . '/admin/../database.php';

if (empty($_POST['razorpay_payment_id'])) {
    die("Invalid Request");
}

$payment_id = $_POST['razorpay_payment_id'];
$order_id   = $_POST['razorpay_order_id'];
$signature  = $_POST['razorpay_signature'];

$generated_signature = hash_hmac('sha256', $order_id . '|' . $payment_id, RAZORPAY_KEY_SECRET);

if ($generated_signature === $signature) {
    // ✅ Payment successful, now register user
    $email     = $_SESSION['reg_email'] ?? '';
    $password  = $_SESSION['reg_password'] ?? '';
    $course_id = $_SESSION['course_id'] ?? 0;

    if ($email && $password && $course_id) {
        // Insert user into DB
        $stmt = $conn->prepare("INSERT INTO student_login (email, password, course_id, payment_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $email, $password, $course_id, $payment_id);
        $stmt->execute();
        $stmt->close();

        // Clear session
        unset($_SESSION['reg_email'], $_SESSION['reg_password'], $_SESSION['course_id'], $_SESSION['order_id']);
    } else {
        die("❌ User session data missing.");
    }

    // ✅ Show SweetAlert popup and redirect
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Payment Success</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
        Swal.fire({
            title: "✅ Payment Successful!",
            text: "Your account has been created. Redirecting to login...",
            icon: "success",
            confirmButtonText: "Go to Login",
            timer: 4000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = "login.php";
        });
        </script>
    </body>
    </html>
    <?php
    exit;

} else {
    // ❌ Failed verification
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Payment Failed</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
        Swal.fire({
            title: "❌ Payment Failed",
            text: "Verification failed. Please try again.",
            icon: "error",
            confirmButtonText: "Back to Register"
        }).then(() => {
            window.location.href = "register.php?course_id=<?php echo $_SESSION['course_id'] ?? ''; ?>";
        });
        </script>
    </body>
    </html>
    <?php
    exit;
}
