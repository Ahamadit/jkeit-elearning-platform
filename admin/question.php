<?php
include __DIR__ . '/../database.php';

// Get exam_id
if (!isset($_GET['exam_id']) || !is_numeric($_GET['exam_id'])) {
    die("Invalid exam ID.");
}
$exam_id = (int) $_GET['exam_id'];

// Fetch exam details
$exam_res = $conn->query("SELECT * FROM add_exam WHERE id = $exam_id LIMIT 1");
if ($exam_res->num_rows == 0) {
    die("Exam not found.");
}
$exam = $exam_res->fetch_assoc();

// Fetch all questions for this exam
$questions_res = $conn->query("SELECT * FROM exam_questions WHERE exam_id = $exam_id ORDER BY question_no ASC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Questions - <?= htmlspecialchars($exam['subject_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #eef2f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-header {
            background: linear-gradient(#37423B);
            /* Black to dark gray with red-orange accent */
            color: #fff;
            padding: 25px 20px;
            border-radius: 15px;
            margin-bottom: 35px;
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }



        .card {
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .table thead th {
            background: #37423B;
            color: #fff;
            text-align: center;
            border: none;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #fff3e0;
        }

        .table tbody tr:nth-child(even) {
            background-color: #ffe0b2;
        }

        .table tbody td {
            vertical-align: middle;
            text-align: center;
            font-size: 0.95rem;
        }

        .btn {
            margin: 2px;
        }

        .btn-back {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-back:hover {
            background-color: #5a6268;
            color: #fff;
        }

        .badge-correct {
            background-color: #28a745;
            color: #fff;
            font-size: 0.9rem;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="page-header">
            Add Questions for <?= htmlspecialchars($exam['subject_name']) ?> (Course is: <?= htmlspecialchars($exam['course_name']) ?>)
        </div>

        <div class="d-flex justify-content-between mb-3">
            <a href="add_question.php?exam_id=<?= $exam_id ?>" class="btn btn-success"><i class="bi bi-plus-circle"></i> Add Question</a>
            <a href="exam.php" class="btn btn-back"><i class="bi bi-arrow-left-circle"></i> Back to Exams list</a>
        </div>

        <div class="card">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Q No</th>
                                <th>Question</th>
                                <th>Option A</th>
                                <th>Option B</th>
                                <th>Option C</th>
                                <th>Option D</th>
                                <th>Correct</th>
                                <th>Marks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($questions_res->num_rows > 0): ?>
                                <?php while ($q = $questions_res->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $q['question_no'] ?></td>
                                        <td class="text-left"><?= htmlspecialchars($q['question_text']) ?></td>
                                        <td><?= htmlspecialchars($q['option_a']) ?></td>
                                        <td><?= htmlspecialchars($q['option_b']) ?></td>
                                        <td><?= htmlspecialchars($q['option_c']) ?></td>
                                        <td><?= htmlspecialchars($q['option_d']) ?></td>
                                        <td><span class="badge badge-correct"><?= $q['correct_option'] ?></span></td>
                                        <td><?= $q['marks'] ?></td>
                                        <td>
                                            <a href="edit_question.php?id=<?= $q['id'] ?>&exam_id=<?= $exam_id ?>" class="btn btn-sm btn-warning" title="Edit Question">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="<?= $q['id'] ?>" title="Delete Question">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9">No questions found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.dataset.id;
                const exam_id = <?= $exam_id ?>; // Pass current exam ID
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This question will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to delete PHP
                        window.location.href = `delete_question.php?id=${id}&exam_id=${exam_id}`;
                    }
                });
            });
        });
    </script>

</body>

</html>