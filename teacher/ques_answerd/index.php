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
$query_question_answer = "SELECT question_answer.id , questions.question , answers.answer FROM questions, answers , question_answer WHERE
questions.id = question_answer.question AND answers.id = question_answer.answer";
$colname_question_answer = "-1";
if (isset($_GET['question'])) {
  $colname_question_answer = $_GET['question'];
  $query_question_answer = sprintf("SELECT question_answer.id , questions.question , answers.answer FROM questions, answers , question_answer WHERE
  questions.id = question_answer.question AND answers.id = question_answer.answer AND  question_answer.question = %s", GetSQLValueString($colname_question_answer, "int"));
}
$question_answer = mysql_query($query_question_answer, $conn) or die(mysql_error());
$row_question_answer = mysql_fetch_assoc($question_answer);
$totalRows_question_answer = mysql_num_rows($question_answer);

mysql_select_db($database_conn, $conn);
$query_question = "SELECT * FROM questions";
$question = mysql_query($query_question, $conn) or die(mysql_error());
$row_question = mysql_fetch_assoc($question);
$totalRows_question = mysql_num_rows($question);

mysql_select_db($database_conn, $conn);
$query_answer = "SELECT * FROM answers";
$answer = mysql_query($query_answer, $conn) or die(mysql_error());
$row_answer = mysql_fetch_assoc($answer);
$totalRows_answer = mysql_num_rows($answer);

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
    <th>question</th>
    <th>answer</th>
    <th class="d-print-none">actions</th>
  </tr>
  <?php do { ?>
    <tr>
      <th><?php echo $row_question_answer['id']; ?></th>
      <td><?php echo $row_question_answer['question']; ?></td>
      <td><?php echo $row_question_answer['answer']; ?></td>
      <td class="d-print-none"><a href="edit.php?id=<?php echo $row_question_answer['id']; ?>"><i class="fas fa-edit text-success"></i></a> |
        <a href="delete.php?id=<?php echo $row_question_answer['id']; ?>" onclick="return confirm('هل تريد الحذف')"><i class="fas fa-trash-alt text-danger"></i></a>
      </td>
    </tr>
    <?php } while ($row_question_answer = mysql_fetch_assoc($question_answer)); ?>
</table>


<?php


include '../include/footer.php';
mysql_free_result($question_answer);

mysql_free_result($question);

mysql_free_result($answer);
?>