<?php
// Start session for SweetAlert message
session_start();
include __DIR__ . '/../database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['image']['name']); // unique name
        $uploadDir = __DIR__ . '/uploads/';
        $uploadPath = $uploadDir . $fileName;

        // Move uploaded file
        if (move_uploaded_file($fileTmp, $uploadPath)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO courses (pdf) VALUES (?)");
            $stmt->bind_param("s", $fileName);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Course added successfully!";
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

    // Redirect to self to show SweetAlert
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add New Courses</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

            <!-- PDF Upload -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Courses PDF</label>
                <input type="file" name="image" accept="application/pdf" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-blue-700 transition">
                    Add Courses
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
