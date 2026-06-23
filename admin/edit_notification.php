<?php
include __DIR__ . '/../database.php'; // Adjust path if needed

// Get notification ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: notification.php");
    exit;
}

$id = intval($_GET['id']);

// Fetch existing notification
$stmt = $conn->prepare("SELECT * FROM notification WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header("Location: notification.php");
    exit;
}
$notification = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['course_name'] ?? '';
    $old_pdf = $notification['pdf']; // Keep old PDF by default

    // Check if new PDF is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $pdf = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $pdf_name = time() . "_" . basename($pdf);
        $target_file = $upload_dir . $pdf_name;

        $fileType = strtolower(pathinfo($pdf, PATHINFO_EXTENSION));
        if ($fileType != "pdf") {
            echo "<script>alert('Only PDF files are allowed.');</script>";
        } else {
            if (move_uploaded_file($tmp_name, $target_file)) {
                // Delete old PDF
                $old_file = $upload_dir . $old_pdf;
                if (file_exists($old_file)) unlink($old_file);

                $old_pdf = $pdf_name; // Set new PDF
            } else {
                echo "<script>alert('File upload failed.');</script>";
            }
        }
    }

    // Update database
    $stmt = $conn->prepare("UPDATE notification SET title = ?, pdf = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $old_pdf, $id);
    if ($stmt->execute()) {
        echo "<script>alert('Notification updated successfully!'); window.location.href='notification.php';</script>";
        exit;
    } else {
        echo "<script>alert('Database update failed.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Notification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Notification</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

            <!-- Existing PDF Filename -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">PDF</label>
                <input type="text" value="<?= htmlspecialchars($notification['pdf']) ?>" disabled
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-2 bg-gray-100">
                <input type="file" name="image" accept="application/pdf"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Title -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Title</label>
                <textarea name="course_name" placeholder="Enter title" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 h-32 resize-y focus:outline-none focus:ring-2 focus:ring-blue-400 overflow-y-auto"><?= htmlspecialchars($notification['title']) ?></textarea>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-blue-700 transition">
                    Update Notification
                </button>
            </div>
        </form>
    </div>

</body>

</html>
