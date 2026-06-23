<?php
session_start();

// Check if franchisee is logged in
if (!isset($_SESSION['franchisee_id'])) {
    header("Location: franchisee_login.php");
    exit;
}

$franchisee_name = $_SESSION['franchisee_name'] ?? 'Franchisee';

// Include database connection
include __DIR__ . '/database.php';

// Count total students added by this franchisee
$stmt = $conn->prepare("SELECT COUNT(*) AS total_students FROM franchisee_students WHERE franchisee_name = ?");
$stmt->bind_param("s", $franchisee_name);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_students = $row['total_students'] ?? 0;
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Franchisee Dashboard</title>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
    /* General */
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f0f4ff, #d9e4ff);
        min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
        height: 100vh;
        background: #1e1e2f;
        color: #fff;
        position: fixed;
        width: 250px;
        transition: all 0.3s;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }

    .sidebar h4 {
        font-weight: 600;
        letter-spacing: 1px;
        color: #fff;
    }

    .sidebar .nav-link {
        color: #ddd;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        transition: 0.3s;
        border-radius: 8px;
        margin: 4px 10px;
    }

    .sidebar .nav-link:hover {
        background: #007bff;
        color: #fff;
    }

    .sidebar .nav-link i {
        margin-right: 10px;
    }

    /* Content */
    .content {
        margin-left: 250px;
        padding: 20px;
        transition: all 0.3s;
    }

    .navbar {
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 10px;
        padding: 10px 20px;
        margin-bottom: 20px;
    }

    /* Card */
    .card-student {
        background: #fff;
        border-radius: 15px;
        padding: 40px 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card-student:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }

    .card-student i {
        font-size: 3rem;
        color: #007bff;
        margin-bottom: 15px;
    }

    .card-student h5 {
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }

    .card-student h3 {
        font-weight: 700;
        color: #007bff;
    }

    .toggle-btn {
        border: none;
        background: none;
        color: #000;
        font-size: 1.2rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .sidebar {
            width: 220px;
            position: absolute;
            left: -250px;
        }
        .sidebar.active {
            left: 0;
        }
        .content {
            margin-left: 0;
        }
    }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h4 class="text-center py-4 border-bottom">🏢 Franchisee</h4>
    <nav class="nav flex-column">
        <a href="#" class="nav-link active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="franchisee_student.php" class="nav-link"><i class="fa-solid fa-user-plus"></i> Add Students</a>
        <a href="franchisee_logout.php" class="nav-link text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </nav>
</div>

<!-- Content -->
<div class="content">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <button class="toggle-btn" id="menu-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>
            <span class="navbar-brand ms-3 fw-bold text-primary">Welcome, <?php echo htmlspecialchars($franchisee_name); ?>!</span>
        </div>
    </nav>

    <!-- Dashboard Card -->
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card-student text-center">
                <i class="fa-solid fa-user-graduate"></i>
                <h5>Total Students</h5>
                <h3><?php echo $total_students; ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar toggle for mobile
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
    });
</script>

</body>
</html>
