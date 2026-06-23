<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

include __DIR__ . '/database.php';
include __DIR__ . '/phprqcode/qrlib.php'; // Correct QR library path

$studentEmail = $_SESSION['email'];

// Fetch student info
$student_stmt = $conn->prepare("SELECT id, name, dob, duration, father_name, course, image FROM `student-registration` WHERE email = ?");
$student_stmt->bind_param("s", $studentEmail);
$student_stmt->execute();
$student_result = $student_stmt->get_result();
$student = $student_result->fetch_assoc();
$student_stmt->close();

if (!$student) {
    die("❌ Student record not found.");
}

// Fetch result data
$result_stmt = $conn->prepare("SELECT course_name, subject, obtained_marks, total_marks, grade, created_at 
                               FROM result 
                               WHERE student_email = ? ORDER BY created_at DESC");
$result_stmt->bind_param("s", $studentEmail);
$result_stmt->execute();
$result_data = $result_stmt->get_result();

$results = [];
$totalMarks = 0;
$obtainedMarks = 0;
$dateOfIssue = "";

while ($row = $result_data->fetch_assoc()) {
    $results[] = $row;
    $totalMarks += (int)$row['total_marks'];
    $obtainedMarks += (int)$row['obtained_marks'];

    if (empty($dateOfIssue)) {
        $dateOfIssue = date("d-m-Y", strtotime($row['created_at']));
    }
}
$result_stmt->close();

// Calculate percentage & result
$percentage = $totalMarks > 0 ? round(($obtainedMarks / $totalMarks) * 100, 2) : 0;
$resultStatus = $percentage >= 33 ? "Pass" : "Fail";

$enrollmentNo = '21240' . $student['id']; // Concatenate static + dynamic ID

$qrData = "Enrollment: {$enrollmentNo}\n"
    . "Name: {$student['name']}\n"
    . "Father: {$student['father_name']}\n"
    . "DOB: {$student['dob']}\n"
    . "Course: {$student['course']}\n"
    . "Duration: {$student['duration']}\n"
    . "Percentage: {$percentage}%\n"
    . "Result: {$resultStatus}\n"
    . "Date of Issue: {$dateOfIssue}";

// QR folder
$qrFolder = __DIR__ . '/assets/qrcodes/';
if (!is_dir($qrFolder)) {
    mkdir($qrFolder, 0755, true);
}

// QR file path
$qrFile = $qrFolder . $student['id'] . '.png';

// Force regeneration of QR code
QRcode::png($qrData, $qrFile, QR_ECLEVEL_L, 6);

// Path for HTML display
$qrUrl = 'assets/qrcodes/' . $student['id'] . '.png';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Marksheet - <?= htmlspecialchars($student['name']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .certificate-container {
            width: 794px;
            height: 1123px;
            position: relative;
            background-image: url('assets/marsheet/jkeitS.JPG');
            background-size: cover;
            background-position: top center;
            background-repeat: no-repeat;
            overflow: hidden;
        }

        @media print {
            body {
                margin: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .certificate-container {
                page-break-inside: avoid;
                width: 794px;
                height: 1123px;
            }

            .no-print {
                display: none;
            }
        }


        .certificate-text {
            font-family: 'Georgia', 'Times New Roman', serif;
            /* professional serif font */
            font-weight: 600;
            /* semi-bold for paragraph text */
            line-height: 2.2;
            /* more spacing between lines for clarity */
            letter-spacing: 0.7px;
            /* subtle letter spacing */
            color: #1C1C1C;
            /* dark gray for readability */
            text-align: justify;
            /* neat alignment */
            font-size: 1.1rem;
            /* slightly larger font */
            background: rgba(255, 255, 255, 0.15);
            /* subtle background to separate text */
            padding: 16px 18px;
            /* breathing space around text */
            border-radius: 8px;
            /* smooth rounded edges */
        }

        .certificate-text .student-data {
            font-weight: 400;
            /* normal weight for database data */
            color: #0F172A;
            /* slightly darker for emphasis */
            letter-spacing: 0.5px;
            /* slightly tighter for dynamic data */
        }
    </style>
</head>

<body class="flex flex-col items-center py-10">

    <div class="certificate-container shadow-2xl rounded-xl">

        <!-- Serial & Enrollment -->
        <div class="absolute top-[20px] left-6 right-6 flex justify-between text-gray-800">
            <h3 class="text-lg font-semibold">
                Serial No: <span class="font-bold">JKEIT01<?= htmlspecialchars($student['id']) ?></span>
            </h3>
            <h3 class="text-lg font-semibold">
                Enrollment No: <span class="font-bold">21240<?= htmlspecialchars($student['id']) ?></span>
            </h3>
        </div>



        <!-- Overlay Content -->
        <div class="absolute inset-0 flex flex-col items-center justify-start px-6 md:px-12 text-gray-800 mt-[280px]">

            <div class="w-full grid grid-cols-3 gap-4 items-start">


                <!-- Student Photo -->
                <div class="flex justify-center  mb-4">
                    <?php if (!empty($student['image'])): ?>
                        <?php
                        // Convert backslashes to forward slashes
                        $photoPath = str_replace('\\', '/', $student['image']);

                        // Remove any leading drive letters or backslashes
                        $photoPath = preg_replace('/^[A-Za-z]:\//', '', $photoPath);
                        $photoPath = ltrim($photoPath, '/');

                        // Prepend project folder to make it web-accessible
                        $photoUrl = 'uploads/' . basename($photoPath);

                        // Optional: check if file exists, else show placeholder
                        if (!file_exists(__DIR__ . '/uploads/' . basename($photoPath))) {
                            $photoUrl = 'assets/photos/default.png'; // fallback image
                        }
                        ?>
                        <img src="<?= htmlspecialchars($photoUrl) ?>"
                            alt="Student Photo"
                            class="w-32 h-40 object-cover border-2 border-gray-400 rounded-md shadow-md">
                    <?php else: ?>
                        <div class="w-32 h-40 flex items-center justify-center border-2 border-gray-400 bg-gray-100 text-gray-500">
                            No Photo
                        </div>
                    <?php endif; ?>
                </div>





            </div>


            <?php if (!empty($results)): ?>
                <div class="mt-6 w-full px-4">

                    <?php
                    // Calculate grade automatically
                    if ($percentage >= 90) $grade = "A+";
                    elseif ($percentage >= 80) $grade = "A";
                    elseif ($percentage >= 70) $grade = "B+";
                    elseif ($percentage >= 60) $grade = "B";
                    elseif ($percentage >= 50) $grade = "C";
                    elseif ($percentage >= 33) $grade = "D";
                    else $grade = "F";
                    ?>

                    <p class="certificate-text">
                        This is to Certify that <strong>Mr./Mrs.</strong>
                        <span class="student-data"><?= htmlspecialchars($student['name']) ?></span>,
                        S/O, D/O <span class="student-data"><?= htmlspecialchars($student['father_name']) ?></span>,
                        Born on <span class="student-data"><?= htmlspecialchars($student['dob']) ?></span>,
                        has Successfully Completed the Course
                        <span class="student-data"><?= htmlspecialchars($student['course']) ?></span>
                        at <strong>JAN KALYAN EDUCATIONAL INSTITUTE OF TECHNOLOGY</strong>,
                        of Duration <span class="student-data"><?= htmlspecialchars($student['duration']) ?></span>,
                        and has Achieved the Grade <span class="student-data"><?= $grade ?></span>,
                        with a Total Percentage of <span class="student-data"><?= $percentage ?>%</span>.
                    </p>


                </div>
            <?php endif; ?>






         <!-- Footer with QR -->
<div class="mt-8 flex justify-between items-center w-full px-6">
    <!-- Left side: Result info -->
    <div class="flex flex-col gap-1 text-gray-800">
        <p><strong>Result:</strong> <span class="font-normal"><?= $resultStatus ?></span></p>
        <p><strong>Date of Issue:</strong> <span class="font-normal"><?= $dateOfIssue ?></span></p>
        <p><strong>Place:</strong> <span class="font-normal">Mathura, UP - 281004</span></p>
    </div>

    <!-- Right side: QR code -->
    <div class="flex flex-col items-center">
        <img src="<?= htmlspecialchars($qrUrl) ?>" alt="QR Code" class="w-32 h-32 border rounded-md shadow-md">
        <p class="text-sm mt-2 text-gray-600">Scan for Details</p>
    </div>
</div>


        </div>
    </div>
    <!-- Download Button -->
    <div class="text-center mt-5 no-print">
        <button id="downloadBtn" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Download Certificate
        </button>
    </div>


    <!-- JS: html2canvas + jsPDF for download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        document.getElementById('downloadBtn').addEventListener('click', function() {
            const certificate = document.querySelector('.certificate-container');

            html2canvas(certificate, {
                scale: 2
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const {
                    jsPDF
                } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'px',
                    format: [canvas.width, canvas.height]
                });

                pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
                pdf.save('Marksheet_<?= htmlspecialchars($student['name']) ?>.pdf');
            });
        });
    </script>

</body>

</html>