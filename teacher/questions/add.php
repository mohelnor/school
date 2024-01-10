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
  $insertSQL = sprintf("INSERT INTO questions (question, exam, degree, teacher) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['question'], "text"),
                       GetSQLValueString($_POST['exam'], "int"),
                       GetSQLValueString($_POST['degree'], "int"),
                       GetSQLValueString($_SESSION['user']['id'], "int"));

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
$query_exams = "SELECT * FROM exams";
$exams = mysql_query($query_exams, $conn) or die(mysql_error());
$row_exams = mysql_fetch_assoc($exams);
$totalRows_exams = mysql_num_rows($exams);
include '../include/header.php';

?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Question:</td>
      <td><input type="text" name="question" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Exam:</td>
      <td><select name="exam">
        <?php 
do {  
  ?>
        <option value="<?php echo $row_exams['id']?>" <?php if (!(strcmp($row_exams['id'], $row_exams['id']))) {echo "SELECTED";} ?>><?php echo $row_exams['exam']?></option>
        <?php
} while ($row_exams = mysql_fetch_assoc($exams));
?>
      </select></td>
      <tr>
        <tr valign="baseline">
          <td nowrap align="right">Degree:</td>
          <td><input type="text" name="degree" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" value="Insert record"></td>
        </tr>
      </table>
      <input type="hidden" name="teacher" value="<?php echo $_SESSION['id']; ?>">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
<?php
include '../include/footer.php';
mysql_free_result($exams);

?>