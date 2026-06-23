<?php
include __DIR__ . '/../database.php'; // adjust path if needed

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: video_class.php?msg=invalid_id");
    exit;
}

$video_id = (int) $_GET['id'];

// Delete from video_class using id
$sql = "DELETE FROM video_class WHERE id = $video_id";

if ($conn->query($sql) === TRUE && $conn->affected_rows > 0) {
    header("Location: video_class.php?msg=deleted");
    exit;
} else {
    header("Location: video_class.php?msg=notfound");
    exit;
}
?>
