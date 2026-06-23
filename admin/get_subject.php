<?php
include __DIR__ . '/../database.php'; // go one folder up (fix path)

if (isset($_POST['course_id'])) {
    $course_id = (int) $_POST['course_id'];

    $sql = "SELECT id, subject_name 
            FROM add_subject 
            WHERE course_id = $course_id 
            ORDER BY subject_name ASC";

    $result = $conn->query($sql);

    echo "<option value=''> Select Subject </option>";
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['subject_name']}</option>";
        }
    } else {
        echo "<option value=''>No subjects found</option>";
    }
}
?>
