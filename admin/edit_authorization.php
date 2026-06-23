<?php
// Include database connection
include __DIR__ . '/../database.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location.href='authorization.php';</script>";
    exit();
}

$id = intval($_GET['id']);

// Fetch existing vision data
$query = "SELECT * FROM authorization WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('authorization not found!'); window.location.href='authorization.php';</script>";
    exit();
}

$vision = $result->fetch_assoc();

// Handle form submission (update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $heading = $_POST['heading'];
    $paragraph = $_POST['paragraph'];
    $oldImage = $_POST['old_image'];
    $newImageName = $oldImage;

    // Handle image update
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/uploads/authorization/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $newImageName = basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $newImageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Delete old image from server
            $oldPath = $uploadDir . $oldImage;
            if (file_exists($oldPath) && $oldImage != '') {
                unlink($oldPath);
            }
        } else {
            echo "<script>alert('Image upload failed!');</script>";
        }
    }

    // Update record in database
    $updateQuery = "UPDATE authorization SET image = ?, heading = ?, paragraph = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssi", $newImageName, $heading, $paragraph, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Authorization updated successfully!'); window.location.href='authorization.php';</script>";
    } else {
        echo "<script>alert('Error updating record!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Authorization</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit authorization</h2>

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

      <!-- Current Image Preview -->
      <div class="text-center">
        <p class="text-gray-700 font-medium mb-2">Current Image</p>
        <?php if (!empty($vision['image'])): ?>
          <img src="uploads/vision/<?php echo htmlspecialchars($vision['image']); ?>" 
               alt="Vision Image" 
               class="mx-auto rounded-lg shadow-md border w-[100px] h-[100px] object-cover">
        <?php else: ?>
          <p class="text-gray-500 italic">No image available</p>
        <?php endif; ?>
      </div>

      <!-- Image Upload -->
      <div>
        <label class="block text-gray-700 font-medium mb-2">Change Image (optional)</label>
        <input type="file" name="image" accept="image/*"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($vision['image']); ?>">
      </div>

      <!-- Heading -->
      <div>
        <label class="block text-gray-700 font-medium mb-2">Heading</label>
        <input type="text" name="heading" required
          value="<?php echo htmlspecialchars($vision['heading']); ?>"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Paragraph -->
      <div>
        <label class="block text-gray-700 font-medium mb-2">Paragraph</label>
        <textarea name="paragraph" required
          class="w-full border border-gray-300 rounded-lg px-3 py-2 h-32 resize-y focus:outline-none focus:ring-2 focus:ring-blue-400 overflow-y-auto"><?php echo htmlspecialchars($vision['paragraph']); ?></textarea>
      </div>

      <!-- Submit Button -->
      <div>
        <button type="submit"
          class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-green-700 transition">
          Update Authorization
        </button>
      </div>

    </form>
  </div>

</body>
</html>
