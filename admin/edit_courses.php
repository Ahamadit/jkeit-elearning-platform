<?php
session_start();
include __DIR__ . '/../database.php';

if (!isset($_GET['id'])) {
    // Redirect if no ID is provided
    header("Location: courses.php");
    exit;
}

$id = intval($_GET['id']);

// Fetch existing course
$stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['error'] = "Course not found.";
    header("Location: courses.php");
    exit;
}

$course = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $uploadDir = __DIR__ . '/uploads/';
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $uploadPath)) {
            // Optionally delete old PDF
            if (!empty($course['pdf']) && file_exists($uploadDir . $course['pdf'])) {
                unlink($uploadDir . $course['pdf']);
            }

            // Update database
            $stmt = $conn->prepare("UPDATE courses SET pdf = ? WHERE id = ?");
            $stmt->bind_param("si", $fileName, $id);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Course updated successfully!";
            } else {
                $_SESSION['error'] = "Database error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $_SESSION['error'] = "Failed to upload file.";
        }
    } else {
        $_SESSION['error'] = "Please select a PDF file.";
    }

    header("Location: edit_courses.php?id=$id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Course</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

            <!-- Current PDF -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Current PDF:</label>
                <a href="uploads/<?= $course['pdf']; ?>" target="_blank" class="text-blue-600 underline">
                    <?= $course['pdf']; ?>
                </a>
            </div>

            <!-- PDF Upload -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Replace PDF</label>
                <input type="file" name="image" accept="application/pdf" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-green-700 transition">
                    Update Course
                </button>
            </div>
        </form>
    </div>

    <script>
        <?php if(isset($_SESSION['success'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?= $_SESSION['success']; ?>',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'courses.php';
        });
        <?php unset($_SESSION['success']); endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= $_SESSION['error']; ?>',
            confirmButtonText: 'OK'
        });
        <?php unset($_SESSION['error']); endif; ?>
    </script>

</body>
</html>
