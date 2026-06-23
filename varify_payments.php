<?php
// varify_payments.php
session_start();
require __DIR__ . '/config.php';
include __DIR__ . '/database.php';

// basic validation
if (empty($_POST['razorpay_payment_id']) || empty($_POST['razorpay_order_id']) || empty($_POST['razorpay_signature'])) {
    $_SESSION['message'] = "<div class='alert alert-danger'>Invalid payment response.</div>";
    header("Location: franchisee_register.php");
    exit;
}

$payment_id = $_POST['razorpay_payment_id'];
$order_id   = $_POST['razorpay_order_id'];
$signature  = $_POST['razorpay_signature'];

// recompute signature
$generated_signature = hash_hmac('sha256', $order_id . '|' . $payment_id, RAZORPAY_KEY_SECRET);

if (hash_equals($generated_signature, $signature)) {
    // signature ok - create franchisee record
    $name = $_SESSION['fr_name'] ?? '';
    $email = $_SESSION['fr_email'] ?? '';
    $phone = $_SESSION['fr_phone'] ?? '';
    $hashed_password = $_SESSION['fr_password'] ?? '';

    if (!$email || !$hashed_password) {
        $_SESSION['message'] = "<div class='alert alert-danger'>Session expired. Please register again.</div>";
        header("Location: franchisee_register.php");
        exit;
    }

    // double-check email uniqueness before insert
    $check = $conn->prepare("SELECT id FROM franchisees WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        // already exists — update payment_id
        $check->close();
        $upd = $conn->prepare("UPDATE franchisees SET payment_id = ? WHERE email = ?");
        $upd->bind_param("ss", $payment_id, $email);
        $upd->execute();
        $upd->close();
    } else {
        $check->close();
        $stmt = $conn->prepare("INSERT INTO franchisees (name, email, phone, password, payment_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $hashed_password, $payment_id);
        if (!$stmt->execute()) {
            $stmt->close();
            $_SESSION['message'] = "<div class='alert alert-danger'>DB insert failed: " . htmlspecialchars($conn->error) . "</div>";
            header("Location: franchisee_register.php");
            exit;
        }
        $stmt->close();
    }

    // clear registration session data
    unset($_SESSION['fr_name'], $_SESSION['fr_email'], $_SESSION['fr_phone'], $_SESSION['fr_password'], $_SESSION['payment_amount_inr'], $_SESSION['rzp_order_id']);

    // redirect to login with success message
    $_SESSION['message'] = "<div class='alert alert-success'>Payment successful and account created. Please login.</div>";
    header("Location: franchisee_login.php");
    exit;

} else {
    // verification failed
    $_SESSION['message'] = "<div class='alert alert-danger'>Payment verification failed. Please contact support or try again.</div>";
    header("Location: franchisee_register.php");
    exit;
}
