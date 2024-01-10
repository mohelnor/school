<?php
if (!isset($_SESSION['user'])) {
    header('Location: ../');
}

if ($_SESSION['user']['type'] != 'admin' and $_SESSION['user']['type'] != 'teacher') {
    header('Location: /school');
}

function page()
{
    return str_replace(['/school/teacher/', '/index.php'], '', $_SERVER['PHP_SELF']);
}
?>


<ul class="nav nav-pills justify-content-center bg-dark p-4 d-print-none m-0">

    <li class="nav-item">
      <a class="nav-link link-light <?php if (page() == 'exams') {
    echo 'active';
}?>" href="../exams/">الأمتحانات</a>
    </li>

  <li class="nav-item">
    <a class="nav-link link-light <?php if (page() == 'questions') {
    echo 'active';
}?>" href="../questions/">الأسئلة</a>
  </li>

    <li class="nav-item">
      <a class="nav-link link-light <?php if (page() == 'answers') {
    echo 'active';
}?>" href="../answers/">الأجوبة</a>
    </li>

    <li class="nav-item">
      <a class="nav-link link-light <?php if (page() == 'ques_answerd') {
    echo 'active';
}?>" href="../ques_answerd/"> اجوبة الأسئلة</a>
    </li>



  </ul>

