<?php
include 'database.php';
session_start();

$message = "";

// Preserve course_id from GET or POST
$course_id = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // prefer POST (hidden field), fallback to GET
    $course_id = isset($_POST['course_id']) ? (int)$_POST['course_id'] : (isset($_GET['course_id']) ? (int)$_GET['course_id'] : null);
} else {
    $course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : null;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='error'>❌ Please enter a valid email.</div>";
    } else {
        // select course_id as well (if column exists)
        $sql = "SELECT id, email, password, course_id FROM student_login WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            // db prepare error
            $message = "<div class='error'>❌ Database error: " . htmlspecialchars($conn->error) . "</div>";
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($row = $res->fetch_assoc()) {
                if (!password_verify($password, $row['password'])) {
                    $message = "<div class='error'>❌ Incorrect password!</div>";
                } else {
                    // If a course_id was provided in the URL/form, enforce matching course_id stored for the user
                    if ($course_id) {
                        // If DB returned course_id field (column exists)
                        if (array_key_exists('course_id', $row)) {
                            // If stored course_id is empty/null -> treat as not registered for any course
                            if (empty($row['course_id'])) {
                                $message = "<div class='error'>❌ Your account is not linked to any course. Please register for the selected course first.</div>";
                            } elseif ((int)$row['course_id'] !== (int)$course_id) {
                                $message = "<div class='error'>❌ You are not registered for this course!</div>";
                            } else {
                                // Login OK and course matches
                                session_regenerate_id(true);
                                $_SESSION['user_id'] = $row['id'];
                                $_SESSION['email']   = $row['email'];
                                $_SESSION['course_id'] = (int)$row['course_id'];
                                header("Location: dashboard.php");
                                exit;
                            }
                        } else {
                            // course_id column doesn't exist in DB: fall back to original behaviour (allow login)
                            session_regenerate_id(true);
                            $_SESSION['user_id'] = $row['id'];
                            $_SESSION['email']   = $row['email'];
                            // no course_id to store
                            header("Location: dashboard.php");
                            exit;
                        }
                    } else {
                        // No course specified on login URL — normal login (no course check)
                        session_regenerate_id(true);
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['email']   = $row['email'];
                        $_SESSION['course_id'] = $row['course_id'] ?? null;
                        header("Location: dashboard.php");
                        exit;
                    }
                }
            } else {
                $message = "<div class='error'>❌ User not found!</div>";
            }

            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #6a11cb, #2575fc);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-card {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
      padding: 50px 40px;
      max-width: 420px;
      width: 100%;
      color: #fff;
      text-align: center;
    }
    .login-card h3 {
      font-weight: 600;
      margin-bottom: 25px;
      line-height: 1.4;
    }
    .form-control {
      border-radius: 30px;
      padding: 12px 15px;
      border: none;
      outline: none;
    }
    .form-control:focus {
      box-shadow: 0 0 12px rgba(37, 117, 252, 0.6);
    }
    .btn-custom {
      background: linear-gradient(to right, #6a11cb, #2575fc);
      color: #fff;
      border-radius: 30px;
      padding: 12px;
      border: none;
      font-weight: 600;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background: linear-gradient(to right, #2575fc, #6a11cb);
      transform: translateY(-2px);
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
    .error { color: #ff4d4d; background: rgba(255,255,255,.06); padding: 8px; border-radius: 8px; margin-bottom: 15px; }
  </style>
</head>
<body>
  <div class="login-card">
    <h3>Welcome To<br>JAN KALYAN EDUCATIONAL INSTITUTE OF TECHNOLOGY</h3>

    <?php if (!empty($message)) echo $message; ?>

    <form method="POST" action="">
      <!-- keep course_id so it persists to POST -->
      <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">

      <div class="mb-3 text-start">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required placeholder="Enter email">
      </div>

      <div class="mb-3 text-start">
        <label class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" required placeholder="Enter password" oninput="toggleShowOption()">
        <div class="form-check show-password" id="showPasswordOption">
          <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
          <label class="form-check-label" for="showPassword">Show Password</label>
        </div>
      </div>

      <button type="submit" class="btn btn-custom w-100">Login</button>
    </form>

    <p class="mt-3 mb-0">New here? 
      <a href="register.php?course_id=<?php echo htmlspecialchars($course_id); ?>">Create an account</a>
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
