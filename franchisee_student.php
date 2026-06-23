<?php
session_start();

// Check if franchisee is logged in
if (!isset($_SESSION['franchisee_id'])) {
    header("Location: franchisee_login.php");
    exit;
}

$franchisee_name = $_SESSION['franchisee_name'] ?? 'Franchisee';

include __DIR__ . '/database.php';

// Handle delete if id is passed
if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Delete only if the record belongs to this franchisee
    $stmt_del = $conn->prepare("DELETE FROM franchisee_students WHERE id = ? AND franchisee_name = ?");
    $stmt_del->bind_param("is", $delete_id, $franchisee_name);
    $stmt_del->execute();
    $stmt_del->close();
    $deleted = true;
} else {
    $deleted = false;
}

// Fetch students data for logged-in franchisee only
$stmt = $conn->prepare("SELECT * FROM franchisee_students WHERE franchisee_name = ? ORDER BY id DESC");
$stmt->bind_param("s", $franchisee_name);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Franchisee Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f5f6fa; }
        .sidebar { height: 100vh; background: #1e1e2f; color: #fff; position: fixed; width: 250px; }
        .sidebar .nav-link { color: #ddd; padding: 12px 20px; display: flex; align-items: center; }
        .sidebar i { margin-right: 10px; }
        .content { margin-left: 250px; padding: 20px; }
        .navbar { background-color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .card { border: none; border-radius: 10px; }
        .toggle-btn { border: none; background: none; color: #000; }
        @media (max-width: 992px) {
            .sidebar { left: -250px; position: absolute; }
            .sidebar.active { left: 0; }
            .content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h4 class="text-center py-4 border-bottom">🏢 Franchisee</h4>
        <nav class="nav flex-column">
            <a href="franchisee_dashboard.php" class="nav-link active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            <a href="franchisee_student.php" class="nav-link"><i class="fa-solid fa-user-plus"></i> Add Students</a>
            <a href="franchisee_logout.php" class="nav-link text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </nav>
    </div>

    <!-- Content -->
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="toggle-btn" id="menu-toggle"><i class="fa-solid fa-bars"></i></button>
                <span class="navbar-brand ms-3 fw-bold text-primary">
                    Welcome, <?= htmlspecialchars($franchisee_name); ?>!
                </span>
            </div>
        </nav>

        <!-- Student Table -->
        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fa-solid fa-users me-2"></i>Student Records</h5>
                <a href="franchisee_add_student.php" class="btn btn-light btn-sm">
                    <i class="fa-solid fa-plus"></i> Add New
                </a>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-striped align-middle table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Mobile</th>
                             <th>Course</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= htmlspecialchars($row['name']); ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                    <td><?= htmlspecialchars($row['password']); ?></td>
                                    <td><?= htmlspecialchars($row['mobile']); ?></td>
                                     <td><?= htmlspecialchars($row['course']); ?></td>
                                    <td><?= htmlspecialchars($row['created_at']); ?></td>
                                    <td>
                                        <a href="franchisee_edit_student.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $row['id']; ?>)">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">No records found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "franchisee_student.php?delete_id=" + id;
                }
            });
        }

        <?php if ($deleted): ?>
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Student record deleted successfully.',
            confirmButtonColor: '#007bff'
        }).then(() => {
            window.location.href = "franchisee_student.php";
        });
        <?php endif; ?>
    </script>
</body>
</html>
