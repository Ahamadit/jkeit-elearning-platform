<?php
include __DIR__ . '/../database.php'; // Your DB connection

$message = "";
$alertType = "";
$redirect = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $paragraph = $_POST['paragraph'];

    // Image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $imageName;

        // Create folder if not exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO banner (title, paragraph, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $paragraph, $imageName);
            if ($stmt->execute()) {
                $message = "Banner Added Successfully!";
                $alertType = "success";
                $redirect = true;
            } else {
                $message = "Database error. Please try again.";
                $alertType = "error";
            }
            $stmt->close();
        } else {
            $message = "Error uploading image!";
            $alertType = "error";
        }
    } else {
        $message = "Please select an image file.";
        $alertType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Banner</title>

  <!-- ✅ Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- ✅ Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <!-- ✅ SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background: linear-gradient(135deg, #74ABE2, #5563DE);
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .form-container {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      width: 100%;
      padding: 30px 40px;
      transition: all 0.3s ease;
    }
    .form-container:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }
    .form-title {
      font-weight: 600;
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }
    .form-control, .form-control:focus {
      border-radius: 12px;
      box-shadow: none;
      border: 1px solid #ccc;
    }
    .btn-custom {
      background-color: #5563DE;
      color: #fff;
      border-radius: 12px;
      padding: 10px 15px;
      font-weight: 500;
      width: 100%;
      transition: all 0.3s ease;
    }
    .btn-custom:hover {
      background-color: #3740A3;
      transform: scale(1.02);
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h3 class="form-title">Add New Banner</h3>

    <form method="POST" enctype="multipart/form-data">
      <!-- Title -->
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" placeholder="Enter banner title" required>
      </div>

      <!-- Paragraph -->
      <div class="mb-3">
        <label class="form-label">Paragraph</label>
        <textarea name="paragraph" class="form-control" rows="3" placeholder="Enter banner description" required></textarea>
      </div>

      <!-- Image -->
      <div class="mb-3">
        <label class="form-label">Upload Image</label>
        <input type="file" name="image" class="form-control" accept="image/*" required>
      </div>

      <button type="submit" class="btn btn-custom">Submit</button>
    </form>
  </div>

  <?php if (!empty($message)): ?>
    <script>
      Swal.fire({
        icon: '<?php echo $alertType; ?>',
        title: '<?php echo $message; ?>',
        showConfirmButton: false,
        timer: 2000
      }).then(() => {
        <?php if ($redirect): ?>
          window.location.href = 'banner.php';
        <?php endif; ?>
      });
    </script>
  <?php endif; ?>

</body>
</html>
