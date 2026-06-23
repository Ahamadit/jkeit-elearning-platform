<?php
session_start();
include __DIR__ . '/../database.php';

// Fetch all posters newest first
$result = $conn->query("SELECT * FROM poster ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>JKEIT Admin - Courses</title>
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <style>
        .table thead th {
            background-color: #f5f5f5;
            font-weight: 600;
            text-align: center;
        }

        .table tbody td {
            vertical-align: middle;
            text-align: center;
            word-wrap: break-word;
            white-space: normal;
            max-width: 250px;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 768px) {
            .table thead {
                display: none;
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 1rem;
                border-bottom: 2px solid #ddd;
            }

            .table td {
                text-align: left;
                padding-left: 45%;
                position: relative;
                white-space: normal !important;
            }

            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 40%;
                font-weight: 600;
                text-align: left;
                color: #333;
                white-space: normal;
            }
        }

        /* Sidebar toggle fix */
        .sidebar {
            transition: all 0.3s ease-in-out;
        }

        .sidebar.sidebar-collapsed {
            width: 70px;
        }

        .sidebar.sidebar-collapsed .menu-title {
            display: none;
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

                <li class="nav-item">
                    <a class="nav-link" href="student-login.php">
                        <i class="mdi mdi-contacts menu-icon"></i>
                        <span class="menu-title">Student Login</span>
                    </a>
                </li>

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

                <li class="nav-item">
                    <a class="nav-link" href="franchise.php">
                        <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                        <span class="menu-title">Franchise</span>
                    </a>
                </li>
                <!-- Franchise student deatils -->
                <li class="nav-item">
                    <a class="nav-link" href="franchisee_student.php">
                        <i class="mdi mdi-account-group menu-icon"></i>
                        <span class="menu-title">Franchisee-students</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="study_material.php">
                        <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                        <span class="menu-title">Study Material</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="syllabus.php">
                        <i class="mdi mdi-file-document-outline menu-icon"></i>
                        <span class="menu-title">Syllabus</span>
                    </a>
                </li>

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
                <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="dashboard.php">
                    <img src="assets/images/logo-mini.svg" alt="logo" />
                </a>

                <!-- Sidebar Toggle Button -->
                <button class="navbar-toggler navbar-toggler align-self-center mr-2" id="sidebarToggle">
                    <i class="mdi mdi-menu"></i>
                </button>

                <ul class="navbar-nav navbar-nav-right ml-lg-auto">
                    <li class="nav-item nav-profile dropdown border-0">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown">
                            <img class="nav-profile-img mr-2" alt="" src="assets/logo/jkietlogo.jpeg" />
                            <span class="profile-name">JKEIT</span>
                        </a>
                        <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="#"><i class="mdi mdi-logout mr-2 text-primary"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header flex-wrap">
                        <div class="d-flex">
                            <a href="add_poster.php" class="btn btn-sm btn-success ml-3"><i class="mdi mdi-plus"></i> Add Poster Image</a>
                        </div>
                    </div>

                    <!-- Notifications Table -->
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">All Poster Image</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>SR NO</th>
                                                    <th>Image</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                           <tbody>
<?php
$result = $conn->query("SELECT * FROM poster ORDER BY id DESC"); // newest first
if ($result->num_rows > 0) {
    $sr = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td data-label='SR NO'>{$sr}</td>
            <td data-label='Image'>
                <img src='uploads/{$row['image']}' alt='Poster' style='height:80px; width:auto; border-radius:5px;' />
            </td>
            <td data-label='Actions'>
                <div class='d-flex justify-content-center gap-1'>
                    <a href='edit_poster.php?id={$row['id']}' class='btn btn-sm btn-primary'>
                        <i class='mdi mdi-pencil'></i>
                    </a>   
                    <a href='delete_poster.php?id={$row['id']}' class='btn btn-sm btn-danger delete-btn' data-id='{$row['id']}'>
                        <i class='mdi mdi-delete'></i>
                    </a>
                </div>
            </td>
        </tr>";
        $sr++;
    }
} else {
    echo "<tr><td colspan='3' class='text-center text-muted'>No posters found</td></tr>";
}
?>
</tbody>



                                        </table>

                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault(); // Stop default link behavior
                    const id = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This Poster will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `delete_poster.php?id=${id}`;
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>