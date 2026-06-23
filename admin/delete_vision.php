<?php
// delete_vision.php
include __DIR__ . '/../database.php'; // adjust path if needed

if (!isset($_GET['id'])) {
    header("Location: vision.php");
    exit();
}

$id = intval($_GET['id']);
if ($id <= 0) {
    header("Location: vision.php?msg=notfound");
    exit();
}

// Prepare and fetch image filename
$stmt = $conn->prepare("SELECT image FROM vision WHERE id = ?");
if (!$stmt) {
    header("Location: vision.php?msg=error");
    exit();
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $imageFile = $row['image'];

    // sanitize filename to avoid directory traversal
    $imageFile = basename($imageFile);

    // construct absolute path to image
    $imagePath = __DIR__ . "/uploads/vision/" . $imageFile;

    // delete image file if exists and is file
    if (!empty($imageFile) && file_exists($imagePath) && is_file($imagePath)) {
        @unlink($imagePath);
    }

    // now delete the DB record
    $del = $conn->prepare("DELETE FROM vision WHERE id = ?");
    if (!$del) {
        header("Location: vision.php?msg=error");
        exit();
    }
    $del->bind_param("i", $id);

    if ($del->execute()) {
        header("Location: vision.php?msg=deleted");
        exit();
    } else {
        header("Location: vision.php?msg=error");
        exit();
    }

} else {
    // record not found
    header("Location: vision.php?msg=notfound");
    exit();
}
?>
