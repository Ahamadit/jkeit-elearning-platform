<?php
session_start();

// Include database connection
include __DIR__ . '/database.php'; // Adjust path if necessary

// Get course name from session or default
$courseName = $_SESSION['course_name'] ?? 'Your Course';

// Fetch notifications
$sql = "SELECT * FROM notification ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Notifications</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
        Welcome, <?php echo $_SESSION['email'] ?? 'Student'; ?>
        <?php if ($courseName) { echo " | Course: " . htmlspecialchars($courseName); } ?>
      </span>
      <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="flex pt-16">
  <!-- Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white h-screen p-5 fixed">
    <ul class="space-y-4">
      <li><a href="dashboard.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="home"></i><span>Dashboard</span></a></li>
      <li><a href="student_registration.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="user-plus"></i><span>Student Registration</span></a></li>
      <li><a href="id-card.php" target="_blank" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="credit-card"></i><span>ID Card</span></a></li>
      <li><a href="notification.php" class="flex items-center space-x-3 bg-blue-700 p-2 rounded-lg"><i data-feather="bell"></i><span>Notifications</span></a></li>
      <li><a href="student_syllabus.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="file-text"></i><span>Syllabus</span></a></li>
      <li><a href="student_study_material.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="book-open"></i><span>Study Material</span></a></li>
      <li><a href="student_video_class.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="video"></i><span>Video Class</span></a></li>
      <li><a href="take_exam.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="edit-3"></i><span>Take Exam</span></a></li>
      <li><a href="certificate.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="award"></i><span>Certification & Marksheet</span></a></li>
    </ul>
  </aside>

  <!-- Main content -->
  <main class="ml-64 flex-1 p-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Notifications for <?php echo htmlspecialchars($courseName); ?></h1>

    <div class="overflow-x-auto">
      <table class="min-w-full bg-white rounded-xl shadow-lg overflow-hidden">
        <thead class="bg-blue-600 text-white">
          <tr>
            <th class="py-3 px-6 text-left uppercase tracking-wider">SR No.</th>
            <th class="py-3 px-6 text-left uppercase tracking-wider">Title</th>
            <th class="py-3 px-6 text-left uppercase tracking-wider">PDF File</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result && $result->num_rows > 0) {
              $sr = 1;
              while ($row = $result->fetch_assoc()) {
                  $pdfFile = $row['pdf'];
                  // Server path for file_exists
                  $pdfPath = __DIR__ . '/admin/uploads/' . $pdfFile;
                  // URL path for browser
                  $pdfUrl  = 'admin/uploads/' . $pdfFile;

                  echo "<tr class='border-b hover:bg-gray-50 transition'>
                          <td class='py-3 px-6'>{$sr}</td>
                          <td class='py-3 px-6 text-gray-700 font-medium'>" . htmlspecialchars($row['title']) . "</td>
                          <td class='py-3 px-6'>";
                  if (!empty($pdfFile) && file_exists($pdfPath)) {
                      echo "<a href='{$pdfUrl}' target='_blank' class='text-blue-600 hover:underline'>View PDF</a>";
                  } else {
                      echo "<span class='text-gray-400'>PDF not available</span>";
                  }
                  echo "</td></tr>";
                  $sr++;
              }
          } else {
              echo "<tr><td colspan='3' class='text-center py-6 text-gray-500'>No notifications found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<script>feather.replace();</script>
</body>
</html>
