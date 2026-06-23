<?php
// Include database connection
include __DIR__ . '/database.php'; // make sure this file exists and $conn is set

// Fetch all team members
$query = "SELECT * FROM jkeit_team ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>  JKEIT </title>

    <!-- SEO Meta -->
    <meta name="description" content="JAN KALYAN EDUCATIONAL INSTITUTE OF TECHNOLOGY (JKEIT) - A professional institute providing quality education, skill development, and placement support in Mathura, Uttar Pradesh.">
    <meta name="keywords" content="JKEIT, Education, Institute, Mathura, Skill Development, Courses, Technology, Admission, Training, Placement">

    <!-- Favicons -->
    <link href="assets/logo/logo1.jpeg" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&family=Poppins:wght@300;400;500;600;700;900&family=Raleway:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Font Awesome (Fixed version) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-8nAq3xM2Fhw6sKybUQG2Q9Z1WlA7wqsdX5jKPrXDf1n4+FR+3Sk9JbD1+6r2V8uxG5cEhz0k2I41fU/jS7y8wg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- Footer & Custom Fixes -->
    <style>
        body {
            padding-top: 120px;
            /* Prevent content overlap with fixed header */
        }

        #footer a {
            color: #ddd;
            transition: color 0.3s ease;
        }

        #footer a:hover {
            color: #fff;
        }

        .social-links a {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px;
            border-radius: 50%;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .social-links a:hover {
            background: #fff;
            color: #37423B !important;
            transform: translateY(-4px);
        }

        /* Preloader */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #fff url("assets/img/loader.gif") no-repeat center center;
            z-index: 9999;
        }



        /* vision and hero section css   */

        /* Hero Section */
        /* Hero Section */
        .hero {
            position: relative;
            width: 100%;
            height: 60vh;
            /* balanced height */
            max-height: 400px;
            /* don’t get too tall on big screens */
            min-height: 200px;
            /* don’t shrink too much */
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        /* Hero Background Image */
        .hero-img {
            position: absolute;
            inset: 0;
            /* shorthand for top/right/bottom/left:0 */
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* fills area while cropping */
            object-position: center;
            z-index: 1;
        }

        /* Content Overlay */
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            padding: 0 20px;
        }

        /* Reduce text margins so they don’t push height */
        .hero-content h2,
        .hero-content p {
            margin: 0.3em 0;
            line-height: 1.3;
        }

        /* Mobile tweak: make hero shorter */
        @media (max-width: 768px) {
            .hero {
                height: 25vh;
                min-height: 150px;
            }
        }



        /* Vision & Mission Cards */
        .vision-mission .card {
            border: none;
            transition: all 0.4s ease-in-out;
            background: #fff;
        }

        .vision-mission .card:hover {
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            color: #fff;
            transform: translateY(-8px);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        }

        .vision-mission .card:hover i,
        .vision-mission .card:hover h4,
        .vision-mission .card:hover p {
            color: #fff !important;
        }

        @media (max-width: 640px) {
            section header {
                flex-direction: column;
                text-align: center;
            }

            section header div {
                margin: 4px 0;
            }
        }
    </style>
</head>

<body class="index-page">

    <!-- Fixed Header Wrapper -->
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

    <main class="main">


        <section id="hero" class="hero section dark-background">
            <img src="assets/slider/slider2.avif" alt="JKEIT Team" class="hero-img" data-aos="fade-in">
            <div class="container hero-content text-center">
                <h2 data-aos="fade-up" data-aos-delay="100">OUR JKEIT TEAM</h2>
                <p data-aos="fade-up" data-aos-delay="200">
                    Meet the dedicated professionals driving our mission of quality education and practical skills.
                </p>
            </div>
        </section>

        <!-- Team Section -->
        <section id="team" class="team section py-5 bg-light">
            <div class="container" data-aos="fade-up">

                <!-- Section Title -->
                <div class="section-title text-center mb-5">
                    <h2 class="fw-bold">Meet Our Team</h2>
                    <p class="text-muted">The dedicated professionals behind JKEIT’s vision and success</p>
                </div>

                <div class="container py-5">
                    <div class="row gy-4 justify-content-center">

                        <?php
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Optional: set color based on role or just use a default
                                $roleColor = "text-info"; // you can customize based on role
                                echo '<div class="col-lg-3 col-md-6" data-aos="fade-up">';
                                echo '  <div class="card shadow-sm p-4 rounded-3 text-center h-100">';
                                echo '      <h5 class="fw-bold">' . htmlspecialchars($row['name']) . '</h5>';
                                echo '      <p class="' . $roleColor . '">' . htmlspecialchars($row['role']) . '</p>';
                                echo '      <p class="text-muted small">' . htmlspecialchars($row['details']) . '</p>';
                                echo '  </div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="text-center">No team members found.</p>';
                        }
                        ?>

                    </div>
                </div>
            </div>
        </section>

    </main>


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

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

    <!-- Swiper CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</body>

</html>