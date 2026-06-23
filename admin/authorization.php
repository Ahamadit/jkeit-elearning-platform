<?php
// Include database connection
include __DIR__ . '/../database.php'; // adjust path if needed

// Fetch all vision records
$query = "SELECT * FROM authorization ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>JKEIT Admin - Authorization</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Stronger rule for vision images (set to 100px width) */
        .card .table img,
        .table-responsive .table img,
        table.table img {
            width: 100px !important;
            max-width: none !important;
            height: auto !important;
            border-radius: 8px !important;
            object-fit: cover !important;
        }

        /* Table cells */
        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        /* Sidebar adjustments */
        .sidebar {
            transition: all 0.3s ease-in-out;
        }

        .sidebar.sidebar-collapsed {
            width: 70px;
        }

        .sidebar.sidebar-collapsed .menu-title {
            display: none;
        }

        .sidebar .sub-menu,
        .sidebar .sub-menu li {
            list-style: none !important;
            padding-left: 0 !important;
        }

        .sidebar .sub-menu {
            padding-left: 10px !important;
        }

        .sidebar .sub-menu .nav-link {
            padding-left: 10px !important;
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
                            <li class="nav-item">
                                <a class="nav-link" href="vision.php" style="padding-left:0; display:flex; align-items:center; text-decoration:none;">
                                    <i class="mdi mdi-eye-outline menu-icon" style="margin-right:5px;"></i> Vision & Mission
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="jkieteam.php" style="padding-left:0; display:flex; align-items:center; text-decoration:none;">
                                    <i class="mdi mdi-account-group-outline menu-icon" style="margin-right:5px;"></i> Our Team JKEIT
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="governing.php" style="padding-left:0; display:flex; align-items:center; text-decoration:none;">
                                    <i class="mdi mdi-gavel menu-icon" style="margin-right:5px;"></i> Governing Council - JKEIT
                                </a>
                            </li>
                            <li class="nav-item">
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

        <!-- Main content -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- Page Header -->
                    <div class="page-header flex-wrap mb-3">
                        <div class="d-flex">
                            <a href="add_authorization.php" class="btn btn-success"><i class="mdi mdi-plus"></i> Add Authorization</a>
                        </div>
                    </div>

                    <!-- Vision Table -->
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">All Authorization</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>SR NO</th>
                                                    <th>Image</th>
                                                    <th>Heading</th>
                                                    <th>Paragraph</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sr = 1;
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $imageFile = trim($row['image']);
                                                        $imagePath = "uploads/authorization/" . $imageFile;

                                                        if (!empty($imageFile) && file_exists(__DIR__ . "/uploads/authorization/" . $imageFile)) {
                                                            // inline style with 100px width
                                                            $imgTag = "<img src='{$imagePath}' alt='Vision Image' style='width:100px !important; max-width:none !important; height:auto !important; object-fit:cover; border-radius:8px !important;'>";
                                                        } else {
                                                            $imgTag = "<span style='color:red;'>Image not found</span>";
                                                        }

                                                        echo "<tr>
                                                                <td>{$sr}</td>
                                                                <td>{$imgTag}</td>
                                                                <td>{$row['heading']}</td>
                                                                <td style='word-wrap: break-word; white-space: normal; max-width: 250px;'>{$row['paragraph']}</td>
                                                                <td>
                                                                    <a href='edit_authorization.php?id={$row['id']}' class='btn btn-primary'><i class='mdi mdi-pencil'></i></a>
                                                                    <a href='#' class='btn btn-danger delete-btn' data-id='{$row['id']}'><i class='mdi mdi-delete'></i></a>
                                                                </td>
                                                              </tr>";
                                                        $sr++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='5'>No records found.</td></tr>";
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

    <!-- JS Files -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Attach event listeners AFTER DOM is fully loaded
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');

                    // Show confirmation alert
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This authorization entry will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to delete PHP
                            window.location.href = "delete_authorization.php?id=" + id;
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>