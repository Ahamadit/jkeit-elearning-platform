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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $file = $_FILES['pdf_file'];
    $uploadDir = __DIR__ . "/uploads/pdfs/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($ext !== "pdf") {
        echo "<script>alert('❌ Only PDF files are allowed');</script>";
    } else {
        $newFileName = "subject_" . time() . ".pdf";
        $uploadPath = $uploadDir . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Save in study_pdf table
            $stmt = $conn->prepare("INSERT INTO study_pdf (subject_name, pdf_file) VALUES (?, ?)");
            $stmt->bind_param("ss", $subject_name, $newFileName);
            $stmt->execute();
            $stmt->close();

            echo "<script>alert('✅ PDF uploaded successfully!'); window.location='study_material.php';</script>";
        } else {
            echo "<script>alert('❌ Failed to upload PDF');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h3 class="mb-3">📄 Upload PDF for: <span class="text-primary"><?php echo htmlspecialchars($subject_name); ?></span></h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Choose PDF File</label>
                    <input type="file" name="pdf_file" accept="application/pdf" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Upload PDF</button>
                <a href="study_material.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</body>

</html>