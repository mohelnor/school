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

mysql_select_db($database_conn, $conn);

$colname_questions = "-1";
$query_questions = "SELECT questions.id , questions.question , exams.exam , answers.answer , questions.degree , questions.teacher FROM questions , exams , answers WHERE
exams.id = questions.exam AND answers.id = questions.answer ";

if (isset($_GET['exam'])) {
  $colname_questions = $_GET['exam'];
  $query_questions = sprintf("SELECT questions.id , questions.question , exams.exam , answers.answer , questions.degree , questions.teacher FROM questions , exams , answers WHERE
  exams.id = questions.exam AND answers.id = questions.answer AND questions.exam = %s", GetSQLValueString($colname_questions, "int"));
}
$questions = mysql_query($query_questions, $conn) or die(mysql_error());
$row_questions = mysql_fetch_assoc($questions);
$totalRows_questions = mysql_num_rows($questions);

include '../include/header.php';

?>
<h1>الأسئلة</h1>
<div class="d-print-none p-2">
  <a href="add.php" class="btn btn-warning">إضافة</a>
  <button class="btn btn-dark float-end" onclick="print()">تقرير كامل <i class="fas fa-print"></i></button>
  <hr />
</div>

<table class="table table-responsive">
  <tr>
    <th>id</th>
    <th>question</th>
    <th>exam</th>
    <th>answer</th>
    <th>degree</th>
    <th class="d-print-none">actions</th>
  </tr>
  <?php do { ?>
    <tr>
      <th><?php echo $row_questions['id']; ?></th>
      <td><?php echo $row_questions['question']; ?></td>
      <td><?php echo $row_questions['exam']; ?></td>
      <td><?php echo $row_questions['answer']; ?></td>
      <td><?php echo $row_questions['degree']; ?></td>
      <td class="d-print-none"><a href="edit.php?id=<?php echo $row_questions['id'].'&exam='.$row_questions['exam']; ; ?>"><i class="fas fa-edit text-success"></i></a> |
        <a href="delete.php?id=<?php echo $row_questions['id']; ?>" onclick="return confirm('هل تريد الحذف')"><i class="fas fa-trash-alt text-danger"></i></a>
      </td>
    </tr>
    <?php } while ($row_questions = mysql_fetch_assoc($questions));
?>
</table>

<?php
include '../include/footer.php';
mysql_free_result($questions); 

?>