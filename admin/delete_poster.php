<?php
// delete_poster.php

session_start();
include __DIR__ . '/../database.php'; // Adjust path

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Get the image filename
    $stmt = $conn->prepare("SELECT image FROM poster WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $poster = $result->fetch_assoc();
        $imageFile = __DIR__ . '/uploads/' . $poster['image'];

        // Delete record from poster table
        $deleteStmt = $conn->prepare("DELETE FROM poster WHERE id = ?");
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            // Delete image file
            if (!empty($poster['image']) && file_exists($imageFile)) {
                unlink($imageFile);
            }
            $_SESSION['success'] = "Poster deleted successfully!";
        } else {
            $_SESSION['error'] = "Error deleting poster: " . $deleteStmt->error;
        }

        $deleteStmt->close();
    } else {
        $_SESSION['error'] = "Poster not found.";
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request.";
}

// Redirect back to poster page
header("Location: poster.php");
exit;
?>
