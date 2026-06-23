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
            background-image: url('assets/marsheet/jkeitm.JPG');
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

                <!-- Student Details -->
                <div class="col-span-2 ml-8 text-lg">
                    <div class="grid grid-cols-1 gap-1">
                        <p><strong>Name:</strong> <?= htmlspecialchars($student['name']) ?></p>
                        <p><strong>DOB:</strong> <?= htmlspecialchars($student['dob']) ?></p>
                        <p><strong>Father Name:</strong> <?= htmlspecialchars($student['father_name']) ?></p>
                        <p><strong>Duration:</strong> <?= htmlspecialchars($student['duration']) ?></p>
                        <p class="md:col-span-2"><strong>Course:</strong> <?= htmlspecialchars($student['course']) ?></p>
                    </div>
                </div>
                <!-- Student Photo -->
                <div class="flex justify-center ml-20 mb-4">
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


            <!-- Results Table -->
            <?php if (!empty($results)): ?>
                <div class="mt-6 w-full">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-collapse border border-gray-300 text-sm md:text-base w-full">
                            <thead>
                                <tr>
                                    <th class="border px-3 py-2">SR No</th>
                                    <th class="border px-3 py-2">Subject</th>
                                    <th class="border px-3 py-2">Max Marks</th>
                                    <th class="border px-3 py-2">Obtained</th>
                                    <th class="border px-3 py-2">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $index => $res): ?>
                                    <tr class="even:bg-transparent hover:bg-indigo-50 transition">
                                        <td class="border px-3 py-2 text-center"><?= $index + 1 ?></td>
                                        <td class="border px-3 py-2"><?= htmlspecialchars($res['subject']) ?></td>
                                        <td class="border px-3 py-2 text-center"><?= $res['total_marks'] ?></td>
                                        <td class="border px-3 py-2 text-center font-bold text-indigo-700"><?= $res['obtained_marks'] ?></td>
                                        <td class="border px-3 py-2 text-center font-semibold"><?= htmlspecialchars($res['grade']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="font-bold">
                                    <td colspan="2" class="border px-3 py-2 text-center">TOTAL</td>
                                    <td class="border px-3 py-2 text-center"><?= $totalMarks ?></td>
                                    <td class="border px-3 py-2 text-center text-indigo-700"><?= $obtainedMarks ?></td>
                                    <td class="border px-3 py-2 text-center"><?= $percentage ?>% (<?= $resultStatus ?>)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Footer with QR -->
            <div class="mt-6 flex justify-between w-full items-center mr-3">
                <div>
                    <p><strong>Result:</strong> <?= $resultStatus ?></p>
                    <p><strong>Date of Issue:</strong> <?= $dateOfIssue ?></p>
                    <p><strong>Place:</strong> Mathura, UP - 281004</p>
                </div>
                <div class="text-center">
                    <img src="<?= htmlspecialchars($qrUrl) ?>" alt="QR Code" class="w-32 h-32 border rounded-md shadow-md">
                    <p class="text-sm mt-2">Scan for Details</p>
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