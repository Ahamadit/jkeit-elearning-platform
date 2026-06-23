<?php
// Include database connection
include __DIR__ . '/../database.php'; // adjust path if needed

// Get the ID from the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: jkeit_team.php");
    exit;
}

$id = intval($_GET['id']);

// Fetch the existing team member data
$stmt = $conn->prepare("SELECT * FROM jkeit_team WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Team member not found!'); window.location.href='jkeit_team.php';</script>";
    exit;
}

$team = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $role = trim($_POST['role']);
    $details = trim($_POST['details']);

    $update = $conn->prepare("UPDATE jkeit_team SET name = ?, role = ?, details = ? WHERE id = ?");
    $update->bind_param("sssi", $name, $role, $details, $id);

    if ($update->execute()) {
        echo "<script>
                alert('Team member updated successfully!');
                window.location.href = 'jkeit_team.php';
              </script>";
        exit;
    } else {
        echo "<script>alert('Error: Unable to update data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Team Member</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <div class="w-full max-w-2xl bg-white shadow-lg rounded-2xl p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Edit Team Member</h2>

    <form action="" method="POST" class="space-y-6">

      <!-- Name -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Name</label>
        <input type="text" name="name" placeholder="Enter full name" required
          value="<?= htmlspecialchars($team['name']); ?>"
          class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 
                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      </div>

      <!-- Role -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Role</label>
        <input type="text" name="role" placeholder="Enter Role" required
          value="<?= htmlspecialchars($team['role']); ?>"
          class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 
                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      </div>

      <!-- Details -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Details</label>
        <textarea name="details" rows="4" placeholder="Enter details about the person..."
          class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 
                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-y"><?= htmlspecialchars($team['details']); ?></textarea>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-center">
        <button type="submit"
          class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg shadow-md transition-all">
          Update
        </button>
      </div>

    </form>
  </div>

</body>
</html>
