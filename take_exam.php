<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

include __DIR__ . '/database.php';

$studentEmail = $_SESSION['email'];

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
$stmt->close();

// Fetch subjects for the course
$subjects = [];
$stmt2 = $conn->prepare("SELECT id, subject_name FROM add_subject WHERE course_id = ? ORDER BY id ASC");
$stmt2->bind_param("i", $course_id);
$stmt2->execute();
$res2 = $stmt2->get_result();
while ($row = $res2->fetch_assoc()) {
    $subjects[$row['id']] = $row['subject_name'];
}
$stmt2->close();

// Fetch exams for the course
$exams = [];
$stmt3 = $conn->prepare("
    SELECT e.id, s.subject_name, e.duration, e.mark 
    FROM add_exam e
    JOIN add_subject s ON e.subject_name = s.subject_name
    WHERE s.course_id = ?
    ORDER BY e.id ASC
");
$stmt3->bind_param("i", $course_id);
$stmt3->execute();
$res3 = $stmt3->get_result();
while ($row = $res3->fetch_assoc()) {
    $exams[$row['subject_name']][] = $row;
}
$stmt3->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Take Exam</title>
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
        Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?>
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
      <li><a href="student_study_material.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="book-open"></i><span>Study Material</span></a></li>
      <li><a href="student_video_class.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="video"></i><span>Video Class</span></a></li>
      <li><a href="take_exam.php" class="flex items-center space-x-3 bg-blue-700 p-2 rounded-lg"><i data-feather="edit-3"></i><span>Take Exam</span></a></li>
      <li><a href="certificate.php" class="flex items-center space-x-3 hover:bg-blue-500 p-2 rounded-lg"><i data-feather="award"></i><span>Certification & Marksheet</span></a></li>
    </ul>
  </aside>

  <!-- Main content -->
  <main class="ml-64 flex-1 p-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Available Exams for <?php echo htmlspecialchars($courseName); ?></h1>

    <?php if (empty($subjects)): ?>
      <p class="text-gray-600 text-lg">No subjects found for this course.</p>
    <?php else: ?>
      <div class="space-y-6">
        <?php foreach ($subjects as $id => $subject_name): ?>
          <?php
          // Check if student already took this subject
          $stmtCheck = $conn->prepare("SELECT id FROM result WHERE student_email = ? AND course_name = ? AND subject = ? LIMIT 1");
          $stmtCheck->bind_param("sss", $_SESSION['email'], $courseName, $subject_name);
          $stmtCheck->execute();
          $resCheck = $stmtCheck->get_result();
          $alreadyTaken = ($resCheck && $resCheck->num_rows > 0);
          $stmtCheck->close();
          ?>
          <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4 text-blue-700"><?php echo htmlspecialchars($subject_name); ?></h2>

            <?php if (!empty($exams[$subject_name])): ?>
              <table class="w-full border-collapse">
                <thead>
                  <tr class="bg-gray-200 text-gray-800">
                    <th class="p-3 border text-left">Subject Name</th>
                    <th class="p-3 border text-center">Duration (min)</th>
                    <th class="p-3 border text-center">Total Marks</th>
                    <th class="p-3 border text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($exams[$subject_name] as $exam): ?>
                  <?php
                    $total_marks = 0;
                    if(isset($exam['id'])){
                        $q_res = $conn->query("SELECT SUM(marks) as total FROM exam_questions WHERE exam_id = ".$exam['id']);
                        $row_total = $q_res->fetch_assoc();
                        $total_marks = $row_total['total'] ?? 0;
                    }
                  ?>
                  <tr class="hover:bg-gray-100">
                    <td class="p-3 border"><?php echo htmlspecialchars($exam['subject_name']); ?></td>
                    <td class="p-3 border text-center"><?php echo $exam['duration']; ?></td>
                    <td class="p-3 border text-center"><?= $total_marks ?></td>
                    <td class="p-3 border text-center">
                      <?php if ($alreadyTaken): ?>
                        <span class="text-gray-500 font-semibold">Already Taken</span>
                      <?php else: ?>
                        <a href="start_exam.php?exam_id=<?php echo $exam['id']; ?>" 
                           class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">
                          Start Exam
                        </a>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>
              <p class="text-gray-500 mt-2">No exams available for this subject.</p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>
</div>

<script>feather.replace();</script>
</body>
</html>
