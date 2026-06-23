<?php
include __DIR__ . '/../database.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['course_name'];
    $pdfFile = $_FILES['image'];

    // PDF upload settings
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $pdfName = time() . "_" . basename($pdfFile["name"]);
    $targetFilePath = $targetDir . $pdfName;

    if (move_uploaded_file($pdfFile["tmp_name"], $targetFilePath)) {
        // Insert into database
        $sql = "INSERT INTO prospect (pdf, title) VALUES ('$pdfName', '$title')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Prospect Added Successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = 'prospects.php';
                        });
                    });
                  </script>";
        } else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Database Error!',
                            text: 'Failed to save data.'
                        });
                    });
                  </script>";
        }
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed!',
                        text: 'Could not upload PDF.'
                    });
                });
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Prospects</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add New Prospects</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

            <!-- PDF Upload -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Prospects PDF</label>
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
                    Add Prospects
                </button>
            </div>
        </form>
    </div>

</body>
</html>
