<?php
session_start();
if (!isset($_SESSION['user_id'], $_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

include __DIR__ . '/database.php';

// Get course_id from session
$course_id = $_SESSION['course_id'] ?? null;
if (!$course_id) {
    die("❌ Course not found. Please select a course first.");
}

// Fetch course name
$courseName = '';
$stmt = $conn->prepare("SELECT course_name FROM add_course WHERE id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $courseName = $row['course_name'];
}

// Fetch subjects
$subjects = [];
$stmt2 = $conn->prepare("SELECT id, subject_name FROM add_subject WHERE course_id = ? ORDER BY id ASC");
$stmt2->bind_param("i", $course_id);
$stmt2->execute();
$res2 = $stmt2->get_result();
while ($row = $res2->fetch_assoc()) {
    $subjects[$row['id']] = $row['subject_name'];
}
$stmt2->close();

// Fetch study PDFs
$study_materials = [];
$stmt3 = $conn->prepare("SELECT subject_name, pdf_file FROM study_pdf WHERE subject_name IN (
    SELECT subject_name FROM add_subject WHERE course_id = ?
) ORDER BY id ASC");
$stmt3->bind_param("i", $course_id);
$stmt3->execute();
$res3 = $stmt3->get_result();
while ($row = $res3->fetch_assoc()) {
    $study_materials[$row['subject_name']][] = $row['pdf_file'];
}
$stmt3->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Study Material</title>
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
        Welcome, <?php echo $_SESSION['email']; ?>
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
      <li><a href="id-card.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="credit-card"></i><span>ID Card</span></a></li>
      <li><a href="notification.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="bell"></i><span>Notifications</span></a></li>
      <li><a href="student_syllabus.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="file-text"></i><span>Syllabus</span></a></li>
      <li><a href="student_study_material.php" class="flex items-center space-x-3 bg-blue-700 p-2 rounded-lg"><i data-feather="book-open"></i><span>Study Material</span></a></li>
      <li><a href="student_video_class.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="video"></i><span>Video Class</span></a></li>
      
      <li><a href="take_exam.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="edit-3"></i><span>Take Exam</span></a></li>
      <li><a href="certificate.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="award"></i><span>Certification & Marksheet</span></a></li>
    </ul>
  </aside>

  <!-- Main content -->
  <main class="ml-64 flex-1 p-8">
    <h1 class="text-2xl font-bold mb-6">Study Material for <?php echo htmlspecialchars($courseName); ?></h1>

    <?php if (empty($subjects)): ?>
      <p class="text-gray-600">No subjects found for this course.</p>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
          <thead>
            <tr class="bg-blue-600 text-white">
              <th class="py-3 px-4 text-left">SR No.</th>
              <th class="py-3 px-4 text-left">Subject Name</th>
              <th class="py-3 px-4 text-left">PDF Files</th>
            </tr>
          </thead>
          <tbody>
            <?php $sr = 1; ?>
            <?php foreach ($subjects as $id => $subject_name): ?>
              <tr class="border-b hover:bg-gray-100">
                <td class="py-3 px-4 font-medium text-gray-700"><?php echo $sr++; ?></td>
                <td class="py-3 px-4 font-medium text-gray-700"><?php echo htmlspecialchars($subject_name); ?></td>
                <td class="py-3 px-4">
                  <?php if (!empty($study_materials[$subject_name])): ?>
                    <?php foreach ($study_materials[$subject_name] as $file): ?>
                      <a href="admin/uploads/pdfs/<?php echo htmlspecialchars($file); ?>" target="_blank" class="inline-block bg-blue-500 text-white px-3 py-1 rounded mb-1 hover:bg-blue-600">View PDF</a>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span class="text-gray-500">No PDFs available</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </main>
</div>

<script>feather.replace();</script>
</body>
</html>
