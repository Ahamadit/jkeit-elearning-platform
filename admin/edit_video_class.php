<?php
include __DIR__ . '/../database.php';

$video_id = $_GET['id'] ?? null;
if (!$video_id) {
    die("❌ Invalid Video ID");
}

// Fetch video info
$stmt = $conn->prepare("SELECT subject_name, video_link FROM video_class WHERE id=?");
$stmt->bind_param("i", $video_id);
$stmt->execute();
$stmt->bind_result($subject_name, $video_link);
$stmt->fetch();
$stmt->close();

if (!$video_link) {
    die("❌ Video record not found in database");
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['video_link'])) {
    $new_video_link = trim($_POST['video_link']);

    if (empty($new_video_link)) {
        echo "<script>alert('❌ Please enter a video link');</script>";
    } else {
        $stmt = $conn->prepare("UPDATE video_class SET video_link=? WHERE id=?");
        $stmt->bind_param("si", $new_video_link, $video_id);
        if ($stmt->execute()) {
            echo "<script>alert('✅ Video link updated successfully!'); window.location='video_class.php';</script>";
            exit;
        } else {
            echo "<script>alert('❌ Failed to update video link');</script>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Video Link</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h3 class="mb-3">✏️ Edit Video for: <span class="text-primary"><?php echo htmlspecialchars($subject_name); ?></span></h3>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Video / YouTube Link</label>
                    <input type="url" name="video_link" class="form-control" placeholder="Enter video or YouTube link" value="<?php echo htmlspecialchars($video_link); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Video</button>
                <a href="study_material.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</body>

</html>
