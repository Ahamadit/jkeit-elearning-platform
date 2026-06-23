<?php
include __DIR__ . '/../database.php'; // adjust path if needed

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: study_material.php?msg=invalid_id");
    exit;
}

$id = (int) $_GET['id'];

// Delete from study_pdf using id
$sql = "DELETE FROM study_pdf WHERE id = $id";

if ($conn->query($sql) === TRUE && $conn->affected_rows > 0) {
    header("Location: study_material.php?msg=deleted");
    exit;
} else {
    header("Location: study_material.php?msg=notfound");
    exit;
}
