<?php
include __DIR__ . '/../database.php';

// Get exam_id
if (!isset($_GET['exam_id']) || !is_numeric($_GET['exam_id'])) {
    die("Invalid exam ID.");
}
$exam_id = (int) $_GET['exam_id'];

// Fetch exam name for display
$exam_res = $conn->query("SELECT * FROM add_exam WHERE id = $exam_id LIMIT 1");
if ($exam_res->num_rows == 0) {
    die("Exam not found.");
}
$exam = $exam_res->fetch_assoc();

// Get next question number
$q_res = $conn->query("SELECT MAX(question_no) AS max_q FROM exam_questions WHERE exam_id = $exam_id");
$row = $q_res->fetch_assoc();
$next_q_no = ($row['max_q'] ?? 0) + 1;

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_no = (int) $_POST['question_no'];
    $question_text = trim($_POST['question_text']);
    $option_a = trim($_POST['option_a']);
    $option_b = trim($_POST['option_b']);
    $option_c = trim($_POST['option_c']);
    $option_d = trim($_POST['option_d']);
    $correct_option = $_POST['correct_option'];
    $marks = (int) $_POST['marks'];

    $stmt = $conn->prepare("INSERT INTO exam_questions 
        (exam_id, question_no, question_text, option_a, option_b, option_c, option_d, correct_option, marks) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssssi", $exam_id, $question_no, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option, $marks);

    if ($stmt->execute()) {
        // Redirect to question.php after adding the question
        header("Location: question.php?exam_id=$exam_id&msg=added");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error saving question.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Question - <?= htmlspecialchars($exam['subject_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white">
                    ➕ Add Question (<?= htmlspecialchars($exam['subject_name']) ?>)
                </div>
                <div class="card-body">
                    <form method="POST">
                        <!-- Question Number -->
                        <div class="mb-3">
                            <label class="form-label">Question No</label>
                            <input type="number" name="question_no" class="form-control" value="<?= $next_q_no ?>" readonly>
                        </div>

                        <!-- Question Marks -->
                        <div class="mb-3">
                            <label class="form-label">Marks</label>
                            <input type="number" name="marks" class="form-control" value="1" min="1" required>
                        </div>

                        <!-- Question Text -->
                        <div class="mb-3">
                            <label class="form-label">Question</label>
                            <textarea name="question_text" class="form-control" required></textarea>
                        </div>

                        <!-- Options -->
                        <div class="mb-3">
                            <label class="form-label">Options</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text">A</span>
                                <input type="text" name="option_a" class="form-control" required>
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="A" required>
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">B</span>
                                <input type="text" name="option_b" class="form-control" required>
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="B" required>
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">C</span>
                                <input type="text" name="option_c" class="form-control" required>
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="C" required>
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">D</span>
                                <input type="text" name="option_d" class="form-control" required>
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="D" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Save Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
