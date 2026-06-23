<?php
include __DIR__ . '/../database.php';

// Get subject ID from URL
$subject_id = $_GET['id'] ?? null;
if (!$subject_id) {
    die("❌ Invalid Subject ID");
}

// Fetch subject name from add_subject table
$stmt = $conn->prepare("SELECT subject_name FROM add_subject WHERE id=?");
$stmt->bind_param("i", $subject_id);
$stmt->execute();
$stmt->bind_result($subject_name);
$stmt->fetch();
$stmt->close();

if (!$subject_name) {
    die("❌ Subject not found");
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['video_link'])) {
    $video_link = trim($_POST['video_link']);

    // Basic validation
    if (empty($video_link)) {
        echo "<script>alert('❌ Please enter a video link');</script>";
    } else {
        // Save in video_class table
        $stmt = $conn->prepare("INSERT INTO video_class (subject_name, video_link) VALUES (?, ?)");
        $stmt->bind_param("ss", $subject_name, $video_link);
        if ($stmt->execute()) {
            echo "<script>alert('✅ Video link added successfully!'); window.location='video_class.php';</script>";
        } else {
            echo "<script>alert('❌ Failed to add video link');</script>";
        }
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Video Link</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h3 class="mb-3">🎬 Add Video for: <span class="text-primary"><?php echo htmlspecialchars($subject_name); ?></span></h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Video / YouTube Link</label>
                    <input type="url" name="video_link" class="form-control" placeholder="Enter video or YouTube link" required>
                </div>
                <button type="submit" class="btn btn-success">Add Video</button>
                <a href="study_material.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</body>

</html>
