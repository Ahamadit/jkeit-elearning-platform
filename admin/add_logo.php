<?php
include __DIR__ . '/../database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

        // File details
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_size = $_FILES['image']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Allowed extensions
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed)) {
            // Create a unique file name to avoid overwriting
            $new_file_name = uniqid('logo_', true) . '.' . $file_ext;
            $upload_dir = 'uploads/'; // Make sure this folder exists and is writable
            $upload_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Insert into database
                $stmt = $conn->prepare("INSERT INTO logo (image) VALUES (?)");
                $stmt->bind_param("s", $new_file_name);
                if ($stmt->execute()) {
                    // Redirect to partner.php after success
                    header("Location: partner.php");
                    exit;
                } else {
                    $error = "Database error: " . $stmt->error;
                }
            } else {
                $error = "Failed to upload file.";
            }
        } else {
            $error = "Invalid file type. Allowed: jpg, jpeg, png, gif.";
        }
    } else {
        $error = "Please select an image to upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Logo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add New Logo</h2>

        <?php if (isset($error)) : ?>
            <p class="text-red-500 text-center mb-4"><?= $error ?></p>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

            <!-- Logo Image -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Logo Image</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-blue-700 transition">
                    Add Logo
                </button>
            </div>
        </form>
    </div>

</body>

</html>
