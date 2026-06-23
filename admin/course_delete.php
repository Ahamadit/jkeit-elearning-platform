<?php
// Include database
include __DIR__ . '/../database.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    die("Course ID is required.");
}

$id = intval($_GET['id']);

// Get course image to delete
$sql = "SELECT image FROM add_course WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $course = $result->fetch_assoc();
    $imageFile = __DIR__ . "/uploads/" . $course['image'];
    if (file_exists($imageFile)) {
        unlink($imageFile); // delete image file
    }
}

// Delete from database
$delete = "DELETE FROM add_course WHERE id=$id";
$status = $conn->query($delete) ? 'success' : 'error';
$message = $conn->query($delete) ? 'Course deleted successfully' : 'Failed to delete course';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Course</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
    Swal.fire({
        icon: '<?php echo $status; ?>',
        title: '<?php echo ucfirst($status); ?>!',
        text: '<?php echo $message; ?>',
        showConfirmButton: false,
        timer: 2000
    }).then(() => {
        window.location.href = 'course.php';
    });
</script>
</body>
</html>
