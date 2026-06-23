<?php
// delete_courses.php

session_start();
include __DIR__ . '/../database.php'; // Adjust path if needed

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Make sure ID is an integer

    // Get the PDF filename before deleting
    $stmt = $conn->prepare("SELECT pdf FROM courses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
        $pdfFile = __DIR__ . '/uploads/' . $course['pdf'];

        // Delete the database record
        $deleteStmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            // Delete the PDF file from uploads folder if it exists
            if (!empty($course['pdf']) && file_exists($pdfFile)) {
                unlink($pdfFile);
            }
            $_SESSION['success'] = "Course deleted successfully!";
        } else {
            $_SESSION['error'] = "Error deleting course: " . $deleteStmt->error;
        }

        $deleteStmt->close();
    } else {
        $_SESSION['error'] = "Course not found.";
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request.";
}

// Redirect back to courses page
header("Location: courses.php");
exit;
?>
