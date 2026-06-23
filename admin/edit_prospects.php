<?php
include __DIR__ . '/../database.php';

// Get the prospect ID from URL
if (!isset($_GET['id'])) {
    die("Prospect ID not provided.");
}

$id = $_GET['id'];

// Fetch existing data
$sql = "SELECT * FROM prospect WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Prospect not found.");
}

$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['course_name'];
    $pdfFile = $_FILES['image'];
    $pdfName = $row['pdf']; // Keep old PDF by default

    // If a new PDF is uploaded
    if (!empty($pdfFile['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $newPdfName = time() . "_" . basename($pdfFile["name"]);
        $targetFilePath = $targetDir . $newPdfName;

        if (move_uploaded_file($pdfFile["tmp_name"], $targetFilePath)) {
            // Delete old PDF if exists
            if (!empty($row['pdf']) && file_exists($targetDir . $row['pdf'])) {
                unlink($targetDir . $row['pdf']);
            }
            $pdfName = $newPdfName;
        } else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed!',
                            text: 'Could not upload the new PDF.'
                        });
                    });
                  </script>";
        }
    }

    // Update the record
    $update = "UPDATE prospect SET pdf = '$pdfName', title = '$title' WHERE id = $id";
    if ($conn->query($update) === TRUE) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Prospect Updated Successfully!',
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
                        text: 'Failed to update data.'
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
    <title>Edit Prospect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Prospect</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

            <!-- Existing PDF -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Current PDF</label>
                <?php if (!empty($row['pdf'])): ?>
                    <a href="uploads/<?php echo $row['pdf']; ?>" target="_blank" class="text-blue-600 underline">
                        View Current PDF
                    </a>
                <?php else: ?>
                    <p class="text-gray-500">No PDF uploaded yet</p>
                <?php endif; ?>
            </div>

            <!-- Upload new PDF -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Upload New PDF (optional)</label>
                <input type="file" name="image" accept="application/pdf"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Title -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Title</label>
                <textarea name="course_name" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 h-32 resize-y focus:outline-none focus:ring-2 focus:ring-blue-400 overflow-y-auto"><?php echo htmlspecialchars($row['title']); ?></textarea>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-green-700 transition">
                    Update Prospect
                </button>
            </div>
        </form>
    </div>

</body>
</html>
