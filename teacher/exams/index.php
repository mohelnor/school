<?php require_once('../../Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_exams = "-1";
if (isset($_SESSION['user']['id'])) {
  $colname_exams = $_SESSION['user']['id'];
}

mysql_select_db($database_conn, $conn);
$query_exams = sprintf("SELECT exams.id, exams.created,exams.exam,subjects.subject,classes.class,exams.duration,exams.marks FROM subjects,classes,exams WHERE 
subjects.id = exams.subject AND classes.id = exams.class AND exams.teacher = %s", GetSQLValueString($colname_exams, "int"));
$exams = mysql_query($query_exams, $conn) or die(mysql_error());
$row_exams = mysql_fetch_assoc($exams);
$totalRows_exams = mysql_num_rows($exams);

mysql_select_db($database_conn, $conn);
$query_subjects = "SELECT * FROM subjects";
$subjects = mysql_query($query_subjects, $conn) or die(mysql_error());
$row_subjects = mysql_fetch_assoc($subjects);
$totalRows_subjects = mysql_num_rows($subjects);

include '../include/header.php';

?>
<h1>الإمتحانات</h1>
<div class="d-print-none p-2">
  <a href="add.php" class="btn btn-warning">إضافة</a>
  
  <button class="btn btn-dark float-end" onclick="print()">تقرير كامل <i class="fas fa-print"></i></button>
  <hr />
</div>

<table class="table table-responsive">
  <tr>
    <th>id</th>
    <th>exam</th>
    <th>subject</th>
    <th>class</th>
    <th>duration</th>
    <th>marks</th>
    <th>questions</th>
    <th>created</th>
    <th class="d-print-none">actions</th>
  </tr>
  <?php do { ?>
    <tr>
      <th><?php echo $row_exams['id']; ?></th>
      <td><?php echo $row_exams['exam']; ?></td>
      <td><?php echo $row_exams['subject']; ?></td>
      <td><?php echo $row_exams['class']; ?></td>
      <td><?php echo $row_exams['duration']; ?></td>
      <td><?php echo $row_exams['marks']; ?></td>
      <td><a href="../questions/?exam=<?php echo $row_exams['id']; ?>" class="btn btn-warning"> الأسئلة</a></td>
      <td><?php echo $row_exams['created']; ?></td>
      <td class="d-print-none"><a href="edit.php?id=<?php echo $row_exams['id']; ?>"><i class="fas fa-edit text-success"></i></a> |
        <a href="delete.php?id=<?php echo $row_exams['id']; ?>" onclick="return confirm('هل تريد الحذف')"><i class="fas fa-trash-alt text-danger"></i></a>
      </td>
    </tr>
    <?php } while ($row_exams = mysql_fetch_assoc($exams)); ?>
</table>
<?php

include '../include/footer.php';

mysql_free_result($exams);

mysql_free_result($subjects);

?>
