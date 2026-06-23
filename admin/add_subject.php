<?php
include __DIR__ . '/../database.php';

// Get course_id from URL
$course_id = $_GET['course_id'] ?? null;

// Fetch course name
$course_name = '';
if ($course_id) {
    $stmt = $conn->prepare("SELECT course_name FROM add_course WHERE id=?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $stmt->bind_result($course_name);
    $stmt->fetch();
    $stmt->close();
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];  // use course_id instead of course_name
    $subjects = $_POST['subject_name']; // array of subjects

    foreach ($subjects as $subject) {
        if (!empty(trim($subject))) {
            $stmt = $conn->prepare("INSERT INTO add_subject (course_id, subject_name) VALUES (?, ?)");
            $stmt->bind_param("is", $course_id, $subject); // ✅ correct binding
            $stmt->execute();
            $stmt->close();
        }
    }

    echo "<script>alert('✅ Subjects added successfully!');window.location='subject.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Subjects</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
      body {
          background: linear-gradient(135deg, #74ebd5 0%, #9face6 100%);
          font-family: "Poppins", sans-serif;
          min-height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
      }
      .card {
          border-radius: 16px;
          box-shadow: 0 6px 18px rgba(0,0,0,0.15);
          background: #fff;
          width: 600px;
          max-width: 100%;
      }
      .card h3 {
          font-weight: 600;
      }
      .subject-input input {
          border-radius: 8px;
      }
      .remove-btn {
          cursor: pointer;
          color: #dc3545;
          margin-left: 10px;
          font-size: 1.2rem;
      }
      .remove-btn:hover {
          color: #a71d2a;
      }
      .btn-primary {
          background: #4a69bd;
          border: none;
      }
      .btn-primary:hover {
          background: #1e3799;
      }
      .btn-success {
          background: #38ada9;
          border: none;
      }
      .btn-success:hover {
          background: #079992;
      }
  </style>
</head>
<body>
<div class="container">
    <div class="card p-4">
        <h3 class="mb-3 text-center text-dark">
            <i class="bi bi-book"></i> Add Subjects for 
            <span class="text-primary"><?php echo htmlspecialchars($course_name); ?></span>
        </h3>
        <hr>

        <form method="POST">
            <!-- ✅ Hidden input should store course_id -->
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">

            <!-- Subject Input Wrapper -->
            <div id="subjectWrapper">
                <div class="subject-input input-group mb-2">
                    <input type="text" name="subject_name[]" class="form-control" placeholder="Enter Subject Name" required>
                </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2 mt-3 justify-content-center">
                <button type="button" id="addMore" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Add More
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Save Subjects
                </button>
                <a href="subject.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById("addMore").addEventListener("click", function() {
    const wrapper = document.getElementById("subjectWrapper");
    const inputDiv = document.createElement("div");
    inputDiv.classList.add("subject-input", "input-group", "mb-2");

    inputDiv.innerHTML = `
        <input type="text" name="subject_name[]" class="form-control" placeholder="Enter Subject Name" required>
        <span class="remove-btn input-group-text"><i class="bi bi-x-circle"></i></span>
    `;

    wrapper.appendChild(inputDiv);

    // Add remove event
    inputDiv.querySelector(".remove-btn").addEventListener("click", function() {
        inputDiv.remove();
    });
});
</script>
</body>
</html>
