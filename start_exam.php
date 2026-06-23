<?php
session_start();
include __DIR__ . '/database.php';

// Check if exam_id is provided
if (!isset($_GET['exam_id']) || !is_numeric($_GET['exam_id'])) {
    die("Invalid exam ID.");
}
$exam_id = (int)$_GET['exam_id'];

// Fetch exam details
$exam_stmt = $conn->prepare("SELECT * FROM add_exam WHERE id = ?");
$exam_stmt->bind_param("i", $exam_id);
$exam_stmt->execute();
$exam_result = $exam_stmt->get_result();
$exam = $exam_result->fetch_assoc();

if (!$exam) {
    die("Exam not found.");
}

// Fetch exam questions
$questions_stmt = $conn->prepare("SELECT * FROM exam_questions WHERE exam_id = ? ORDER BY question_no ASC");
$questions_stmt->bind_param("i", $exam_id);
$questions_stmt->execute();
$questions_result = $questions_stmt->get_result();
$questions = [];
while ($row = $questions_result->fetch_assoc()) {
    $questions[] = $row;
}
$total_questions = count($questions);

if ($total_questions === 0) {
    die("❌ No questions found for this exam.");
}

// ✅ Save exam and questions in session (so submit_exam.php can use them)
$_SESSION['exam_info'] = $exam;
$_SESSION['exam_questions'] = $questions;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Start Exam - <?= htmlspecialchars($exam['subject_name']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body { background: #f9f9f9; padding: 20px; }
        .exam-container { max-width: 800px; margin: auto; background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .question-card { display: none; }
        .question-card.active { display: block; }
        .options label { display:block; margin-bottom:8px; }
        .timer { font-size:18px; font-weight:bold; color:#d9534f; margin-bottom:15px; text-align:right; }
        .btn-nav { min-width: 120px; }
    </style>
</head>
<body>
<div class="exam-container">
    <h2 class="mb-3"><?= htmlspecialchars($exam['subject_name']) ?> (Duration: <?= $exam['duration'] ?> min)</h2>
    <div class="timer" id="timer"></div>

    <form method="post" action="submit_exam.php" id="examForm">
        <input type="hidden" name="exam_id" value="<?= $exam_id ?>">

        <?php foreach ($questions as $index => $q): ?>
        <div class="question-card <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
            <p><b>Q<?= $index + 1 ?>:</b> <?= htmlspecialchars($q['question_text']) ?> <span class="text-muted">(<?= $q['marks'] ?> marks)</span></p>
            <div class="options">
                <label><input type="radio" name="answers[<?= $q['id'] ?>]" value="A"> <?= htmlspecialchars($q['option_a']) ?></label>
                <label><input type="radio" name="answers[<?= $q['id'] ?>]" value="B"> <?= htmlspecialchars($q['option_b']) ?></label>
                <label><input type="radio" name="answers[<?= $q['id'] ?>]" value="C"> <?= htmlspecialchars($q['option_c']) ?></label>
                <label><input type="radio" name="answers[<?= $q['id'] ?>]" value="D"> <?= htmlspecialchars($q['option_d']) ?></label>
            </div>
            <div class="mt-3 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary btn-nav" id="prevBtn" <?= $index === 0 ? 'disabled' : '' ?>>Previous</button>
                <?php if ($index === $total_questions - 1): ?>
                    <button type="submit" class="btn btn-success btn-nav">Submit Exam</button>
                <?php else: ?>
                    <button type="button" class="btn btn-primary btn-nav" id="nextBtn">Next</button>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </form>
</div>

<script>
let duration = <?= (int)$exam['duration'] ?> * 60;
let timerEl = document.getElementById('timer');

function updateTimer() {
    let minutes = Math.floor(duration / 60);
    let seconds = duration % 60;
    timerEl.textContent = `Time Left: ${minutes}m ${seconds}s`;
    if (duration <= 0) {
        document.getElementById('examForm').submit();
    } else {
        duration--;
        setTimeout(updateTimer, 1000);
    }
}
updateTimer();

// Question navigation
let currentIndex = 0;
const totalQuestions = <?= $total_questions ?>;
const cards = document.querySelectorAll('.question-card');

function showQuestion(index) {
    cards.forEach((c,i) => c.classList.toggle('active', i===index));
    currentIndex = index;
}

document.querySelectorAll('#nextBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        if(currentIndex < totalQuestions - 1) showQuestion(currentIndex + 1);
    });
});

document.querySelectorAll('#prevBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        if(currentIndex > 0) showQuestion(currentIndex - 1);
    });
});
</script>
</body>
</html>
