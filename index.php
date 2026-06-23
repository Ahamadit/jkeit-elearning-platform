<?php
include __DIR__ . '/database.php'; // Adjust path if needed

// Fetch all courses
$sql = "SELECT * FROM add_course ORDER BY id DESC";
$result = $conn->query($sql);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> JKEIT </title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/logo//logo1.jpeg" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- =======================================================
  * Template Name: Mentor
  * Template URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->





    <!-- course CSS -->
    <style>
        /* ===== Hero Slider ===== */
        .hero-swiper,
        .hero-slider,
        .swiper-slide {
            width: 100%;
            height: 80vh;
            position: relative;
            overflow: hidden;
            background: #fff;
        }

        .hero-slide .hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .hero-slide .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            text-align: center;
            color: #D6FFFF;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
            padding: 0 20px;
        }

        .hero-slide h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #D6FFFF;
        }

        .hero-slide p {
            font-size: 1.1rem;
            color: #D6FFFF;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #fff !important;
            z-index: 3;
        }

        .swiper-pagination {
            z-index: 3;
        }

        .swiper-pagination-bullet {
            background: #fff !important;
            opacity: 0.6;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
        }

        /* ===== Courses Section ===== */

        .courses section {
            padding: 60px 0;
            background: #E9EAF5;
        }

        .courses .section-title h1 {
            color: #37423B;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .courses .section-title p {
            font-size: 1rem;
            color: #555;
        }

        /* Courses Swiper Slide */
        .courses-slider .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: stretch;
            height: 65%;
        }

        /* Course Card */
        .course-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            height: 100%;
            text-align: center;
            padding: 0;
        }

        /* Course Image */
        .course-card img.course-img {
            height: 10px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .course-card:hover img.course-img {
            transform: scale(1.05);
        }

        /* Course Content */
        .course-card h4 {
            color: #023E8A;
            font-weight: 700;
            font-size: 1.2rem;
            margin: 15px 10px 5px 10px;
        }

        .course-card p {
            color: #555;
            font-size: 0.95rem;
            margin: 0 10px 15px 10px;
        }

        /* Hover Effect */
        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        /* Swiper Buttons */
        .swiper-button-next,
        .swiper-button-prev {
            color: #023E8A !important;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            color: #01579B !important;
        }

        /* Pagination Dots */
        .swiper-pagination-bullet {
            background: #023E8A !important;
            opacity: 0.6;
        }

        .swiper-pagination-bullet-active {
            background: #01579B !important;
            opacity: 1;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .course-card img.course-img {
                height: 160px;
            }

            .course-card h4 {
                font-size: 1.1rem;
            }

            .course-card p {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .course-card img.course-img {
                height: 140px;
            }

            .course-card h4 {
                font-size: 1rem;
            }

            .course-card p {
                font-size: 0.85rem;
            }
        }

        /* Swiper buttons */
        .swiper-button-next,
        .swiper-button-prev {
            color: #37423B !important;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            color: #222 !important;
        }

        /* Pagination dots */
        .swiper-pagination-bullet {
            background: #37423B !important;
            opacity: 0.6;
        }

        .swiper-pagination-bullet-active {
            background: #37423B !important;
            opacity: 1;
        }

        /* ===== Partner Logos Section ===== */
        .partners-swiper .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80px;
            /* uniform height */
        }

        .partners-swiper .swiper-slide img {
            max-height: 80px;
            width: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        /* ===== Facilities Section ===== */
        .facility-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            background: #fff;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .facility-card i,
        .facility-card h5 {
            color: #37423B;
        }

        .facility-card:hover {
            background: #37423B;
            color: #fff;
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .facility-card:hover i,
        .facility-card:hover h5 {
            color: #fff;
        }

        .facility-card.active {
            background: #023E8A;
            color: #fff;
        }

        .facility-card.active i,
        .facility-card.active h5 {
            color: #fff;
        }

        /* ===== Footer ===== */
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

        /* ===== Responsive ===== */
        @media (max-width: 992px) {
            .hero-slide h2 {
                font-size: 1.6rem;
            }

            .hero-slide p {
                font-size: 1rem;
            }

            .course-card img.course-img {
                height: 180px;
            }
        }

        @media (max-width: 576px) {
            .hero-slide h2 {
                font-size: 1.3rem;
            }

            .hero-slide p {
                font-size: 0.9rem;
            }

            .course-card img.course-img {
                height: 150px;
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
                        <img src="assets/logo/logo2.jpeg"
                            alt="Institute Logo"
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

        <!-- Hero Section -->
        <section id="hero" class="hero-swiper">
            <div class="swiper swiper-sliders">
                <div class="swiper-wrapper">
                    <?php
                    $banner_sql = "SELECT * FROM banner ORDER BY id DESC";
                    $banner_result = $conn->query($banner_sql);
                    if ($banner_result && $banner_result->num_rows > 0) {
                        while ($row = $banner_result->fetch_assoc()) {
                    ?>
                            <div class="swiper-slide hero-slide">
                                <img src="admin/uploads/<?php echo htmlspecialchars($row['image']); ?>"
                                    alt="<?php echo htmlspecialchars($row['title']); ?>" class="hero-img">
                                <div class="hero-content">
                                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                                    <p><?php echo htmlspecialchars($row['paragraph']); ?></p>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="swiper-slide hero-slide">
                            <img src="assets/slider/default.jpg" alt="Default Banner" class="hero-img">
                            <div class="hero-content">
                                <h2>Welcome to JKEIT</h2>
                                <p>Quality Education & Skill Development</p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <!-- Slider Controls -->
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </section>

        <!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section" style="background: linear-gradient(135deg, #f9fafb, #e9f0ff); padding: 60px 0;">
            <div class="container">

                <div class="row gy-4 align-items-center">

                    <!-- Image -->
                    <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
                        <img src="assets/img/about.jpg" class="img-fluid rounded shadow" alt="About JKEIT">
                    </div>

                    <!-- Content -->
                    <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="fw-bold text-dark mb-3">About Us</h3>
                        <p class="text-secondary">
                            At the <strong>Jan Kalyan Educational Institute of Technology (JKEIT)</strong>, we are dedicated to empowering India's youth through comprehensive skill development.
                        </p>
                        <p class="text-secondary">
                            <strong>JAN KALYAN EDUCATIONAL INSTITUTE OF TECHNOLOGY</strong> is an Autonomous Institute in India, established under the Indian Trust Act No. 2 of 1882.
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Dedicated to creating a skilled and professional workforce in India.</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Provides students with opportunities to gain practical and professional skills.</li>
                        </ul>
                    </div>


                </div>

            </div>
        </section>
        <!--  end about section-->

        <!-- facalities section start--->


        <section id="facilities" class="facilities section py-5" style="background: #E9EAF5;">
            <div class="container" data-aos="fade-up">

                <!-- Section Heading -->
                <div class="text-center mb-5">
                    <h2 class="fw-bold" style="color:#37423B;">Facilities</h2>
                    <p class="text-muted fs-5">Our Facilities</p>
                    <div class="mx-auto" style="width: 80px; height: 3px; background: #023E8A; border-radius: 5px;"></div>
                </div>

                <!-- Facilities Grid -->
                <div class="row g-4">

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                        <div class="card h-100 text-center p-4 border-0 shadow-sm facility-card">
                            <i class="bi bi-clock-history fs-1 mb-3"></i>
                            <h5 class="fw-bold">Time Flexibilities</h5>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card h-100 text-center p-4 border-0 shadow-sm facility-card">
                            <i class="bi bi-people fs-1 mb-3"></i>
                            <h5 class="fw-bold">Batch Flexibilities</h5>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card h-100 text-center p-4 border-0 shadow-sm facility-card">
                            <i class="bi bi-currency-rupee fs-1 mb-3"></i>
                            <h5 class="fw-bold">Low Fee Structure</h5>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                        <div class="card h-100 text-center p-4 border-0 shadow-sm facility-card">
                            <i class="bi bi-briefcase fs-1 mb-3"></i>
                            <h5 class="fw-bold">Job Assistance</h5>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="500">
                        <div class="card h-100 text-center p-4 border-0 shadow-sm facility-card">
                            <i class="bi bi-patch-check fs-1 mb-3"></i>
                            <h5 class="fw-bold">Verifiable Certifications</h5>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="600">
                        <div class="card h-100 text-center p-4 border-0 shadow-sm facility-card">
                            <i class="bi bi-book fs-1 mb-3"></i>
                            <h5 class="fw-bold">Course Materials</h5>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="700">
                        <div class="card h-100 text-center p-4 border-0 shadow-sm facility-card">
                            <i class="bi bi-gear fs-1 mb-3"></i>
                            <h5 class="fw-bold">Theory To Practical</h5>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="800">
                        <div class="card h-100 text-center p-4 border-0 shadow-sm facility-card">
                            <i class="bi bi-question-circle fs-1 mb-3"></i>
                            <h5 class="fw-bold">Doubt Clearing Session</h5>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="900">
                        <div class="card h-100 text-center p-4 border-0 shadow-sm facility-card">
                            <i class="bi bi-activity fs-1 mb-3"></i>
                            <h5 class="fw-bold">Curricular Activities</h5>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- facalities section end--->




        <!-- Counts Section -->
        <section id="counts" class="section counts py-5" style="background: #f9fafc;">
            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4 text-center">

                    <!-- Certified Students -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item p-4 rounded shadow-sm h-100">
                            <i class="bi bi-mortarboard-fill fs-1 text-primary mb-2"></i>
                            <span data-purecounter-start="0" data-purecounter-end="1754" data-purecounter-duration="2" class="purecounter fw-bold fs-2 d-block"></span>
                            <p class="fw-semibold text-dark">Certified Students</p>
                        </div>
                    </div>

                    <!-- Placed Student -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item p-4 rounded shadow-sm h-100">
                            <i class="bi bi-briefcase-fill fs-1 text-success mb-2"></i>
                            <span data-purecounter-start="0" data-purecounter-end="675" data-purecounter-duration="2" class="purecounter fw-bold fs-2 d-block"></span>
                            <p class="fw-semibold text-dark">Placed Students</p>
                        </div>
                    </div>

                    <!-- Experience Trainers -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item p-4 rounded shadow-sm h-100">
                            <i class="bi bi-person-badge-fill fs-1 text-warning mb-2"></i>
                            <span data-purecounter-start="0" data-purecounter-end="6" data-purecounter-duration="2" class="purecounter fw-bold fs-2 d-block"></span>
                            <p class="fw-semibold text-dark">Experience Trainers</p>
                        </div>
                    </div>

                    <!-- Year of Experience -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item p-4 rounded shadow-sm h-100">
                            <i class="bi bi-calendar-check-fill fs-1 text-danger mb-2"></i>
                            <span data-purecounter-start="0" data-purecounter-end="6" data-purecounter-duration="2" class="purecounter fw-bold fs-2 d-block"></span>
                            <p class="fw-semibold text-dark">Years of Experience</p>
                        </div>
                    </div>

                </div>

            </div>
        </section>



        <!-- end Counts Section -->


        <!-- Courses Section -->
        <section id="courses" class="courses section" style="background: #E9EAF5;">
            <div class="container" data-aos="fade-up" >

                <!-- Section Title -->
                <div class="section-title text-center mb-5">
                    <h1 class="fw-semibold text-uppercase" style="color:#37423B; font-size: 20px;">Popular Courses</h1>
                    <p class="text-muted" style="font-size: 16px;">
                        Learn professional computer courses from basic to advanced level with placement assistance
                    </p>
                </div>

                <!-- Swiper Slider -->
                <div class="swiper courses-slider"  >
                    <div class="swiper-wrapper">

                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="swiper-slide">
                                    <div class="course-card shadow rounded overflow-hidden text-center p-4">
                                        <img src="admin/uploads/<?php echo htmlspecialchars($row['image']); ?>"
                                            class="card-img-top"
                                            alt="<?php echo htmlspecialchars($row['course_name']); ?>">
                                        <h4 class="fw-bold"><?php echo htmlspecialchars($row['course_name']); ?></h4>
                                        <p class="text-muted"><?php echo htmlspecialchars($row['subject']); ?></p>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="swiper-slide">
                                <div class="course-card shadow rounded overflow-hidden text-center p-4">
                                    <h4 class="fw-bold text-danger">No Courses Found</h4>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- Slider Controls -->
                    <div class="swiper-pagination mt-4"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </section>

        <!-- ======= Partner Logos Section ======= -->
        <!-- ======= Partner Logos Section ======= -->
        <section id="partners" class="partners section py-5 bg-white" data-aos="fade-up">
            <div class="container text-center">

                <div class="section-title mb-5" style="border: none !important; margin-bottom: 0 !important;">
                    <h2 class="fw-semibold text-uppercase"
                        style="color:#37423B; font-size: 20px; border-bottom: none !important; margin-bottom: 0 !important;">
                        Our Affiliation / Partners
                    </h2>
                </div>


                <!-- Swiper Container -->
                <div class="swiper partners-swiper">
                    <div class="swiper-wrapper"  style="height: 80px;" >
                        <?php
                        $logo_sql = "SELECT * FROM logo ORDER BY id ASC";
                        $logo_result = $conn->query($logo_sql);

                        if ($logo_result && $logo_result->num_rows > 0) {
                            while ($row = $logo_result->fetch_assoc()) {
                                echo '<div class="swiper-slide">';
                                echo "<img src='admin/uploads/" . htmlspecialchars($row['image']) . "' alt='Logo'>";
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="swiper-slide"><p class="text-danger">No logos found.</p></div>';
                        }
                        ?>
                    </div>
                </div>

            </div>
        </section>

    </main>

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
                                <i class="bi bi-globe me-2"></i> Jkeit.in
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

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".courses-slider", {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1200: {
                    slidesPerView: 3
                }
            }
        });
    </script>
    <script>
        var partnerSwiper = new Swiper(".partners-swiper", {
            slidesPerView: 5,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false
            },
            breakpoints: {
                320: {
                    slidesPerView: 2
                },
                576: {
                    slidesPerView: 3
                },
                768: {
                    slidesPerView: 4
                },
                992: {
                    slidesPerView: 5
                },
                1200: {
                    slidesPerView: 6
                }
            }
        });
    </script>



    <script>
        var heroSwiper = new Swiper(".swiper-sliders", {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            }
        });
    </script>




</body>

</html>