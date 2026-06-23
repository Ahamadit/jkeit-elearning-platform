<?php
include __DIR__ . '/../database.php';

if (!isset($_GET['id'])) {
    header("Location: partner.php");
    exit;
}

$id = $_GET['id'];

// Fetch existing logo
$result = $conn->query("SELECT * FROM logo WHERE id=$id");
if ($result->num_rows == 0) {
    header("Location: partner.php");
    exit;
}
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_file_name = $row['image']; // default: keep existing image

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // File details
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Allowed extensions
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed)) {
            // Create a unique file name
            $new_file_name = uniqid('logo_', true) . '.' . $file_ext;
            $upload_dir = 'uploads/';
            $upload_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Delete old image
                $old_path = $upload_dir . $row['image'];
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            } else {
                $error = "Failed to upload file.";
            }
        } else {
            $error = "Invalid file type. Allowed: jpg, jpeg, png, gif.";
        }
    }

    // Update database
    if (!isset($error)) {
        $stmt = $conn->prepare("UPDATE logo SET image=? WHERE id=?");
        $stmt->bind_param("si", $new_file_name, $id);
        if ($stmt->execute()) {
            header("Location: partner.php");
            exit;
        } else {
            $error = "Database error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Logo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Logo</h2>

        <?php if (isset($error)) : ?>
            <p class="text-red-500 text-center mb-4"><?= $error ?></p>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

            <!-- Current Logo -->
            <div class="text-center">
                <p class="text-gray-700 mb-2">Current Logo:</p>
                <img src="uploads/<?= $row['image'] ?>" alt="Logo" class="mx-auto h-32 object-contain rounded-lg mb-4">
            </div>

            <!-- Upload New Logo -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Upload New Logo (optional)</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-green-700 transition">
                    Update Logo
                </button>
            </div>
        </form>
    </div>

</body>
</html>
