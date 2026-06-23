<?php
include __DIR__ . '/../database.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Exam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
        }
        .card-header {
            background: #0d6efd;
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            text-align: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .btn-primary {
            width: 100%;
            font-weight: 600;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card">
                <div class="card-header">
                    📘 Create Exam
                </div>
                <div class="card-body p-4">
                    <form action="save_exam.php" method="POST">

                        <!-- Course Dropdown -->
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course Name</label>
                            <select name="course_id" id="course_id" class="form-select" required>
                                <option value=""> Select Course </option>
                                <?php
                                $sql = "SELECT id, course_name FROM add_course ORDER BY course_name ASC";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['course_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Subject Dropdown -->
                        <div class="mb-3">
                            <label for="subject_id" class="form-label">Subject Name</label>
                            <select name="subject_id" id="subject_id" class="form-select" required>
                                <option value=""> Select Subject </option>
                            </select>
                        </div>

                        <!-- Exam Duration -->
                        <div class="mb-3">
                            <label for="duration" class="form-label">Exam Duration (minutes)</label>
                            <input type="number" name="duration" id="duration" class="form-control" placeholder="time" required>
                        </div>

                        <!-- Passing Marks -->
                        <div class="mb-3">
                            <label for="passing_marks" class="form-label">Passing Marks</label>
                            <input type="number" name="passing_marks" id="passing_marks" class="form-control" placeholder="mask" required>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary">Create Exam</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $("#course_id").change(function(){
        var courseId = $(this).val();
        if(courseId){
            $.ajax({
                url: "get_subject.php",
                type: "POST",
                data: {course_id: courseId},
                success: function(data){
                    $("#subject_id").html(data);
                }
            });
        } else {
            $("#subject_id").html('<option value="">-- Select Subject --</option>');
        }
    });
});
</script>

</body>
</html>
