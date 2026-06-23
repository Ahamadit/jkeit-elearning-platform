<?php
session_start();
if (!isset($_SESSION['user_id'], $_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

include __DIR__ . '/database.php';

// Fetch course name
$courseName = '';
if (isset($_SESSION['course_id'])) {
    $cid = (int) $_SESSION['course_id'];
    $sql = "SELECT course_name FROM add_course WHERE id = $cid LIMIT 1";
    $res = $conn->query($sql);
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
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
    <nav class="bg-white border-b border-gray-200 fixed z-30 w-full shadow">
        <div class="px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="https://themewagon.github.io/windster/images/logo.svg" class="h-8" alt="Logo">
                <span class="text-lg font-bold text-blue-600">Student Dashboard</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 text-sm">
                    Welcome, <?php echo $_SESSION['email']; ?>
                    <?php if ($courseName) echo " | Course: " . htmlspecialchars($courseName); ?>
                </span>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Logout</a>
            </div>
        </div>
    </nav>

    <div class="flex pt-16">

        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white h-screen p-5 fixed">
            <ul class="space-y-4">
                <li><a href="dashboard.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer"><i data-feather="home"></i><span>Dashboard</span></a></li>
                <li><a href="student_registration.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer"><i data-feather="user-plus"></i><span>Student Registration</span></a></li>
                <li><a href="id-card.php" target="_blank" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer"><i data-feather="credit-card"></i><span>ID Card</span></a></li>
                <li><a href="notification.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer"><i data-feather="bell"></i><span>Notifications</span></a></li>
                <li><a href="student_syllabus.php" class="flex items-center space-x-3 bg-blue-700 p-2 rounded-lg cursor-pointer"><i data-feather="file-text"></i><span>Syllabus</span></a></li>
                <li><a href="student_study_material.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer"><i data-feather="book-open"></i><span>Study Material</span></a></li>
                <li><a href="student_video_class.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer"><i data-feather="video"></i><span>Video Class</span></a></li>

                <li><a href="take_exam.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer"><i data-feather="edit-3"></i><span>Take Exam</span></a></li>
                <li><a href="certificate.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg cursor-pointer"><i data-feather="award"></i><span>Certification & Marksheet</span></a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="ml-64 w-full p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">📚 Quick Access</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Syllabus Card -->
                <a href="student_syllabus.php" class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center justify-center hover:shadow-2xl hover:-translate-y-2 transform transition duration-300">
                    <i data-feather="file-text" class="w-12 h-12 text-blue-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-800">Syllabus</h3>
                    <p class="text-gray-500 text-sm mt-1 text-center">View your course syllabus and schedule</p>
                </a>

                <!-- Study Material Card -->
                <a href="student_study_material.php" class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center justify-center hover:shadow-2xl hover:-translate-y-2 transform transition duration-300">
                    <i data-feather="book-open" class="w-12 h-12 text-green-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-800">Study Material</h3>
                    <p class="text-gray-500 text-sm mt-1 text-center">Access all study materials for your courses</p>
                </a>

                <!-- Video Class Card -->
                <a href="student_video_class.php" class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center justify-center hover:shadow-2xl hover:-translate-y-2 transform transition duration-300">
                    <i data-feather="video" class="w-12 h-12 text-red-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-800">Video Class</h3>
                    <p class="text-gray-500 text-sm mt-1 text-center">Join your online video classes and lectures</p>
                </a>
            </div>
        </div>

    </div>

    <!-- Feather Icons -->
    <script>
        feather.replace();
    </script>

</body>

</html>