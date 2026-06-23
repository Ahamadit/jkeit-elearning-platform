<?php
include __DIR__ . '/admin/../database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>JKEIT</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/logo/logo1.jpeg" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
    /* Make course images neat & same size */
    .card img {
      object-fit: cover;
      width: 100%;
      height: 100%;
      transition: transform 0.3s ease-in-out;
    }

    /* Hover effect */
    .card:hover img {
      transform: scale(1.05);
    }

    .card:hover {
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      transform: translateY(-5px);
      transition: 0.3s;
    }

    /* Limit subject text to 3 lines */
    .card-text {
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
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

  <!-- Top Header Section -->
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
            <li><a href="index.php">Course</a></li>
          </ul>

          <!-- Mobile Toggle -->
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

      </div>
    </header>
  </div>



  <!-- Main Courses Section -->
  <main class="main py-5 bg-light">
    <div class="container">
      <header class="mb-5 text-center">
        <h1 class="fw-bold text-dark">Our Courses</h1>
        <p class="text-muted fs-5">Choose your course and start learning today.</p>
      </header>

      <div class="row g-4">
        <?php
        $sql = "SELECT * FROM add_course ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <div class="col-md-6 col-lg-4">
              <div class="card h-100 shadow-lg border-0 rounded-3 overflow-hidden">
                <!-- Image -->
                <div class="ratio ratio-16x9">
                  <img src="admin/uploads/<?php echo htmlspecialchars($row['image']); ?>"
                    class="card-img-top"
                    alt="<?php echo htmlspecialchars($row['course_name']); ?>">
                </div>

                <div class="card-body d-flex flex-column">
                  <!-- Title -->
                  <h5 class="card-title fw-bold text-primary">
                    <?php echo htmlspecialchars($row['course_name']); ?>
                  </h5>

                  <!-- Subject -->
                  <p class="card-text text-muted flex-grow-1">
                    <?php echo htmlspecialchars($row['subject']); ?>
                  </p>

                  <!-- Price & Button -->
                  <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="fw-bold text-success fs-5">₹<?php echo htmlspecialchars($row['price']); ?></span>
                    <a href="login.php?course_id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm px-3 rounded-pill">
                      <i class="bi bi-cart-check"></i> Buy Now
                    </a>

                  </div>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<p class='text-center text-muted'>No courses available yet.</p>";
        }
        ?>
      </div>
    </div>
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

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>