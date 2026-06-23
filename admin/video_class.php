<?php
include __DIR__ . '/../database.php'; // adjust path if needed
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>JKEIT Admin - video class</title>
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

        .table img {
            border-radius: 8px;
            max-width: 60px;
            height: auto;
        }

        .btn i {
            vertical-align: middle;
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
                        <h3 class="mb-0">All Video class </h3>
                    </div>

                    <!-- Courses Table -->
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card shadow-sm">
                                <div class="card-body">

                                    <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>SR No</th>
                                                    <th>Subject Name</th>
                                                    <th>Video Link</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                          <tbody>
<?php
$sql = "SELECT * FROM add_subject ORDER BY id DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $sr = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td data-label='SR No'>" . $sr++ . "</td>";
        echo "<td data-label='Subject Name'>" . htmlspecialchars($row['subject_name']) . "</td>";

        // Fetch videos for this subject
        $video_sql = "SELECT id, video_link FROM video_class WHERE subject_name='" . $conn->real_escape_string($row['subject_name']) . "'";
        $video_result = $conn->query($video_sql);

        if ($video_result && $video_result->num_rows > 0) {
            echo "<td data-label='Video Link'>";
            $first_video_id = null;
            while ($video_row = $video_result->fetch_assoc()) {
                if (!$first_video_id) $first_video_id = $video_row['id'];
                echo "<a href='" . htmlspecialchars($video_row['video_link']) . "' target='_blank' class='btn btn-sm btn-info mb-1'>
                        <i class='fa fa-youtube-play'></i> View
                      </a><br>";
            }
            echo "</td>";

            echo "<td data-label='Action'>
                    <a href='add_video_class.php?id=" . $row['id'] . "' class='btn btn-sm btn-success' title='Add Video'><i class='fa fa-plus'></i></a>
                    <a href='edit_video_class.php?id=" . $first_video_id . "' class='btn btn-sm btn-primary' title='Edit Video'><i class='fa fa-edit'></i></a>
                    <a href='delete_video_class.php?id=" . $first_video_id . "' class='btn btn-sm btn-danger delete-btn' title='Delete Video'
                       onclick=\"return confirm('Are you sure you want to delete this video?');\"><i class='fa fa-trash'></i></a>
                  </td>";
        } else {
            echo "<td data-label='Video Link'><span class='text-muted'>No Video</span></td>";
            echo "<td data-label='Action'>
                    <a href='add_video_class.php?id=" . $row['id'] . "' class='btn btn-sm btn-success' title='Add Video'><i class='fa fa-plus'></i></a>
                    <span class='btn btn-sm btn-primary disabled' title='No Video to edit'><i class='fa fa-edit'></i></span>
                  </td>";
        }

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4' class='text-center text-muted'>No subjects found</td></tr>";
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
    <!-- SweetAlert2 for delete confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('sidebar-collapsed');
        });

        // SweetAlert delete confirmation
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This course will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });
        });
    </script>
</body>

</html>