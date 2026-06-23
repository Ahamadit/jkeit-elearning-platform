<?php
include __DIR__ . '/../database.php';

// Get exam ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid exam ID.");
}
$exam_id = (int) $_GET['id'];

// Fetch exam details
$sql = "SELECT * FROM add_exam WHERE id = $exam_id LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("Exam not found.");
}
$exam = $result->fetch_assoc();

// Fetch all courses
$courses = $conn->query("SELECT id, course_name FROM add_course ORDER BY course_name ASC");

// Get course_id of exam's course_name
$course_id_res = $conn->query("SELECT id FROM add_course WHERE course_name = '{$exam['course_name']}' LIMIT 1");
$course_id_row = $course_id_res->fetch_assoc();
$current_course_id = $course_id_row['id'] ?? 0;

// Fetch subjects only for the exam’s course
$subjects = $conn->query("SELECT id, subject_name FROM add_subject WHERE course_id = $current_course_id ORDER BY subject_name ASC");

// Update exam on form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = (int) $_POST['course_id'];
    $subject_id = (int) $_POST['subject_id'];
    $duration = (int) $_POST['duration'];
    $passing_marks = (int) $_POST['passing_marks'];

    // Get course_name from add_course
    $course_res = $conn->query("SELECT course_name FROM add_course WHERE id = $course_id LIMIT 1");
    $course_name = ($course_res->num_rows > 0) ? $course_res->fetch_assoc()['course_name'] : '';

    // Get subject_name from add_subject
    $subject_res = $conn->query("SELECT subject_name FROM add_subject WHERE id = $subject_id LIMIT 1");
    $subject_name = ($subject_res->num_rows > 0) ? $subject_res->fetch_assoc()['subject_name'] : '';

    // Update add_exam
    $update = $conn->prepare("UPDATE add_exam SET course_name=?, subject_name=?, duration=?, mark=? WHERE id=?");
    $update->bind_param("ssiii", $course_name, $subject_name, $duration, $passing_marks, $exam_id);

    if ($update->execute()) {
        header("Location: exam.php?msg=updated");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error updating exam.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Exam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">✏️ Edit Exam</div>
                    <div class="card-body p-4">
                        <form action="" method="POST">

                            <!-- Course Dropdown -->
                            <div class="mb-3">
                                <label for="course_id" class="form-label">Course Name</label>
                                <select name="course_id" id="course_id" class="form-select" required>
                                    <option value="">Select Course</option>
                                    <?php while ($c = $courses->fetch_assoc()) { ?>
                                        <option value="<?= $c['id'] ?>" <?= ($c['course_name'] == $exam['course_name']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($c['course_name']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Subject Dropdown -->
                            <div class="mb-3">
                                <label for="subject_id" class="form-label">Subject Name</label>
                                <select name="subject_id" id="subject_id" class="form-select" required>
                                    <?php while ($s = $subjects->fetch_assoc()) { ?>
                                        <option value="<?= $s['id'] ?>" <?= ($s['subject_name'] == $exam['subject_name']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($s['subject_name']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Duration -->
                            <div class="mb-3">
                                <label for="duration" class="form-label">Exam Duration (minutes)</label>
                                <input type="number" name="duration" id="duration" class="form-control"
                                    value="<?= (int)$exam['duration'] ?>" required>
                            </div>

                            <!-- Passing Marks -->
                            <div class="mb-3">
                                <label for="passing_marks" class="form-label">Passing Marks</label>
                                <input type="number" name="passing_marks" id="passing_marks" class="form-control"
                                    value="<?= (int)$exam['mark'] ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Update Exam</button>
                            <a href="exam.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dynamic load subjects when course changes
        $("#course_id").change(function() {
            var courseId = $(this).val();
            if (courseId) {
                $.ajax({
                    url: "get_subject.php",
                    type: "POST",
                    data: {
                        course_id: courseId
                    },
                    success: function(data) {
                        $("#subject_id").html(data);
                    }
                });
            } else {
                $("#subject_id").html('<option value="">Select Subject</option>');
            }
        });
    </script>
</body>

</html>