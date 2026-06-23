<?php
include __DIR__ . '/../database.php';

$pdf_id = $_GET['id'] ?? null;
if (!$pdf_id) {
    die("❌ Invalid PDF ID");
}

// Fetch PDF info
$stmt = $conn->prepare("SELECT subject_name, pdf_file FROM study_pdf WHERE id=?");
$stmt->bind_param("i", $pdf_id);
$stmt->execute();
$stmt->bind_result($subject_name, $pdf_file);
$stmt->fetch();
$stmt->close();

if (!$pdf_file) {
    die("❌ PDF record not found in database");
}

$uploadDir = __DIR__ . "/uploads/pdfs/";
$fullPath = $uploadDir . $pdf_file;

if (!file_exists($fullPath)) {
    die("❌ PDF file not found on server: " . htmlspecialchars($fullPath));
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $file = $_FILES['pdf_file'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if ($ext !== "pdf") {
        echo "<script>alert('❌ Only PDF files are allowed');</script>";
    } else {
        $newFileName = "subject_" . time() . ".pdf";
        $uploadPath = $uploadDir . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            if (file_exists($fullPath)) {
                unlink($fullPath); // delete old PDF
            }

            $stmt = $conn->prepare("UPDATE study_pdf SET pdf_file=? WHERE id=?");
            $stmt->bind_param("si", $newFileName, $pdf_id);
            $stmt->execute();
            $stmt->close();

            echo "<script>alert('✅ PDF updated successfully!'); window.location='study_material.php';</script>";
            exit;
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
    <title>Edit PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h3 class="mb-3">✏️ Edit PDF for: <span class="text-primary"><?php echo htmlspecialchars($subject_name); ?></span></h3>
            
            <p>Current PDF: <a href="uploads/pdfs/<?php echo $pdf_file; ?>" target="_blank"><?php echo $pdf_file; ?></a></p>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Choose New PDF File</label>
                    <input type="file" name="pdf_file" accept="application/pdf" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Update PDF</button>
                <a href="study_material.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</body>

</html>
