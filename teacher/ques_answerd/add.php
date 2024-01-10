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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO question_answer (question, answer) VALUES (%s, %s)",
                       GetSQLValueString($_POST['question'], "int"),
                       GetSQLValueString($_POST['answer'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_answers = "SELECT * FROM answers";
$answers = mysql_query($query_answers, $conn) or die(mysql_error());
$row_answers = mysql_fetch_assoc($answers);
$totalRows_answers = mysql_num_rows($answers);

mysql_select_db($database_conn, $conn);
$query_questions = "SELECT * FROM questions";
$colname_questions = "-1";
if (isset($_GET['exam'])) {
  $colname_questions = $_GET['exam'];
  $query_questions = sprintf("SELECT * FROM questions WHERE exam = %s", GetSQLValueString($colname_questions, "int"));
}
$questions = mysql_query($query_questions, $conn) or die(mysql_error());
$row_questions = mysql_fetch_assoc($questions);
$totalRows_questions = mysql_num_rows($questions);

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
        <option value="<?php echo $row_questions['id']?>" ><?php echo $row_questions['question']?></option>
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
        <option value="<?php echo $row_answers['id']?>" ><?php echo $row_answers['answer']?></option>
        <?php
} while ($row_answers = mysql_fetch_assoc($answers));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>

<?php
include '../include/footer.php';

mysql_free_result($answers);

mysql_free_result($questions);
?>