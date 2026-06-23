<?php
// Include your database connection
include __DIR__ . '/../database.php'; // adjust path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data safely
    $name = trim($_POST['name']);
    $role = trim($_POST['role']);
    $details = trim($_POST['details']);

    // Prepare and execute SQL query
    $stmt = $conn->prepare("INSERT INTO jkeit_team (name, role, details) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $role, $details);

    if ($stmt->execute()) {
        echo "<script>
                alert('Team member added successfully!');
                window.location.href = 'jkeit_team.php';
              </script>";
        exit;
    } else {
        echo "<script>alert('Error: Unable to save data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Team Member</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <div class="w-full max-w-2xl bg-white shadow-lg rounded-2xl p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Add Team Member</h2>

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">

      <!-- Name -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Name</label>
        <input type="text" name="name" placeholder="Enter full name" required
          class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 
                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      </div>

      <!-- Role -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Role</label>
        <input type="text" name="role" placeholder="Enter Role" required
          class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 
                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      </div>

      <!-- Details -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Details</label>
        <textarea name="details" rows="4" placeholder="Enter details about the person..."
          class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 
                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-y"></textarea>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-center">
        <button type="submit"
          class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-md transition-all">
          Submit
        </button>
      </div>

    </form>
  </div>

</body>
</html>
