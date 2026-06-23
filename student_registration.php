<?php
session_start();
include __DIR__ . '/admin/../database.php';

// Get course_id from URL or session
$course_id = $_GET['course_id'] ?? $_SESSION['course_id'] ?? null;
if (!$course_id) {
    die("❌ Course not selected. Please go back and choose a course.");
}

// Fetch course details (including duration)
$stmt = $conn->prepare("SELECT course_name, price, duration FROM add_course WHERE id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row_course = $result->fetch_assoc()) {
    $course_name = $row_course['course_name'];
    $course_price = $row_course['price'];
    $course_duration = $row_course['duration']; // ✅ fetch duration
} else {
    die("❌ Course not found.");
}
$stmt->close();

// Handle form submit
$success = false;
$errorMsg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name        = $_POST['name'];
    $dob         = $_POST['dob'];
    $gender      = $_POST['gender'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $email       = $_POST['email'];
    $phone       = $_POST['phone'];
    $nationality = $_POST['nationality'];
    $address     = $_POST['address'];
    $qualification = $_POST['qualification'];
    $course      = $course_name;
    $price       = $course_price;
    $duration    = $course_duration; // ✅ add duration to insert
    $id_proof    = $_POST['id_proof'];
    $state       = $_POST['state'];
    $city        = $_POST['city'];
    $pin_code    = $_POST['pin_code'];

    // File uploads
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $qualification_certificate = $_FILES['qualification_certificate']['name'];
    $upload_id   = $_FILES['upload_id']['name'];
    $image       = $_FILES['image']['name'];
    $signature   = $_FILES['signature']['name'];

    move_uploaded_file($_FILES['qualification_certificate']['tmp_name'], $uploadDir . $qualification_certificate);
    move_uploaded_file($_FILES['upload_id']['tmp_name'], $uploadDir . $upload_id);
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
    move_uploaded_file($_FILES['signature']['tmp_name'], $uploadDir . $signature);

    // Check if already registered
    $checkSql = "SELECT id FROM `student-registration` WHERE email = ? OR phone = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ss", $email, $phone);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $errorMsg = "You are already registered with this email or phone.";
    } else {
        // Insert query including duration
        $sqlInsert = "INSERT INTO `student-registration`
            (name, dob, gender, father_name, mother_name, email, phone, nationality, address, qualification, course, price, duration, qualification_certificate, id_proof, upload_id, image, signature, state, city, pin_code)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlInsert);
        $stmt->bind_param("sssssssssssssssssssss",
            $name, $dob, $gender, $father_name, $mother_name, $email, $phone, $nationality, $address, $qualification,
            $course, $price, $duration, $qualification_certificate, $id_proof, $upload_id, $image, $signature, $state, $city, $pin_code
        );

        if ($stmt->execute()) {
            $success = true;
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['email'] = $email;
            $_SESSION['course_id'] = $course_id;
        } else {
            $errorMsg = $stmt->error;
        }
    }
}
?>

<!-- Success/Error popup -->
<?php if ($success): ?>
<script>
alert("Registration successful!");
window.location.href = "dashboard.php";
</script>
<?php elseif ($errorMsg): ?>
<script>
alert("<?php echo addslashes($errorMsg); ?>");
</script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Registration Form</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: #eef2f3; display: flex; align-items: center; justify-content: center; min-height: 100vh; font-family: 'Segoe UI', sans-serif; }
.form-container { width: 100%; max-width: 650px; background: #ffffff; padding: 30px 25px; border-radius: 14px; box-shadow: 0 6px 18px rgba(0,0,0,0.1); }
.form-header { text-align: center; margin-bottom: 20px; }
.form-header h2 { font-weight: 700; font-size: 24px; color: #1a237e; }
.form-label { font-weight: 600; font-size: 14px; color: #333; }
.btn-submit { background: linear-gradient(135deg, #1a73e8, #673ab7); border: none; color: #fff; padding: 10px 30px; font-size: 16px; border-radius: 25px; transition: 0.3s; }
.btn-submit:hover { transform: translateY(-2px); opacity: 0.9; }
</style>
</head>
<body>
<div class="form-container">
<div class="form-header">
<h2>Student Registration</h2>
<p>Please fill out the form carefully</p>
</div>

<form method="POST" enctype="multipart/form-data">
<div class="row g-3">
<!-- Name, DOB, Gender, Parents -->
<div class="col-md-6">
<label class="form-label">Full Name</label>
<input type="text" name="name" class="form-control" required>
</div>
<div class="col-md-6">
<label class="form-label">Date of Birth</label>
<input type="date" name="dob" class="form-control" required>
</div>
<div class="col-md-6">
<label class="form-label">Gender</label>
<select name="gender" class="form-select" required>
<option value="">Choose...</option>
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>
</div>
<div class="col-md-6">
<label class="form-label">Father's Name</label>
<input type="text" name="father_name" class="form-control" required>
</div>
<div class="col-md-6">
<label class="form-label">Mother's Name</label>
<input type="text" name="mother_name" class="form-control" required>
</div>

<!-- Contact -->
<div class="col-md-6">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" required>
</div>
<div class="col-md-6">
<label class="form-label">Phone</label>
<input type="tel" name="phone" class="form-control" required>
</div>

<!-- Nationality & Address -->
<div class="col-md-6">
<label class="form-label">Nationality</label>
<input type="text" name="nationality" class="form-control" required>
</div>
<div class="col-12">
<label class="form-label">Address</label>
<textarea name="address" class="form-control" rows="2" required></textarea>
</div>

<!-- Qualification -->
<div class="col-md-6">
<label class="form-label">Qualification</label>
<input type="text" name="qualification" class="form-control" required>
</div>

<!-- Course & Price -->
<div class="col-md-6">
<label class="form-label">Course</label>
<input type="text" name="course" class="form-control" value="<?php echo htmlspecialchars($course_name); ?>" readonly>
</div>
<div class="col-md-6">
<label class="form-label">Price ₹</label>
<input type="text" name="price" class="form-control" value="<?php echo htmlspecialchars($course_price); ?>" readonly>
</div>
<div class="col-md-6">
<label class="form-label">Duration</label>
<input type="text" name="duration" class="form-control" value="<?php echo htmlspecialchars($course_duration); ?>" readonly>
</div>

<!-- File Uploads -->
<div class="col-md-6">
<label class="form-label">Qualification Certificate</label>
<input type="file" name="qualification_certificate" class="form-control" required>
</div>
<div class="col-md-6">
<label class="form-label">ID Proof</label>
<select name="id_proof" class="form-select" required>
<option value="">Select...</option>
<option>Aadhar Card</option>
<option>PAN Card</option>
<option>Driving License</option>
<option>Passport</option>
</select>
</div>
<div class="col-md-6">
<label class="form-label">Upload ID Proof</label>
<input type="file" name="upload_id" class="form-control" required>
</div>
<div class="col-md-6">
<label class="form-label">Upload Image</label>
<input type="file" name="image" class="form-control" required>
</div>
<div class="col-md-6">
<label class="form-label">Upload Signature</label>
<input type="file" name="signature" class="form-control" required>
</div>

<!-- Location -->
<div class="col-md-6">
<label class="form-label">State</label>
<input type="text" name="state" class="form-control" required>
</div>
<div class="col-md-6">
<label class="form-label">City</label>
<input type="text" name="city" class="form-control" required>
</div>
<div class="col-md-6">
<label class="form-label">Pin Code</label>
<input type="text" name="pin_code" class="form-control" required>
</div>

</div>
<div class="text-center mt-4">
<button type="submit" class="btn-submit">Submit</button>
</div>
</form>
</div>
</body>
</html>
