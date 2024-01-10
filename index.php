<?php
session_start();
// remove all session variables
session_unset();
// destroy the session
session_destroy();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> خدمات للسفر و السياحة </title>
  <link rel="stylesheet" href="assets/style.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.css">
  <meta name="theme-color" content="#7952b3">
  <style>
    .navbar {
      font-weight: bold !important;
    }

    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    .sticky-top {
      position: sticky;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    /* Carousel base class */
    .carousel {
      margin-bottom: 4rem;
    }

    /* Since positioning the image, we need to help out the caption */
    .carousel-caption {
      bottom: 3rem;
      z-index: 10;
    }

    /* Declare heights because of positioning of img element */
    .carousel-item {
      height: 32rem;
    }

    .carousel-item>img {
      position: absolute;
      top: 0;
      right: 0;
      min-width: 100%;
      height: 32rem;
    }

    /* Center align the text within the three columns below the carousel */
    .marketing .col-lg-4 {
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .marketing h2 {
      font-weight: 400;
    }

    .marketing .col-lg-4 p {
      margin-right: .75rem;
      margin-left: .75rem;
    }

    @media (min-width: 40em) {

      /* Bump up size of carousel content */
      .carousel-caption p {
        margin-bottom: 1.25rem;
        font-size: 1.25rem;
        line-height: 1.4;
      }

    }
  </style>
</head>

<body>

  <header>
    <nav class="navbar navbar-expand-md navbar-dark p-4" style="  background-color: #ec920a;">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">الصفحة الرئيسية</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="تبديل التنقل">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav m-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link" href="#intro">عن المدرسة</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#rooms">المرافق</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contact">التواصل</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php"> تسجيل الدخول </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main class="container-fluid m-0 p-0">

    <!-- Intro -->
    <div id="intro" class="container-fluid vh-25 p-5" style="background-color: #fff9ece2; height:250px; font-size:18px;">
      <h1 style="font-weight:bolder;">
        المدرسة
      </h1>
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, dolorem eligendi. Ratione, fugiat corporis soluta tempore natus fuga itaque ea voluptas nulla veritatis hic, voluptatum illo aperiam nam, exercitationem accusantium.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad alias veritatis debitis eaque aspernatur quibusdam veniam est hic nobis. Ullam nostrum, aliquid culpa nulla adipisci itaque ducimus eligendi. Iste, officia.
      </p>

    </div>

    <!-- carousel -->
    <div id="carouselExampleControls" class="carousel slide m-0" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="assets/images/1.jpg" class="d-block w-100" alt="assets/images/1321255364936243.jpg">
        </div>
        <div class="carousel-item">
          <img src="assets/images/2.jpg" class="d-block w-100" alt="assets/images/1321255364936243.jpg">
        </div>
        <div class="carousel-item">
          <img src="assets/images/3.jpg" class="d-block w-100" alt="assets/images/1321255364936243.jpg">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!-- Rooms & facilities -->
    <div id="rooms" class="container-fluid p-3 vh-25" style="background-color: #fff9ece2; font-size:18px;">
      <h1 class="row col-12 p-3" style="font-weight:bolder;">
        المرافق
      </h1>

      <div class="row g-4 text-center">
        <div class="col-md-4">
          <img src="assets/images/1.jpg" class="img-fluid rounded shadow w-75">
          <h3 class="p-2">المرافق</h3>
        </div>
        <div class="col-md-4">
          <img src="assets/images/1.jpg" class="img-fluid rounded shadow w-75">
          <h3 class="p-2">المرافق</h3>
        </div>
        <div class="col-md-4">
          <img src="assets/images/1.jpg" class="img-fluid rounded shadow w-75">
          <h3 class="p-2">المرافق</h3>
        </div>

      </div>

    </div>

  </main>
  <!-- Footer -->
  <footer id="contact" class="container-fluid text-center text-lg-start bg-dark mt-2 text-white p-5">
    <div class="row">
      <div class="col-md-4 mx-auto mb-4">
        <h6 class="text-uppercase fw-bold mb-4">
          مدرســـة حافـظ أميـن
        </h6>
        <p>
          تربيـة - تنشئة - دعم للمخيلة
        </p>
        <p>
          نمهـد الطريق نحو الريـادة.
        </p>
      </div>

      <div class="col-md-4 mx-auto mb-md-0 mb-4">
        <h6 class="text-uppercase fw-bold mb-4">
          التواصل
        </h6>
        <p><i class="fas fa-home me-3"></i>الســوق الشعبي - جوار صالة ريم الذهبية</p>

        <p><i class="fas fa-phone me-3"></i> + 249 123 456 789</p>
        <p><i class="fas fa-print me-3"></i> + 249 000 000 123</p>
      </div>

      <div class="col-md-4 mx-auto mb-4">

        <h6 class="text-uppercase fw-bold mb-4">
          <i class="fas fa-gem me-3"></i>
          مدرســـة حافـظ أميـن - الرئيسية
        </h6>
        <p>
          <a class="btn text-white" href="#">الأعلى</a>
        </p>
      </div>
    </div>
    <!-- Copyright -->
    <div class="text-center mt-2 p-2">

      <p> حافظ أمين &copy; 2012-2021</p>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->

  <script src="assets/jquery/jquery-3.5.1.slim.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>