<?php
// franchisee_register.php
session_start();
require __DIR__ . '/config.php';
include __DIR__ . '/database.php';

$amount_inr = 1; // change here if you want another static amount

// If form posted, validate and store in session then redirect to create_orders.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || strlen($password) < 6) {
        $_SESSION['message'] = "<div class='alert alert-danger'>Please provide valid name, email and password (min 6 chars).</div>";
        header("Location: franchisee_register.php");
        exit;
    }

    // check if email already exists
    $check = $conn->prepare("SELECT id FROM franchisees WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $_SESSION['message'] = "<div class='alert alert-danger'>Email already registered. Use another email or login.</div>";
        $check->close();
        header("Location: franchisee_register.php");
        exit;
    }
    $check->close();

    // Save to session (store hashed password)
    $_SESSION['fr_name'] = $name;
    $_SESSION['fr_email'] = $email;
    $_SESSION['fr_phone'] = $phone;
    $_SESSION['fr_password'] = password_hash($password, PASSWORD_DEFAULT);
    $_SESSION['payment_amount_inr'] = $amount_inr;

    // Ensure session data is written before redirecting to create_orders
    session_write_close();

    // redirect to create_orders.php
    header("Location: create_orders.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Franchisee Register - Pay ₹<?php echo number_format($amount_inr); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="col-md-6 mx-auto card p-4 shadow">
    <h3 class="mb-3 text-center">Franchisee Registration</h3>
    <?php
      if (!empty($_SESSION['message'])) { echo $_SESSION['message']; unset($_SESSION['message']); }
    ?>
    <div class="mb-3">
      <p class="lead text-center">Registration fee: <strong>₹<?php echo number_format($amount_inr); ?></strong></p>
    </div>
    <form method="post" novalidate>
      <div class="mb-3">
        <label class="form-label">Full name</label>
        <input name="name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Phone</label>
        <input name="phone" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Password (min 6 chars)</label>
        <input name="password" type="password" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100" type="submit">Proceed to Payment</button>
    </form>
    <div class="text-center mt-3">
      Already registered? <a href="franchisee_login.php">Login</a>
    </div>
  </div>
</div>
</body>
</html>
