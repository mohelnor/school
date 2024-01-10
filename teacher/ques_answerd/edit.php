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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE question_answer SET question=%s, answer=%s WHERE id=%s",
                       GetSQLValueString($_POST['question'], "int"),
                       GetSQLValueString($_POST['answer'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conn, $conn);
$query_answers = "SELECT * FROM answers";
$answers = mysql_query($query_answers, $conn) or die(mysql_error());
$row_answers = mysql_fetch_assoc($answers);
$totalRows_answers = mysql_num_rows($answers);

mysql_select_db($database_conn, $conn);
$query_questions ="SELECT * FROM questions";
$colname_questions = "-1";
if (isset($_GET['exam'])) {
  $colname_questions = $_GET['exam'];
  $query_questions = sprintf("SELECT * FROM questions WHERE exam = %s", GetSQLValueString($colname_questions, "int"));
}
$questions = mysql_query($query_questions, $conn) or die(mysql_error());
$row_questions = mysql_fetch_assoc($questions);
$totalRows_questions = mysql_num_rows($questions);

$colname_question_answer = "-1";
if (isset($_GET['id'])) {
  $colname_question_answer = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_question_answer = sprintf("SELECT * FROM question_answer WHERE id = %s", GetSQLValueString($colname_question_answer, "int"));
$question_answer = mysql_query($query_question_answer, $conn) or die(mysql_error());
$row_question_answer = mysql_fetch_assoc($question_answer);
$totalRows_question_answer = mysql_num_rows($question_answer);

include '../include/header.php';

?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Question:</td>
      <td><select name="question">
        <?php 
do {  
?>
        <option value="<?php echo $row_questions['id']?>" <?php if (!(strcmp($row_questions['id'], htmlentities($row_question_answer['question'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>><?php echo $row_questions['question']?></option>
        <?php
} while ($row_questions = mysql_fetch_assoc($questions));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Answer:</td>
      <td><select name="answer">
        <?php 
do {  
?>
        <option value="<?php echo $row_answers['id']?>" <?php if (!(strcmp($row_answers['id'], htmlentities($row_question_answer['answer'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>><?php echo $row_answers['answer']?></option>
        <?php
} while ($row_answers = mysql_fetch_assoc($answers));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_question_answer['id']; ?>">
</form>
<p>&nbsp;</p>

<?php
include '../include/footer.php';
mysql_free_result($answers);

mysql_free_result($questions);

mysql_free_result($question_answer);
?>