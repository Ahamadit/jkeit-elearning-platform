<?php
// Include database connection
include __DIR__ . '/../database.php'; // adjust path if needed

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // get the team member ID safely

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM jkeit_team WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to jkeit_team.php after deletion
        echo "<script>
                alert('Team member deleted successfully!');
                window.location.href = 'jkeit_team.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Error: Unable to delete team member!');
                window.location.href = 'jkeit_team.php';
              </script>";
        exit;
    }
} else {
    header("Location: jkeit_team.php");
    exit;
}
?>
