<?php
include __DIR__ . '/../database.php';

// Get question id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid question ID.");
}
$question_id = (int) $_GET['id'];

// Get exam_id from query (for redirect and display)
if (!isset($_GET['exam_id']) || !is_numeric($_GET['exam_id'])) {
    die("Invalid exam ID.");
}
$exam_id = (int) $_GET['exam_id'];

// Fetch exam name
$exam_res = $conn->query("SELECT * FROM add_exam WHERE id = $exam_id LIMIT 1");
if ($exam_res->num_rows == 0) {
    die("Exam not found.");
}
$exam = $exam_res->fetch_assoc();

// Fetch existing question data
$q_res = $conn->query("SELECT * FROM exam_questions WHERE id = $question_id AND exam_id = $exam_id LIMIT 1");
if ($q_res->num_rows == 0) {
    die("Question not found.");
}
$question = $q_res->fetch_assoc();

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

    $stmt = $conn->prepare("UPDATE exam_questions SET 
        question_no=?, question_text=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_option=?, marks=?
        WHERE id=? AND exam_id=?");
    $stmt->bind_param("isssssssii", $question_no, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option, $marks, $question_id, $exam_id);

    if ($stmt->execute()) {
        header("Location: question.php?exam_id=$exam_id&msg=updated");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error updating question.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Question - <?= htmlspecialchars($exam['subject_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    ✏️ Edit Question (<?= htmlspecialchars($exam['subject_name']) ?>)
                </div>
                <div class="card-body">
                    <form method="POST">
                        <!-- Question Number -->
                        <div class="mb-3">
                            <label class="form-label">Question No</label>
                            <input type="number" name="question_no" class="form-control" value="<?= $question['question_no'] ?>" required>
                        </div>

                        <!-- Question Marks -->
                        <div class="mb-3">
                            <label class="form-label">Marks</label>
                            <input type="number" name="marks" class="form-control" value="<?= $question['marks'] ?>" min="1" required>
                        </div>

                        <!-- Question Text -->
                        <div class="mb-3">
                            <label class="form-label">Question</label>
                            <textarea name="question_text" class="form-control" required><?= htmlspecialchars($question['question_text']) ?></textarea>
                        </div>

                        <!-- Options -->
                        <div class="mb-3">
                            <label class="form-label">Options</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text">A</span>
                                <input type="text" name="option_a" class="form-control" value="<?= htmlspecialchars($question['option_a']) ?>" required>
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="A" <?= $question['correct_option']=='A'?'checked':'' ?> required>
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">B</span>
                                <input type="text" name="option_b" class="form-control" value="<?= htmlspecialchars($question['option_b']) ?>" required>
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="B" <?= $question['correct_option']=='B'?'checked':'' ?> required>
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">C</span>
                                <input type="text" name="option_c" class="form-control" value="<?= htmlspecialchars($question['option_c']) ?>" required>
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="C" <?= $question['correct_option']=='C'?'checked':'' ?> required>
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">D</span>
                                <input type="text" name="option_d" class="form-control" value="<?= htmlspecialchars($question['option_d']) ?>" required>
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="D" <?= $question['correct_option']=='D'?'checked':'' ?> required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn w-100" style="background-color: #000; color: #fff;">Update Question</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
