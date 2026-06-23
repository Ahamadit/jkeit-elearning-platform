<?php
session_start();
if (!isset($_SESSION['franchisee_id'])) {
    header("Location: franchisee_login.php");
    exit;
}

include __DIR__ . '/database.php';

$franchisee_name = $_SESSION['franchisee_name'];
$message = '';
$show_sweetalert = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = trim($_POST['student_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $mobile = trim($_POST['mobile']);
    $course_name = trim($_POST['course_name']);


    if ($student_name && $email && $password && $mobile) {
        $stmt = $conn->prepare("INSERT INTO franchisee_students (franchisee_name, name, email, password, mobile, course, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $franchisee_name, $student_name, $email, $password, $mobile, $course_name);

        if ($stmt->execute()) {
            $show_sweetalert = true; // <-- trigger SweetAlert
        } else {
            $message = "<div class='alert alert-danger text-center'>❌ Something went wrong. Try again!</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='alert alert-warning text-center'>⚠️ Please fill in all fields!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student | Franchisee Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #007bff, #00c6ff);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 450px;
        }

        .form-card h3 {
            color: #007bff;
            font-weight: 600;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-custom {
            border-radius: 10px;
            background: #007bff;
            color: #fff;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: #0056b3;
        }

        .back-btn {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }

        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="form-card">
        <h3 class="text-center mb-3"><i class="fa-solid fa-user-plus me-2"></i>Add New Student</h3>

        <?= $message ?>

        <form method="POST" action="">
            <!-- Auto-filled Franchisee Name -->
            <div class="mb-3">
                <label class="form-label"><i class="fa-solid fa-user-tie me-1"></i> Franchisee Name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($franchisee_name) ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="student_name" class="form-label"><i class="fa-solid fa-user me-1"></i> Student Name</label>
                <input type="text" name="student_name" id="student_name" class="form-control" placeholder="Enter name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label"><i class="fa-solid fa-envelope me-1"></i> Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label"><i class="fa-solid fa-lock me-1"></i> Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
            </div>

            <div class="mb-3">
                <label for="mobile" class="form-label"><i class="fa-solid fa-phone me-1"></i> Mobile Number</label>
                <input type="number" name="mobile" id="mobile" class="form-control" placeholder="Enter number" required pattern="[0-9]{10}" maxlength="10">
            </div>

            <div class="mb-3">
                <label for="course_name" class="form-label"><i class="fa-solid fa-book me-1"></i> Course Name</label>
                <input type="text" name="course_name" id="course_name" class="form-control" placeholder="Enter course name" required>
            </div>


            <div class="d-grid">
                <button type="submit" class="btn btn-custom"><i class="fa-solid fa-paper-plane me-1"></i> Submit</button>
            </div>

            <div class="text-center mt-3">
                <a href="franchisee_student.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if ($show_sweetalert): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Added!',
                text: 'Student added successfully.',
                confirmButtonColor: '#007bff'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "franchisee_student.php"; // redirect after popup
                }
            });
        </script>
    <?php endif; ?>
</body>

</html>