<?php
if (!isset($_SESSION['user'])) {
  header('Location: ../');
}

if ($_SESSION['user']['type'] != 'admin' and $_SESSION['user']['type'] != 'student') {
  header('Location: /school');
}


function page()
{
  return str_replace(['/school/student/', '/index.php'], '', $_SERVER['PHP_SELF']);
}
?>


<ul class="nav nav-pills justify-content-center bg-dark p-4 d-print-none m-0">  
   
    <li class="nav-item">
      <a class="nav-link link-light <?php if (page() == 'books') {
                                      echo 'active';
                                    } ?>" href="../books/">المكتبة</a>
    </li>
   
    <li class="nav-item">
      <a class="nav-link link-light <?php if (page() == 'schedule') {
                                      echo 'active';
                                    } ?>" href="../schedule/">الجداول</a>
    </li>

    <li class="nav-item">
      <a class="nav-link link-light <?php if (page() == 'exam') {
                                      echo 'active';
                                    } ?>" href="../exam/">الأمتحان</a>
    </li>
   
    <li class="nav-item">
      <a class="nav-link link-light <?php if (page() == 'result') {
                                      echo 'active';
                                    } ?>" href="../result/">النتيجة</a>
    </li>


  </ul>

