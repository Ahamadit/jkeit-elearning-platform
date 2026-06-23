<?php
// delete_prospects.php
include __DIR__ . '/../database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // ensure ID is integer

    // Check if record exists
    $checkSql = "SELECT * FROM prospect WHERE id = $id";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        // Delete the record
        $deleteSql = "DELETE FROM prospect WHERE id = $id";
        if ($conn->query($deleteSql) === TRUE) {
            session_start();
            $_SESSION['success'] = "Prospect deleted successfully.";
        } else {
            session_start();
            $_SESSION['error'] = "Error deleting prospect: " . $conn->error;
        }
    } else {
        session_start();
        $_SESSION['error'] = "Prospect not found.";
    }
} else {
    session_start();
    $_SESSION['error'] = "Invalid request.";
}

// Redirect back to prospects page
header("Location: prospects.php");
exit;
?>
