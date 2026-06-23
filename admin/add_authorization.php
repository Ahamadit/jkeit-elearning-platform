<?php
// Include your database connection
include __DIR__ . '/../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $heading = $_POST['heading'];
    $paragraph = $_POST['paragraph'];

    // Handle image upload
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $uploadDir = __DIR__ . '/uploads/authorization/'; // Server folder

    // Create upload folder if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $targetFile = $uploadDir . basename($imageName);
    $filename = basename($imageName); // Store only filename in DB

    if (move_uploaded_file($imageTmp, $targetFile)) {
        // Save to database
        $sql = "INSERT INTO authorization (image, heading, paragraph) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $filename, $heading, $paragraph);

        if ($stmt->execute()) {
            echo "<script>alert('authorization added successfully!'); window.location.href='authorization.php';</script>";
        } else {
            echo "<script>alert('Database error: Unable to save data');</script>";
        }
    } else {
        echo "<script>alert('Image upload failed!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New authorization</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add New Authorization</h2>

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

      <!-- Image Upload -->
      <div>
        <label class="block text-gray-700 font-medium mb-2">Upload Image</label>
        <input type="file" name="image" accept="image/*" required
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Heading -->
      <div>
        <label class="block text-gray-700 font-medium mb-2">Heading</label>
        <input type="text" name="heading" placeholder="Enter heading" required
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Paragraph -->
      <div>
        <label class="block text-gray-700 font-medium mb-2">Paragraph</label>
        <textarea name="paragraph" placeholder="Enter paragraph content" required
          class="w-full border border-gray-300 rounded-lg px-3 py-2 h-32 resize-y focus:outline-none focus:ring-2 focus:ring-blue-400 overflow-y-auto"></textarea>
      </div>

      <!-- Submit Button -->
      <div>
        <button type="submit"
          class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-blue-700 transition">
          Submit
        </button>
      </div>

    </form>
  </div>

</body>
</html>
