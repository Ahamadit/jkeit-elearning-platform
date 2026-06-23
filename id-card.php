<?php
session_start();
include "database.php";

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Fetch the last student registered by this email
$stmt = $conn->prepare("SELECT * FROM `student-registration` WHERE email = ? ORDER BY id DESC LIMIT 1");
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("⚠️ You have not registered any student yet.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: #e0f2ff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .id-card-container {
            text-align: center;
        }

        .id-card {
            width: 380px;
            max-width: 90vw;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
            background: #fff;
            font-size: 13px;
        }

        .id-card-top {
            background: linear-gradient(135deg, #1a73e8, #4dabf7);
            color: #fff;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .id-card-top img.logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .id-card-top h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .id-card-body {
            display: flex;
            padding: 12px;
            background: #fff;
        }

        .id-card-body img.photo {
            width: 90px;
            height: 110px;
            border-radius: 6px;
            border: 2px solid #1a73e8;
            object-fit: cover;
            margin-right: 20px; /* 🔹 extra space between image & details */
        }

        .id-card-info {
            flex: 1;
            display: grid;
            grid-template-columns: auto 1fr;
            row-gap: 4px;
            align-items: center;
        }

        .id-card-info strong,
        .id-card-info span {
            display: block;
            padding: 0;
            margin: 0;
            line-height: 1.3;
            font-size: 13px;
            color: #000;
        }

        .id-card-info strong {
            font-weight: 600;
            text-align: left;
            margin-right: 3px; /* 🔹 adds 1-letter space */
        }

        .id-card-info span {
            font-weight: 500;
            text-align: left;
        }

        .id-card-footer {
            padding: 6px 12px;
            background: #1a73e8;
            color: #fff;
            font-weight: bold;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .id-card-footer a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .download-btn {
            margin-top: 12px;
            font-size: 14px;
        }

        @media(max-width: 500px) {
            .id-card {
                width: 90vw;
            }

            .id-card-body {
                flex-direction: column;
                align-items: center;
            }

            .id-card-body img.photo {
                margin-bottom: 8px;
                margin-right: 0;
            }

            .id-card-info {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .id-card-info strong,
            .id-card-info span {
                text-align: center;
            }

            .id-card-footer {
                flex-direction: column;
                text-align: center;
                gap: 4px;
            }
        }
    </style>
</head>

<body>

    <div class="id-card-container">
        <div id="idCard" class="id-card">
            <!-- Top -->
            <div class="id-card-top">
                <img src="assets/logo/logo1.jpeg" alt="Logo" class="logo">
                <h2>JKEIT </h2>
            </div>

            <!-- Body -->
            <div class="id-card-body">
                <img src="uploads/<?php echo htmlspecialchars($student['image']); ?>" alt="Student Photo" class="photo">
                <div class="id-card-info">
                    <strong>Enrollment ID:</strong><span><?php echo "202577135" . str_pad($student['id'], 3, "0", STR_PAD_LEFT); ?></span>
                    <strong>Name:</strong><span><?php echo htmlspecialchars($student['name']); ?></span>
                    <strong>Father:</strong><span><?php echo htmlspecialchars($student['father_name']); ?></span>
                    <strong>Course:</strong><span><?php echo htmlspecialchars($student['course']); ?></span>
                    <strong>DOB:</strong><span><?php echo htmlspecialchars($student['dob']); ?></span>
                    <strong>Mobile:</strong><span><?php echo htmlspecialchars($student['phone']); ?></span>
                </div>
            </div>

            <!-- Footer -->
            <div class="id-card-footer">
                <div class="footer-left">
                    <a href="https://jkeit.in" target="_blank">jkeit.in</a>
                </div>
                <div class="footer-right">
                    <span>Valid: 2025-2026</span>
                </div>
            </div>
        </div>

        <button class="btn btn-primary download-btn" id="downloadBtn">
            <i class="fa-solid fa-download"></i> Download ID Card
        </button>
    </div>

    <script>
        document.getElementById("downloadBtn").addEventListener("click", function() {
            html2canvas(document.getElementById("idCard")).then(function(canvas) {
                let link = document.createElement("a");
                link.download = "Student_ID_Card_<?php echo htmlspecialchars($student['name']); ?>.png";
                link.href = canvas.toDataURL("image/png");
                link.click();
            });
        });
    </script>

</body>
</html>
