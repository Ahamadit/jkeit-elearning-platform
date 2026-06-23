<?php
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>JKEIT Admin</title>
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <style>
        /* Sidebar mobile toggle */
        @media (max-width: 991px) {
            .sidebar-offcanvas {
                position: fixed;
                left: -250px;
                top: 0;
                height: 100%;
                width: 250px;
                background: #2a3038;
                /* Match your theme */
                transition: left 0.3s ease-in-out;
                z-index: 1035;
                overflow-y: auto;
            }

            .sidebar-offcanvas.active {
                left: 0;
            }
        }

        /* Remove circles from sidebar submenu items */
        .sidebar .sub-menu,
        .sidebar .sub-menu li {
            list-style: none !important;
            padding-left: 0 !important;
        }

        /* Shift sidebar submenu a bit to the left */
        .sidebar .sub-menu {
            padding-left: 10px !important;
            /* adjust the value as needed */
        }

        .sidebar .sub-menu .nav-link {
            padding-left: 10px !important;
            /* adjust spacing between icon and text */
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- Sidebar -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-profile">
                    <a href="#" class="nav-link">
                        <div class="nav-profile-image">
                            <img src="assets/logo/jkietlogo.jpeg" alt="profile" />
                            <span class="login-status online"></span>
                        </div>
                        <div class="nav-profile-text d-flex flex-column pr-3">
                            <span class="font-weight-medium mb-2">JKEIT</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">
                        <i class="mdi mdi-home menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="course.php">
                        <i class="mdi mdi-school menu-icon"></i>
                        <span class="menu-title">Course</span>
                    </a>
                </li>

                <!-- Student Login -->
                <li class="nav-item">
                    <a class="nav-link" href="student-login.php">
                        <i class="mdi mdi-contacts menu-icon"></i>
                        <span class="menu-title">Student Login</span>
                    </a>
                </li>
                <!-- Add subject -->
                <li class="nav-item">
                    <a class="nav-link" href="subject.php">
                        <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                        <span class="menu-title">Add Subject</span>
                    </a>
                </li>


                <!-- Website Settings -->
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#websiteSettings" aria-expanded="false" aria-controls="websiteSettings">
                        <i class="mdi mdi-web menu-icon"></i>
                        <span class="menu-title">Website Settings</span>
                        <i class="menu-arrow mdi mdi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="websiteSettings">
                        <ul class="nav flex-column sub-menu" style="list-style:none !important; padding-left:0 !important; margin:0 !important;">
                            <li class="nav-item" style="list-style:none !important;">
                                <a class="nav-link" href="vision.php" style="padding-left:0; display:flex; align-items:center; text-decoration:none;">
                                    <i class="mdi mdi-eye-outline menu-icon" style="margin-right:5px;"></i> Vision & Mission
                                </a>
                            </li>
                            <li class="nav-item" style="list-style:none !important;">
                                <a class="nav-link" href="jkeit_team.php" style="padding-left:0; display:flex; align-items:center; text-decoration:none;">
                                    <i class="mdi mdi-account-group-outline menu-icon" style="margin-right:5px;"></i> Our Team JKEIT
                                </a>
                            </li>
                            <li class="nav-item" style="list-style:none !important;">
                                <a class="nav-link" href="governing.php" style="padding-left:0; display:flex; align-items:center; text-decoration:none;">
                                    <i class="mdi mdi-gavel menu-icon" style="margin-right:5px;"></i> Governing Council - JKEIT
                                </a>
                            </li>
                            <li class="nav-item" style="list-style:none !important;">
                                <a class="nav-link" href="authorization.php" style="padding-left:0; display:flex; align-items:center; text-decoration:none;">
                                    <i class="mdi mdi-shield-check-outline menu-icon" style="margin-right:5px;"></i> Authorization - JKEIT
                                </a>
                            </li>


                            <li class="nav-item" style="list-style:none !important;">
                                <a class="nav-link" href="partner.php" style="padding-left:0; display:flex; align-items:center; text-decoration:none;">
                                    <i class="mdi mdi-shield-check-outline menu-icon" style="margin-right:5px;"></i> Partner Logo
                                </a>
                            </li>

                            <li class="nav-item" style="list-style:none !important;">
                                <a class="nav-link" href="banner.php" style="padding-left:0; display:flex; align-items:center; text-decoration:none;">
                                    <i class="mdi mdi-image menu-icon" style="margin-right:5px;"></i> Banner
                                </a>
                            </li>
                            
                            <li class="nav-item" style="list-style:none !important;">
                                <a class="nav-link" href="prospects.php" style="padding-left:0; display:flex; align-items:center; text-decoration:none;">
                                    <i class="mdi mdi-file-document-outline menu-icon" style="margin-right:5px;"></i> Prospects
                                </a>
                            </li>

                            <li class="nav-item" style="list-style:none !important;">
                                <a class="nav-link" href="courses.php" style="padding-left:0; display:flex; align-items:center; text-decoration:none;">
                                    <i class="mdi mdi-school-outline menu-icon" style="margin-right:5px;"></i> Courses
                                </a>
                            </li>

                            <li class="nav-item" style="list-style:none !important;">
                                <a class="nav-link" href="poster.php" style="padding-left:0; display:flex; align-items:center; text-decoration:none;">
                                    <i class="mdi mdi-file-image-outline menu-icon" style="margin-right:5px;"></i> Poster
                                </a>
                            </li>


                        </ul>
                    </div>


                </li>

                <!-- Franchise -->
                <li class="nav-item">
                    <a class="nav-link" href="franchise.php">
                        <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                        <span class="menu-title">Franchisee</span>
                    </a>
                </li>
                <!-- Franchise student deatils -->
                <li class="nav-item">
                    <a class="nav-link" href="franchisee_student.php">
                        <i class="mdi mdi-account-group menu-icon"></i>
                        <span class="menu-title">Franchisee-students</span>
                    </a>
                </li>



                <!-- Study Material -->
                <li class="nav-item">
                    <a class="nav-link" href="study_material.php">
                        <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                        <span class="menu-title">Study Material</span>
                    </a>
                </li>

                <!-- Syllabus -->
                <li class="nav-item">
                    <a class="nav-link" href="syllabus.php">
                        <i class="mdi mdi-file-document-outline menu-icon"></i>
                        <span class="menu-title">Syllabus</span>
                    </a>
                </li>

                <!-- Video Class -->
                <li class="nav-item">
                    <a class="nav-link" href="video_class.php">
                        <i class="mdi mdi-video-outline menu-icon"></i>
                        <span class="menu-title">Video Class</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="exam.php">
                        <i class="mdi mdi-file-document-outline menu-icon"></i>
                        <span class="menu-title">Exam List</span>
                    </a>
                </li>

                <!-- Notification -->
                <li class="nav-item">
                    <a class="nav-link" href="notification.php">
                        <i class="mdi mdi-bell-outline menu-icon"></i>
                        <span class="menu-title">Notification</span>
                    </a>
                </li>

            </ul>
        </nav>

        <!-- Navbar -->
        <nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row">
            <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
                <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="dashboard.php"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
                <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="offcanvas">
                    <i class="mdi mdi-menu"></i>
                </button>
                <ul class="navbar-nav navbar-nav-right ml-lg-auto">
                    <li class="nav-item nav-profile dropdown border-0">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown">
                            <img class="nav-profile-img mr-2" alt="" src="assets/logo/jkietlogo.jpeg" />
                            <span class="profile-name">JKEIT</span>
                        </a>
                        <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="logout.php"><i class="mdi mdi-logout mr-2 text-primary"></i> Logout </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>

        <!-- Main content -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper pb-0">
                    <div class="page-header flex-wrap mt-5">
                        <h3 class="mb-0"> Hi, welcome back!
                            <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">Your dashboard overview.</span>
                        </h3>
                    </div>

                    <!-- Dashboard Cards -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6 stretch-card grid-margin pb-sm-3">
                            <div class="card bg-primary">
                                <div class="card-body px-3 py-4">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="color-card">
                                            <p class="mb-0 color-card-head">Total Courses</p>
                                            <h2 class="text-white">12</h2>
                                        </div>
                                        <i class="card-icon-indicator mdi mdi-book-open-page-variant bg-inverse-icon-primary"></i>
                                    </div>
                                    <h6 class="text-white">Updated Today</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 stretch-card grid-margin pb-sm-3">
                            <div class="card bg-success">
                                <div class="card-body px-3 py-4">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="color-card">
                                            <p class="mb-0 color-card-head">Student Logins</p>
                                            <h2 class="text-white">256</h2>
                                        </div>
                                        <i class="card-icon-indicator mdi mdi-account-multiple bg-inverse-icon-success"></i>
                                    </div>
                                    <h6 class="text-white">Active Today</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 stretch-card grid-margin pb-sm-3">
                            <div class="card bg-warning">
                                <div class="card-body px-3 py-4">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="color-card">
                                            <p class="mb-0 color-card-head">New Enrollments</p>
                                            <h2 class="text-white">34</h2>
                                        </div>
                                        <i class="card-icon-indicator mdi mdi-account-plus bg-inverse-icon-warning"></i>
                                    </div>
                                    <h6 class="text-white">Today</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 stretch-card grid-margin pb-sm-3">
                            <div class="card bg-danger">
                                <div class="card-body px-3 py-4">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="color-card">
                                            <p class="mb-0 color-card-head">Total Students</p>
                                            <h2 class="text-white">1200</h2>
                                        </div>
                                        <i class="card-icon-indicator mdi mdi-school bg-inverse-icon-danger"></i>
                                    </div>
                                    <h6 class="text-white">Updated Monthly</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © JKEIT 2025</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/chart.js/Chart.min.js"></script>

    <!-- Sidebar toggle script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const toggleBtns = document.querySelectorAll('[data-toggle="offcanvas"]');

            toggleBtns.forEach(btn => {
                btn.addEventListener("click", function() {
                    sidebar.classList.toggle("active");
                });
            });
        });
    </script>
</body>

</html>