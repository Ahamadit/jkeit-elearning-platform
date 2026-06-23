<?php
// franchisee_login.php
session_start();
include __DIR__ . '/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $error = "Provide valid email and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password FROM franchisees WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows === 1) {
            $row = $res->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // success
                $_SESSION['franchisee_id'] = $row['id'];
                $_SESSION['franchisee_name'] = $row['name'];
                header("Location: franchisee_dashboard.php");
                exit;
            } else {
                $error = "Invalid credentials.";
            }
        } else {
            $error = "No account found with that email.";
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Franchisee Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="col-md-5 mx-auto card p-4 shadow">
    <h3 class="mb-3 text-center">Franchisee Login</h3>
    <?php
      if (!empty($_SESSION['message'])) { echo $_SESSION['message']; unset($_SESSION['message']); }
      if (!empty($error)) echo "<div class='alert alert-danger'>{$error}</div>";
    ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control" required>
      </div>
      <button class="btn btn-success w-100" type="submit">Login</button>
    </form>
    <div class="text-center mt-3">
      New? <a href="franchisee_register.php">Register</a>
    </div>
  </div>
</div>
</body>
</html>
