<?php
include __DIR__ . '/../database.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // First, fetch the image name to delete the file
    $stmt = $conn->prepare("SELECT image FROM banner WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = __DIR__ . '/uploads/' . $row['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // delete image file
        }
    }
    $stmt->close();

    // Delete banner from database
    $stmt = $conn->prepare("DELETE FROM banner WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: banner.php");
exit;
?>
