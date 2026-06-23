<?php
// Include your database connection file
include __DIR__ . '/../database.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get title input
    $title = $_POST['course_name'] ?? '';

    // Handle file upload
    $pdf = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    // Create uploads folder if not exists
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Rename file to avoid duplicates
    $pdf_name = time() . "_" . basename($pdf);
    $target_file = $upload_dir . $pdf_name;

    // Check if file is a PDF
    $fileType = strtolower(pathinfo($pdf, PATHINFO_EXTENSION));
    if ($fileType != "pdf") {
        echo "<script>alert('Only PDF files are allowed.');</script>";
    } else {
        // Move file to uploads folder
        if (move_uploaded_file($tmp_name, $target_file)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO notification (pdf, title) VALUES (?, ?)");
            $stmt->bind_param("ss", $pdf_name, $title);

            if ($stmt->execute()) {
                echo "<script>alert('Notification added successfully!'); window.location.href='notification.php';</script>";
            } else {
                echo "<script>alert('Database insert failed.');</script>";
            }
        } else {
            echo "<script>alert('File upload failed.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Notification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add New Notification</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

            <!-- PDF Upload -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Notification PDF</label>
                <input type="file" name="image" accept="application/pdf" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Title -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Title</label>
                <textarea name="course_name" placeholder="Enter title" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 h-32 resize-y focus:outline-none focus:ring-2 focus:ring-blue-400 overflow-y-auto"></textarea>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-blue-700 transition">
                    Add Notification
                </button>
            </div>
        </form>
    </div>

</body>

</html>