<?php
include __DIR__ . '/../database.php';

// Get question ID and exam ID from query
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['exam_id']) || !is_numeric($_GET['exam_id'])) {
    die("Invalid request.");
}

$question_id = (int) $_GET['id'];
$exam_id = (int) $_GET['exam_id'];

// Delete the question
$stmt = $conn->prepare("DELETE FROM exam_questions WHERE id=? AND exam_id=?");
$stmt->bind_param("ii", $question_id, $exam_id);

if ($stmt->execute()) {
    header("Location: question.php?exam_id=$exam_id&msg=deleted");
    exit;
} else {
    echo "Error deleting question.";
}
?>
