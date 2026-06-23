<?php
include __DIR__ . '/../database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: exam.php?msg=invalid_id");
    exit;
}

$id = (int) $_GET['id'];

// Delete query
$sql = "DELETE FROM add_exam WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: exam.php?msg=deleted");
    exit;
} else {
    header("Location: exam.php?msg=error");
    exit;
}
