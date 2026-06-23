<?php
session_start();
require __DIR__ . '/config.php';
include __DIR__ . '/admin/../database.php';

// Get course_id from URL
$course_id = $_GET['course_id'] ?? null;

if (!$course_id) {
    die("❌ Course not selected. Please go back and choose a course.");
}

// Fetch course details
$stmt = $conn->prepare("SELECT course_name, price FROM add_course WHERE id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $course_name = $row['course_name'];
    $course_price = $row['price']; // INR
} else {
    die("❌ Course not found.");
}
$stmt->close();

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg,#6a11cb,#2575fc);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      background: rgba(255,255,255,.15);
      backdrop-filter: blur(15px);
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,.2);
      padding: 40px;
      max-width: 420px;
      width: 100%;
      color: #fff;
      text-align: center;
    }
    .form-control {
      border-radius: 30px;
      padding: 12px 15px;
      border: none;
      outline: none;
    }
    .form-control:focus {
      box-shadow: 0 0 10px rgba(37,117,252,.6);
    }
    .btn-custom {
      background: linear-gradient(to right,#6a11cb,#2575fc);
      color: #fff;
      border-radius: 30px;
      padding: 12px;
      border: none;
      font-weight: 600;
      transition: .3s;
    }
    .btn-custom:hover {
      background: linear-gradient(to right,#2575fc,#6a11cb);
      transform: translateY(-2px);
    }
    .error {
      color: #ff4d4d;
      background: rgba(255,255,255,.2);
      padding: 8px;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    .success {
      color: #00ff99;
      background: rgba(255,255,255,.2);
      padding: 8px;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    .form-label {
      float: left;
      margin-left: 10px;
      font-weight: 500;
    }
    .show-password {
      display: none;
      font-size: 14px;
      margin-top: 8px;
      text-align: left;
    }
    a {
      color: #fff;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="card">
    <h3>Create Your Account</h3>
    <?php if (!empty($message)) echo $message; ?>

    <!-- Form submits to create_order.php -->
    <form method="POST" action="create_order.php">
      <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">

      <div class="mb-3 text-start">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required placeholder="Enter email">
      </div>

      <div class="mb-3 text-start">
        <label class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" required placeholder="Enter password" minlength="6" oninput="toggleShowOption()">
        <div class="form-check show-password" id="showPasswordOption">
          <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
          <label class="form-check-label" for="showPassword">Show Password</label>
        </div>
      </div>

      <button type="submit" class="btn btn-custom w-100">
        Register & Pay ₹<?php echo $course_price; ?>
      </button>
    </form>

    <p class="mt-3 mb-0">Already have an account? 
      <a href="login.php?course_id=<?php echo $course_id; ?>">Login</a>
    </p>
  </div>

  <script>
    const passwordInput = document.getElementById("password");
    const showPasswordOption = document.getElementById("showPasswordOption");

    function togglePassword() {
      const checkbox = document.getElementById("showPassword");
      passwordInput.type = checkbox.checked ? "text" : "password";
    }

    function toggleShowOption() {
      if (passwordInput.value.length > 0) {
        showPasswordOption.style.display = "block";
      } else {
        showPasswordOption.style.display = "none";
        document.getElementById("showPassword").checked = false;
        passwordInput.type = "password";
      }
    }
  </script>
</body>
</html>

