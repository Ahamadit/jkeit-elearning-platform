<?php
include __DIR__ . '/../database.php';

$showAlert = false;
$alertType = '';
$alertMsg = '';
$poster = null;

// Get poster ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Poster ID.");
}

$posterId = intval($_GET['id']);

// Fetch existing poster
$stmt = $conn->prepare("SELECT * FROM poster WHERE id = ?");
$stmt->bind_param("i", $posterId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Poster not found.");
}
$poster = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $newFileName = $poster['image']; // default: keep existing image

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

            if (!move_uploaded_file($fileTmp, $uploadPath)) {
                $showAlert = true;
                $alertType = 'error';
                $alertMsg = 'Failed to move uploaded file. Check folder permissions.';
            } else {
                // Optionally delete old image
                if (file_exists($uploadDir . $poster['image'])) {
                    unlink($uploadDir . $poster['image']);
                }
            }
        } else {
            $showAlert = true;
            $alertType = 'error';
            $alertMsg = 'Invalid file type. Only JPG, PNG, GIF, WEBP allowed.';
        }
    }

    if (!$showAlert) {
        // Update database
        $stmt = $conn->prepare("UPDATE poster SET image = ? WHERE id = ?");
        $stmt->bind_param("si", $newFileName, $posterId);
        if ($stmt->execute()) {
            $showAlert = true;
            $alertType = 'success';
            $alertMsg = 'Poster updated successfully!';
            $poster['image'] = $newFileName; // update current image
        } else {
            $showAlert = true;
            $alertType = 'error';
            $alertMsg = 'Database error: ' . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Poster</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Poster</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Current Poster</label>
                <img src="uploads/<?php echo htmlspecialchars($poster['image']); ?>" alt="Poster"
                    class="w-full max-h-64 object-contain border border-gray-300 rounded-lg mb-3">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Change Poster Image (optional)</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-green-700 transition">
                    Update Poster
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
