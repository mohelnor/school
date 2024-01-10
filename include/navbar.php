<?php
// if (!isset($_SESSION['user'])) {
//   header('Location: ../');
// }

// if ($_SESSION['user']['type'] != 1 and $_SESSION['user']['type'] != 2) {
//   header('Location: /school');
// }

function page()
{
  return str_replace(['/school/admin/', '/index.php'], '', $_SERVER['PHP_SELF']);
}
?>


<ul class="nav nav-pills justify-content-center bg-dark p-4 d-print-none m-0">
    <li class="nav-item">
      <a class="nav-link link-light <?php if (page() == 'stations') {
                                      echo 'active';
                                    } ?>" href="#">الأساتذة</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-light <?php if (page() == 'stations') {
                                      echo 'active';
                                    } ?>" href="#">الطلبة</a>
    </li>
  
    <li class="nav-item">
      <a class="nav-link link-light <?php if (page() == 'stations') {
                                      echo 'active';
                                    } ?>" href="#">المكتية</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-light <?php if (page() == 'stations') {
                                      echo 'active';
                                    } ?>" href="#">الفصول</a>
    </li>
  
    <li class="nav-item">
      <a class="nav-link link-light <?php if (page() == 'stations') {
                                      echo 'active';
                                    } ?>" href="#">الجداول</a>
    </li>
  
    <li class="nav-item">
      <a class="nav-link link-light <?php
                                    // if (page() == 'users') {
                                    //   echo 'active';
                                    // }
                                    // if ($_SESSION['user']['type'] != 1) {
                                    //   echo ' disabled ';
                                    // }
                                    ?>" href="../users/">المستخدمين</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-light <?php
                                    // if (page() == 'reports') {
                                    //   echo 'active';
                                    // }
                                    // if ($_SESSION['user']['type'] != 1) {
                                    //   echo ' disabled ';
                                    // }
                                    ?>" href="../reports/">التقارير</a>
    </li>
  </ul>

