<?php
if (!isset($_SESSION['user'])) {
  header('Location: ../');
}

if ($_SESSION['user']['type'] != 'admin') {
  header('Location: /school');
}

function page()
{
  return str_replace(['/school/admin/', '/index.php'], '', $_SERVER['PHP_SELF']);
}
?>

<ul class="nav nav-pills justify-content-center bg-dark p-4 d-print-none m-0">
  <li class="nav-item">
    <a class="nav-link link-light <?php
                                  if (page() == 'users') {
                                    echo 'active';
                                  }
                                  ?>" href="../users/">المستخدمين</a>
  </li>
  <li class="nav-item">
    <a class="nav-link link-light <?php if (page() == 'teachers') {
                                    echo 'active';
                                  } ?>" href="../teachers">الأساتذة</a>
  </li>
  <li class="nav-item">
    <a class="nav-link link-light <?php if (page() == 'students') {
                                    echo 'active';
                                  } ?>" href="../students/">الطلبة</a>
  </li>

  <li class="nav-item">
    <a class="nav-link link-light <?php if (page() == 'lib') {
                                    echo 'active';
                                  } ?>" href="../lib">المكتية</a>
  </li>
  <li class="nav-item">
    <a class="nav-link link-light <?php if (page() == 'classes') {
                                    echo 'active';
                                  } ?>" href="../classes">الفصول</a>
  </li>
  <li class="nav-item">
    <a class="nav-link link-light <?php if (page() == 'subjects') {
                                    echo 'active';
                                  } ?>" href="../subjects">المواد</a>
  </li>

  <li class="nav-item">
    <a class="nav-link link-light <?php if (page() == 'schedule') {
                                    echo 'active';
                                  } ?>" href="../schedule">الجداول</a>
  </li>

</ul>