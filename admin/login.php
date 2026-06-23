<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "Please enter email and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, email, password FROM admin_login WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['email']    = $user['email'];

                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Wrong password.";
            }
        } else {
            $error = "Admin not found.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <link rel="icon" href="../assets/logo/logo1.jpeg" type="image/jpeg">
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background: #f0f2f5;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .login-card {
      background: #fff;
      padding: 40px 30px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      max-width: 400px;
      width: 100%;
      text-align: center;
      animation: fadeIn 1s ease;
    }

    .login-card img {
      width: 100px;
      margin-bottom: 20px;
    }

    .login-card h2 {
      margin-bottom: 20px;
      font-size: 26px;
      color: #333;
    }

    .login-card input {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 16px;
    }

    .login-card button {
      width: 100%;
      padding: 12px;
      margin-top: 15px;
      border: none;
      border-radius: 6px;
      background: #007bff;
      color: #fff;
      font-size: 18px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .login-card button:hover {
      background: #0056b3;
    }

    .err {
      color: #c00;
      margin-bottom: 10px;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-20px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>
  <div class="login-card">
    <img src="../assets/logo/logo1.jpeg" alt="Admin Logo">
    <h2>Admin Login</h2>
    <?php if ($error): ?>
      <p class="err"><?= e($error) ?></p>
    <?php endif; ?>
    <form method="post">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
