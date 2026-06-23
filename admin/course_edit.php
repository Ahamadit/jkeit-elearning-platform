<?php
// ✅ Include database.php from parent folder
include __DIR__ . '/../database.php';

// Get course ID
if (!isset($_GET['id'])) {
    die("Course ID is required.");
}
$id = intval($_GET['id']);

// Fetch course details
$sql = "SELECT * FROM add_course WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("Course not found.");
}
$course = $result->fetch_assoc();

// Flag for success
$update_success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = $conn->real_escape_string($_POST['course_name']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $price = $conn->real_escape_string($_POST['price']);
    $duration = $conn->real_escape_string($_POST['duration']); // ✅ Added duration
    $image = $course['image']; // keep old image by default

    // If a new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $targetDir = __DIR__ . "/uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $image = $fileName;
        } else {
            echo "<p style='color:red;'>Image upload failed!</p>";
        }
    }

    // Update query including duration
    $update = "UPDATE add_course 
               SET course_name='$course_name', subject='$subject', price='$price', duration='$duration', image='$image' 
               WHERE id=$id";

    if ($conn->query($update)) {
        $update_success = true; // ✅ Trigger sweetalert
    } else {
        echo "<p style='color:red;'>Error updating course: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit Course</title>
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <style>
    body { background: #f9f9f9; }
    .container { max-width: 700px; margin-top: 40px; }
    .card { border-radius: 15px; }
    img.preview { max-width: 200px; margin-bottom: 15px; border-radius: 10px; }
  </style>
</head>

<body>
  <div class="container">
    <div class="card shadow p-4">
      <h3 class="mb-4 text-center text-primary">Edit Course</h3>
      <form method="POST" enctype="multipart/form-data">

        <!-- Course Name -->
        <div class="mb-3">
          <label class="form-label fw-bold">Course Name</label>
          <input type="text" name="course_name" class="form-control" 
                 value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
        </div>

        <!-- Subject -->
        <div class="mb-3">
          <label class="form-label fw-bold">Subject</label>
          <textarea name="subject" class="form-control" rows="3" required><?php echo htmlspecialchars($course['subject']); ?></textarea>
        </div>

        <!-- Price -->
        <div class="mb-3">
          <label class="form-label fw-bold">Price (₹)</label>
          <input type="number" name="price" class="form-control" 
                 value="<?php echo htmlspecialchars($course['price']); ?>" required>
        </div>

        <!-- Duration -->
        <div class="mb-3">
          <label class="form-label fw-bold">Duration</label>
          <input type="text" name="duration" class="form-control" 
                 value="<?php echo htmlspecialchars($course['duration']); ?>" placeholder="enter duration" required>
        </div>

        <!-- Image -->
        <div class="mb-3">
          <label class="form-label fw-bold">Course Image</label><br>
          <img src="uploads/<?php echo htmlspecialchars($course['image']); ?>" 
               alt="Current Image" class="preview"><br>
          <input type="file" name="image" class="form-control">
        </div>

        <!-- Submit -->
        <div class="text-center">
          <button type="submit" class="btn btn-success px-4">Update Course</button>
        </div>
      </form>
    </div>
  </div>

  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <?php if ($update_success): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Updated!',
      text: 'Course updated successfully',
      confirmButtonText: 'OK'
    }).then(() => {
      window.location.href = "course.php"; // ✅ Redirect after OK
    });
  </script>
  <?php endif; ?>
</body>
</html>
