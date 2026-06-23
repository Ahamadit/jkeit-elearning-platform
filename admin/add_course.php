<?php
include __DIR__ . '/../database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $subject     = $_POST['subject'];
    $price       = $_POST['price'];
    $duration    = $_POST['duration']; // new field

    // Handle image upload
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $folder = "uploads/" . $image;

    if (move_uploaded_file($tmp_name, $folder)) {
        $sql = "INSERT INTO add_course (image, course_name, subject, price, duration) 
                VALUES ('$image', '$course_name', '$subject', '$price', '$duration')";

        if ($conn->query($sql) === TRUE) {
            echo "
            <html>
            <head>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
            <script>
                Swal.fire({
                    title: '✅ Success!',
                    text: 'Course added successfully!',
                    icon: 'success',
                    confirmButtonText: 'Go to Courses',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    window.location.href = 'course.php';
                });
            </script>
            </body>
            </html>";
        } else {
            echo "
            <html>
            <head><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head>
            <body>
            <script>
                Swal.fire({
                    title: '❌ Error!',
                    text: '" . addslashes($conn->error) . "',
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                });
            </script>
            </body>
            </html>";
        }
    } else {
        echo "
        <html>
        <head><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head>
        <body>
        <script>
            Swal.fire({
                title: '⚠️ Upload Failed',
                text: 'Image upload failed!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        </script>
        </body>
        </html>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add New Course</h2>

        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5">

            <!-- Course Image -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Course Image</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Course Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Course Name</label>
                <input type="text" name="course_name" placeholder="Enter course name"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Subject -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Subject</label>
                <input type="text" name="subject" placeholder="Enter subject"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Price -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Price (₹)</label>
                <input type="number" name="price" placeholder="Enter price"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Duration -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Duration</label>
                <input type="text" name="duration" placeholder="Enter duration "
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-blue-700 transition">
                    Add Course
                </button>
            </div>
        </form>
    </div>

</body>

</html>
