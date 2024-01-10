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
  $updateSQL = sprintf("UPDATE questions SET question=%s, exam=%s, answer=%s, degree=%s WHERE id=%s",
                       GetSQLValueString($_POST['question'], "text"),
                       GetSQLValueString($_POST['exam'], "int"),
                       GetSQLValueString($_POST['answer'], "int"),
                       GetSQLValueString($_POST['degree'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "index.php";
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_exams = "-1";
if (isset($_SESSION['id'])) {
  $colname_exams = $_SESSION['id'];
}
mysql_select_db($database_conn, $conn);
$query_exams = sprintf("SELECT * FROM exams WHERE teacher = %s", GetSQLValueString($colname_exams, "int"));
$exams = mysql_query($query_exams, $conn) or die(mysql_error());
$row_exams = mysql_fetch_assoc($exams);
$totalRows_exams = mysql_num_rows($exams);

mysql_select_db($database_conn, $conn);
$query_anwsers = "SELECT * FROM answers";
$anwsers = mysql_query($query_anwsers, $conn) or die(mysql_error());
$row_anwsers = mysql_fetch_assoc($anwsers);
$totalRows_anwsers = mysql_num_rows($anwsers);

$colname_questions = "-1";
if (isset($_GET['id'])) {
  $colname_questions = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_questions = sprintf("SELECT * FROM questions WHERE id = %s", GetSQLValueString($colname_questions, "int"));
$questions = mysql_query($query_questions, $conn) or die(mysql_error());
$row_questions = mysql_fetch_assoc($questions);
$totalRows_questions = mysql_num_rows($questions);

include '../include/header.php';
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Question:</td>
      <td><input type="text" name="question" value="<?php echo htmlentities($row_questions['question'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    
        <tr valign="baseline">
          <td nowrap align="right">Answer:</td>
          <td><select name="answer">
        <?php 
do {  
  ?>
        <option value="<?php echo $row_anwsers['id']?>" <?php if (!(strcmp($row_anwsers['id'], htmlentities($row_questions['answer'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>><?php echo $row_anwsers['answer']?></option>
        <?php
} while ($row_anwsers = mysql_fetch_assoc($anwsers));
?>
      </select></td>
    <tr>
      <tr valign="baseline">
        <td nowrap align="right">Degree:</td>
        <td><input type="text" name="degree" value="<?php echo htmlentities($row_questions['degree'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>  
  <input type="hidden" name="exam" value="<?php echo $row_questions['exam']; ?>" size="32">
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_questions['id']; ?>">
</form>
<p>&nbsp;</p>

<?php
include '../include/footer.php';

mysql_free_result($exams);

mysql_free_result($anwsers);

mysql_free_result($questions);
?>
