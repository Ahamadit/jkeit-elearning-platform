<?php
include __DIR__ . '/../database.php'; // DB connection

$message = "";
$alertType = "";
$redirect = false;

// Get banner ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: banner.php");
    exit;
}

$bannerId = $_GET['id'];

// Fetch existing banner
$stmt = $conn->prepare("SELECT * FROM banner WHERE id = ?");
$stmt->bind_param("i", $bannerId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header("Location: banner.php");
    exit;
}
$banner = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $paragraph = $_POST['paragraph'];
    $imageName = $banner['image']; // keep old image by default

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $imageName;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $message = "Error uploading new image!";
            $alertType = "error";
        }
    }

    // Update database
    $stmt = $conn->prepare("UPDATE banner SET title = ?, paragraph = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $paragraph, $imageName, $bannerId);

    if ($stmt->execute()) {
        $message = "Banner Updated Successfully!";
        $alertType = "success";
        $redirect = true;
    } else {
        $message = "Database error! Try again.";
        $alertType = "error";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Banner</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
body {
    background: linear-gradient(135deg, #74ABE2, #5563DE);
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.form-container {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 100%;
    padding: 30px 40px;
}
.form-title { font-weight: 600; color: #333; text-align: center; margin-bottom: 20px; }
.form-control, .form-control:focus { border-radius: 12px; box-shadow: none; border: 1px solid #ccc; }
.btn-custom { background-color: #5563DE; color: #fff; border-radius: 12px; padding: 10px 15px; font-weight: 500; width: 100%; transition: all 0.3s ease; }
.btn-custom:hover { background-color: #3740A3; transform: scale(1.02); }
img.preview-img { width: 100%; max-height: 200px; object-fit: cover; margin-bottom: 10px; border-radius: 12px; }
</style>
</head>
<body>

<div class="form-container">
    <h3 class="form-title">Edit Banner</h3>

    <form method="POST" enctype="multipart/form-data">
        <!-- Title -->
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($banner['title']) ?>" required>
        </div>

        <!-- Paragraph -->
        <div class="mb-3">
            <label class="form-label">Paragraph</label>
            <textarea name="paragraph" class="form-control" rows="3" required><?= htmlspecialchars($banner['paragraph']) ?></textarea>
        </div>

        <!-- Current Image -->
        <div class="mb-3">
            <label class="form-label">Current Image</label>
            <img src="uploads/<?= htmlspecialchars($banner['image']) ?>" alt="Current Banner" class="preview-img">
        </div>

        <!-- Upload New Image -->
        <div class="mb-3">
            <label class="form-label">Upload New Image (optional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-custom">Update Banner</button>
    </form>
</div>

<?php if (!empty($message)): ?>
<script>
Swal.fire({
    icon: '<?= $alertType ?>',
    title: '<?= $message ?>',
    showConfirmButton: false,
    timer: 2000
}).then(() => {
    <?php if ($redirect): ?>
    window.location.href = 'banner.php';
    <?php endif; ?>
});
</script>
<?php endif; ?>

</body>
</html>
