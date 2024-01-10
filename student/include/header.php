<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> School SYStem </title>
  <link rel="icon" href="../../assets/img/logo.jpg" type="image/x-icon">
  <link rel="stylesheet" href="../../assets/style.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="../../assets/fonts/fontawesome/css/all.css">

  <style>
    body {
      background-color: #f8f8f8e2;
    }

    .active {
      font-weight: bold !important;
      color: #000 !important;
      background-color: #f8f8f8e2 !important;
      border-color: #f8f8f8e2 !important;
    }

    div.card-report {
      margin: auto;
      margin-left: 50px;
      width: 400px;
      height: 100px;
      font-size: 18px;
    }
  </style>
</head>

<body>

  <?php
  include 'navbar.php';
  ?>
  
<div class="row" style="height: 520px;">

    <div class="col-md-3 d-print-none">
      <!-- Sidebar -->
      <nav class="p-0 m-0 border-secondary border-end h-100 w-100 <?php
                                                                  if (page() == 'reports') {
                                                                    echo 'd-none';
                                                                  } ?>">
        <div class="border-bottom p-3 fs-4" style="background-color:#f8f8f8e2;">
        <?php
          if (isset($_SESSION['user']))
            echo $_SESSION['user']['full_name'];
          ?>
          <a href="/school/login.php"><i class="fas fa-door-open float-end text-danger"></i></a>
        </div>
        <div class="card-body">
          هناك قائمة من مستخدمي النظام والتطبيقات الخاصة التي يتم إنشاؤها عند توفير النظام. يتم إنشاء مستخدمي النظام الخاص لسيناريوهات التكامل والدعم. يتم إنشاء مستخدمي التطبيق أثناء توفير النظام لإدارة الإعداد والتكوين.
        </div>
      </nav>

    </div>
    <div class="<?php
                if (page() != 'reports') {
                  echo 'col-md-9 pt-2 ';
                } else {
                  echo 'col-12 pt-2';
                }
                ?>">