<?php
session_start();
include __DIR__ . '/database.php';

// Check if exam info and questions exist in session
if (!isset($_SESSION['exam_info'], $_SESSION['exam_questions'])) {
    die("❌ Exam session expired. Please try again.");
}

$exam = $_SESSION['exam_info'];
$questions = $_SESSION['exam_questions'];
$studentEmail = $_SESSION['email'];
$courseName = $exam['course_name'] ?? 'Unknown Course';
$subject = $exam['subject_name'] ?? 'Unknown Subject';

// Get submitted answers
$submittedAnswers = $_POST['answers'] ?? [];

// Calculate obtained marks
$obtainedMarks = 0;
$totalMarks = 0;

foreach ($questions as $q) {
    $totalMarks += $q['marks'];
    $qId = $q['id'];
    if (isset($submittedAnswers[$qId]) && $submittedAnswers[$qId] === $q['correct_option']) {
        $obtainedMarks += $q['marks'];
    }
}

// Optional: calculate grade
$percentage = ($totalMarks > 0) ? ($obtainedMarks / $totalMarks) * 100 : 0;
if ($percentage >= 80) $grade = 'A';
elseif ($percentage >= 60) $grade = 'B';
elseif ($percentage >= 40) $grade = 'C';
else $grade = 'F';

// Check if student already submitted for this subject
$stmtCheck = $conn->prepare("SELECT id FROM result WHERE student_email = ? AND course_name = ? AND subject = ? LIMIT 1");
$stmtCheck->bind_param("sss", $studentEmail, $courseName, $subject);
$stmtCheck->execute();
$resCheck = $stmtCheck->get_result();
$alreadyTaken = ($resCheck && $resCheck->num_rows > 0);
$stmtCheck->close();

if ($alreadyTaken) {
    die("❌ You have already submitted this exam.");
}

// Insert result into database
$stmtInsert = $conn->prepare("
    INSERT INTO result (student_email, course_name, subject, total_marks, obtained_marks, grade)
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmtInsert->bind_param("sssdds", $studentEmail, $courseName, $subject, $totalMarks, $obtainedMarks, $grade);
$stmtInsert->execute();
$stmtInsert->close();

// Clear session for exam
unset($_SESSION['exam_info'], $_SESSION['exam_questions']);

// Redirect to take_exam.php after submission
header("Location: take_exam.php");
exit;


