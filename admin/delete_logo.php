<?php
include __DIR__ . '/../database.php'; // your DB connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the image file name
    $result = $conn->query("SELECT image FROM add_course WHERE id=$id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = "uploads/" . $row['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // delete the image from server
        }
    }

    // Delete record from database
    $conn->query("DELETE FROM logo WHERE id=$id");

    // Redirect back to list
    header("Location: partner.php");
    exit;
}
?>
