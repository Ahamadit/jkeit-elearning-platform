<?php
session_start();
include __DIR__ . '/database.php'; // Database connection

$courseName = $_SESSION['course_name'] ?? 'Your Course';

// Fetch notifications
$sql = "SELECT * FROM prospect ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>JKEIT</title>

    <!-- SEO Meta -->
    <meta name="description"
        content="Stay updated with all latest notifications from JAN KALYAN EDUCATIONAL INSTITUTE OF TECHNOLOGY (JKEIT)">
    <meta name="keywords"
        content="JKEIT, Notifications, Announcements, Results, Circulars, News, Updates">

    <!-- Favicons -->
    <link href="assets/logo/logo1.jpeg" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" />

    <!-- Main CSS -->
    <link href="assets/css/main.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9fafc;
            padding-top: 120px;
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 45vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            overflow: hidden;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 1;
        }

        .hero img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .hero-content h2 {
            font-weight: 700;
            font-size: 2.5rem;
        }

        /* Notification Table */
        .notification-container {
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            width: 95%;
            max-width: 1100px;
        }

        .notification-container h3 {
            color: #023E8A;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 10px;
        }

        thead {
            background: #023E8A;
            color: #fff;
        }

        th,
        td {
            padding: 14px 18px;
            text-align: left;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background: #f3f6fa;
        }

        tr:hover {
            background: #e9f2ff;
            transition: 0.3s;
        }

        a.pdf-link {
            color: #0077b6;
            font-weight: 600;
            text-decoration: none;
        }

        a.pdf-link:hover {
            color: #023E8A;
            text-decoration: underline;
        }

        /* Responsive Table */
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .hero-content h2 {
                font-size: 1.8rem;
            }

            .notification-container {
                padding: 20px;
            }
        }

        /* Footer */
        #footer {
            background: #37423B;
            color: #fff;
            padding: 40px 0 10px;
        }

        #footer a {
            color: #ddd;
            text-decoration: none;
            transition: 0.3s;
        }

        #footer a:hover {
            color: #fff;
        }

        .social-links a {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px;
            border-radius: 50%;
            margin-right: 6px;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .social-links a:hover {
            background: #fff;
            color: #37423B;
            transform: translateY(-3px);
        }
    </style>
</head>

<body>


    <div class="fixed-top" style="z-index: 1030;">

        <!-- Top Blue Bar -->
        <section style="background: #023E8A; padding: 8px 20px;">
            <header style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">

                <!-- Left Side (Phone) -->
                <div style="margin: 5px 0;">
                    <a href="tel:+919634599903"
                        style="text-decoration: none; color: #fff; font-size: 1rem; font-weight: 500; display: flex; align-items: center;">
                        <i class="fa-solid fa-phone" style="margin-right: 8px; color: #FFD60A;"></i>
                        +91 9634599903
                    </a>
                </div>

                <!-- Right Side (Email) -->
                <div style="margin: 5px 0;">
                    <a href="mailto:jkeitonline@gmail.com"
                        style="text-decoration: none; color: #fff; font-size: 1rem; display: flex; align-items: center;">
                        <i class="fa-solid fa-envelope" style="margin-right: 6px; color: #FFD60A;"></i>
                        jkeitonline@gmail.com
                    </a>
                </div>

            </header>
        </section>

        <!-- Main White Header -->
        <header id="header" class="header d-flex align-items-center bg-white shadow-sm">
            <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

                <!-- Logo -->
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div>
                        <img src="assets/logo/logo2.jpeg" alt="JAN KALYAN EDUCATION INSTITUTE Logo"
                            style="width: 250px; height: auto; object-fit: contain;">
                    </div>
                </div>

                <!-- Navbar -->
                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="index.php" class="active">Home</a></li>

                        <li class="dropdown"><a href="#"><span>About us</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="vision.php">Vision & Mission</a></li>
                                <li><a href="jkieteam.php">Our Team JKEIT</a></li>
                                <li><a href="governing.php">Governing Council - JKEIT</a></li>
                                <li><a href="authorization.php">Authorization - JKEIT</a></li>
                            </ul>
                        </li>

                         <li class="dropdown"><a href="#"><span>Student Corner Tab</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="login.php">Student Login</a></li>
                                <li><a href="online_course_material.php">Online Course Material </a></li>
                            </ul>
                        </li>

                        <li class="dropdown"><a href="#"><span>Download</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="prospects.php">Prospectus</a></li>
                                <li><a href="notifications.php">Notification</a></li>
                                <li><a href="download_courses.php">Course</a></li>
                                <li><a href="poster.php">Poster</a></li>
                            </ul>
                        </li>

                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="course.php">Course</a></li>
                    </ul>

                    <!-- Mobile Toggle -->
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

            </div>
        </header>
    </div>
    <!-- Hero Section -->
 

    <!-- Notification Table -->
    <div class="notification-container" data-aos="fade-up" data-aos-delay="100">
        <h3>Recent Prospects</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>SR No.</th>
                        <th>Title</th>
                        <th>PDF File</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        $sr = 1;
                        while ($row = $result->fetch_assoc()) {
                            $pdfFile = $row['pdf'];
                            $pdfPath = __DIR__ . '/admin/uploads/' . $pdfFile;
                            $pdfUrl = 'admin/uploads/' . $pdfFile;

                            echo "<tr>
                      <td>{$sr}</td>
                      <td>" . htmlspecialchars($row['title']) . "</td>
                      <td>";
                            if (!empty($pdfFile) && file_exists($pdfPath)) {
                                echo "<a href='{$pdfUrl}' target='_blank' class='pdf-link'><i class='fa-solid fa-file-pdf me-2 text-danger'></i>View PDF</a>";
                            } else {
                                echo "<span class='text-muted'>PDF not available</span>";
                            }
                            echo "</td></tr>";
                            $sr++;
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center py-4 text-muted'>No notifications found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer id="footer" class="footer position-relative" style="background: #37423B; color: #fff;">

        <div class="container footer-top py-5">
            <div class="row gy-4">

                <!-- Logo & About Us -->
                <div class="col-lg-4 col-md-12 footer-about text-center text-lg-start">
                    <img src="assets/logo/logo2.jpeg" alt="JKEIT Logo" class="mb-3" style="max-width: 150px;">
                    <h5 class="fw-bold text-white mb-3">About JKEIT</h5>
                    <p class="text-light">
                        At the Jan Kalyan Educatinal Institute of Technology (JKEIT), we are dedicated to Empowering India's youth through comprehensive skill development.
                    </p>
                    <div class="social-links d-flex mt-3 justify-content-center justify-content-lg-start">
                        <a href="https://www.youtube.com/@jkeit" class="me-2" target="_blank"><i class="bi bi-youtube"></i></a>
                        <a href="https://www.facebook.com/share/14Ripq8N4ZG/?mibextid=wwXIfr" class="me-2" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/jkeit.in/" class="me-2" target="_blank"><i class="bi bi-instagram"></i></a>
                    </div>

                </div>

                <!-- Useful Links -->
                <div class="col-lg-2 col-md-3 footer-links">
                    <h5 class="fw-bold text-white">Useful Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="admin/login.php" class="text-light text-decoration-none">Admin Login</a></li>
                        <li><a href="franchisee_login.php" class="text-light text-decoration-none">Franchisee Login</a></li>
                        <li><a href="login.php" class="text-light text-decoration-none">Student Login</a></li>
                    </ul>
                </div>

                <!-- Our Services -->
                <div class="col-lg-2 col-md-3 footer-links">
                    <h5 class="fw-bold text-white">Our Courses</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Computer Course</a></li>
                        <li><a href="#" class="text-light text-decoration-none">IT Programs</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Digital Marketing</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Diploma Course</a></li>

                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6 footer-contact">
                    <h5 class="fw-bold text-white mb-3">Contact Us</h5>
                    <ul class="list-unstyled text-light">
                        <li class="mb-2">
                            <a href="mailto:jkeitonline@gmail.com" class="text-light text-decoration-none d-flex align-items-center">
                                <i class="bi bi-envelope-fill me-2"></i> jkeitonline@gmail.com
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="tel:+919634599903" class="text-light text-decoration-none d-flex align-items-center">
                                <i class="bi bi-telephone-fill me-2"></i> 9634599903
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="https://www.google.com/maps/search/Mathura,+Uttar+Pradesh+281004" target="_blank" class="text-light text-decoration-none d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill me-2"></i> Mathura, Uttar Pradesh - 281004
                            </a>
                        </li>
                        <li>
                            <a href="https://jkeit.in" target="_blank" class="text-warning text-decoration-none d-flex align-items-center">
                                <i class="bi bi-globe me-2"></i> jkeit.in
                            </a>
                        </li>
                    </ul>
                </div>


            </div>
        </div>

        <!-- Copyright -->
        <div class="container text-center mt-4 border-top pt-3" style="border-color: rgba(255,255,255,0.2)!important;">
            <p class="mb-0">© <span>Copyright</span> <strong class="px-1">JKEIT</strong> <span>All Rights Reserved</span></p>
            <small class="text-light">Designed by <a href="#" class="text-warning">Ahamad</a> | Distributed by </small>
        </div>

    </footer>

    <!-- Scripts -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>