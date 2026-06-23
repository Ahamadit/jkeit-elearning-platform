<?php
include __DIR__ . '/../database.php';

$showAlert = false;
$alertType = '';
$alertMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $fileName = $_FILES['image']['name'];
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($fileExt, $allowed)) {
            $newFileName = uniqid('poster_', true) . '.' . $fileExt;
            $uploadDir = __DIR__ . '/uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmp, $uploadPath)) {
                $stmt = $conn->prepare("INSERT INTO poster (image) VALUES (?)");
                $stmt->bind_param("s", $newFileName);
                if ($stmt->execute()) {
                    $showAlert = true;
                    $alertType = 'success';
                    $alertMsg = 'Poster uploaded successfully!';
                } else {
                    $showAlert = true;
                    $alertType = 'error';
                    $alertMsg = 'Database error: ' . $stmt->error;
                }
            } else {
                $showAlert = true;
                $alertType = 'error';
                $alertMsg = 'Failed to move uploaded file. Check folder permissions.';
            }
        } else {
            $showAlert = true;
            $alertType = 'error';
            $alertMsg = 'Invalid file type. Only JPG, PNG, GIF, WEBP allowed.';
        }
    } else {
        $showAlert = true;
        $alertType = 'error';
        $alertMsg = 'Please select an image to upload.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Poster</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add New Poster</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Poster Image</label>
                <input type="file" name="image" accept="image/*" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-blue-700 transition">
                    Add Poster
                </button>
            </div>
        </form>
    </div>

    <?php if ($showAlert): ?>
        <script>
            Swal.fire({
                icon: '<?php echo $alertType; ?>',
                title: '<?php echo $alertType === "success" ? "Success" : "Error"; ?>',
                text: '<?php echo addslashes($alertMsg); ?>',
                confirmButtonText: 'OK'
            }).then(() => {
                <?php if ($alertType === 'success'): ?>
                    window.location.href = 'poster.php';
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>

</body>
</html>
