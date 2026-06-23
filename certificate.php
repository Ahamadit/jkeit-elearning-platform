<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Include your database connection
include __DIR__ . '/database.php';

// Example: fetch course name if needed
$courseName = '';
if (isset($_SESSION['course_id'])) {
    $cid = (int) $_SESSION['course_id'];
    $stmt = $conn->prepare("SELECT course_name FROM add_course WHERE id = ?");
    $stmt->bind_param("i", $cid);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $courseName = $row['course_name'];
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 fixed z-30 w-full">
        <div class="px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="https://themewagon.github.io/windster/images/logo.svg" class="h-7" alt="Logo">
                <span class="text-lg font-bold text-blue-600">Student Dashboard</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 text-sm">
                    Welcome, <?php echo $_SESSION['email']; ?>
                    <?php if ($courseName) {
                        echo " | Course: " . htmlspecialchars($courseName);
                    } ?>
                </span>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="flex pt-16">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white h-screen p-5 fixed">
            <ul class="space-y-4">
                <li>
                    <a href="dashboard.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer">
                        <i data-feather="home"></i><span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="student_registration.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer">
                        <i data-feather="user-plus"></i><span>Student Registration</span>
                    </a>
                </li>
                <li>
                    <a href="id-card.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer">
                        <i data-feather="credit-card"></i><span>ID Card</span>
                    </a>
                </li>
                <li>
                    <a href="notification.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer">
                        <i data-feather="bell"></i><span>Notifications</span>
                    </a>
                </li>
                <li>
                    <a href="student_syllabus.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer">
                        <i data-feather="file-text"></i><span>Syllabus</span>
                    </a>
                </li>
                <li>
                    <a href="student_study_material.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer">
                        <i data-feather="book-open"></i><span>Study Material</span>
                    </a>
                </li>
                <li>
                    <a href="student_video_class.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer">
                        <i data-feather="video"></i><span>Video Class</span>
                    </a>
                </li>
                <li>
                    <a href="take_exam.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer">
                        <i data-feather="edit-3"></i><span>Take Exam</span>
                    </a>
                </li>
                <li>
                    <a href="certificate.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer">
                        <i data-feather="award"></i><span>Certification & Marksheet</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64 p-8 bg-gray-50 min-h-screen">
            <h1 class="text-2xl font-bold mb-6">My Dashboard</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <!-- Marksheet Card -->
                <div class="bg-white shadow hover:shadow-lg rounded-lg p-6 flex items-center space-x-4 transition duration-200">
                    <a href=" view_certificate.php" target="_blank"  class="p-4 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                        <i data-feather="file-text" class="w-6 h-6"></i>
                    </a>
                    <div>
                        <h2 class="text-lg font-semibold">Marksheet</h2>
                        <p class="text-gray-500 text-sm">View your marksheets</p>
                    </div>
                </div>
                <!-- Certificate Card -->
                <div class="bg-white shadow hover:shadow-lg rounded-lg p-6 flex items-center space-x-4 transition duration-200">
                    <a href="view_marksheet.php" target="_blank"  class="p-4 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                        <i data-feather="award" class="w-6 h-6"></i>
                    </a>
                    <div>
                        <h2 class="text-lg font-semibold">Certificate</h2>
                        <p class="text-gray-500 text-sm">View your certificates</p>
                    </div>
                </div>

              
            </div>
        </div>
    </div>

    <script>
        feather.replace(); // Initialize Feather icons
    </script>
</body>

</html>