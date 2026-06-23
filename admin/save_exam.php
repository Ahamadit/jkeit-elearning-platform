<?php
include __DIR__ . '/../database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'] ?? '';
    $subject_id = $_POST['subject_id'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $passing_marks = $_POST['passing_marks'] ?? '';

    // Validate
    if ($course_id && $subject_id && $duration && $passing_marks) {

        // Get course name
        $course_sql = "SELECT course_name FROM add_course WHERE id = ?";
        $stmt = $conn->prepare($course_sql);
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $stmt->bind_result($course_name);
        $stmt->fetch();
        $stmt->close();

        // Get subject name
        $subject_sql = "SELECT subject_name FROM add_subject WHERE id = ?";
        $stmt2 = $conn->prepare($subject_sql);
        $stmt2->bind_param("i", $subject_id);
        $stmt2->execute();
        $stmt2->bind_result($subject_name);
        $stmt2->fetch();
        $stmt2->close();

        // Insert into add_exam
        $insert_sql = "INSERT INTO add_exam (course_name, subject_name, duration, mark) 
                       VALUES (?, ?, ?, ?)";
        $stmt3 = $conn->prepare($insert_sql);
        $stmt3->bind_param("ssss", $course_name, $subject_name, $duration, $passing_marks);

        if ($stmt3->execute()) {
            echo "<script>alert('✅ Exam created successfully'); window.location.href='exam.php';</script>";
        } else {
            echo "<script>alert('❌ Failed to create exam'); window.history.back();</script>";
        }

        $stmt3->close();
    } else {
        echo "<script>alert('⚠ Please fill all fields'); window.history.back();</script>";
    }
}
?>
