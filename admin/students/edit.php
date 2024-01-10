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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE students SET `user`=%s, `class`=%s WHERE id=%s",
                       GetSQLValueString($_POST['user'], "int"),
                       GetSQLValueString($_POST['class'], "int"),
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

$colname_student = "-1";
if (isset($_GET['id'])) {
  $colname_student = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_student = sprintf("SELECT * FROM students WHERE id = %s", GetSQLValueString($colname_student, "int"));
$student = mysql_query($query_student, $conn) or die(mysql_error());
$row_student = mysql_fetch_assoc($student);
$totalRows_student = mysql_num_rows($student);

$colname_users = "student";
mysql_select_db($database_conn, $conn);
$query_users = sprintf("SELECT * FROM users WHERE type = %s", GetSQLValueString($colname_users, "text"));
$users = mysql_query($query_users, $conn) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

mysql_select_db($database_conn, $conn);
$query_classes = "SELECT * FROM classes";
$classes = mysql_query($query_classes, $conn) or die(mysql_error());
$row_classes = mysql_fetch_assoc($classes);
$totalRows_classes = mysql_num_rows($classes);

include('../include/header.php');
?>

<form method="post" name="form2" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">User:</td>
      <td><select name="user">
        <?php
do {  
?>
        <option value="<?php echo $row_users['id']?>"<?php if (!(strcmp($row_users['id'], htmlentities($row_student['user'], ENT_COMPAT, '')))) {echo "selected=\"selected\"";} ?>><?php echo $row_users['user']?></option>
        <?php
} while ($row_users = mysql_fetch_assoc($users));
  $rows = mysql_num_rows($users);
  if($rows > 0) {
      mysql_data_seek($users, 0);
	  $row_users = mysql_fetch_assoc($users);
  }
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Class:</td>
      <td><select name="class">
        <?php 
do {  
?>
        <option value="<?php echo $row_classes['id']?>" <?php if (!(strcmp($row_classes['id'], htmlentities($row_student['class'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>><?php echo $row_classes['class']?></option>
        <?php
} while ($row_classes = mysql_fetch_assoc($classes));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2">
  <input type="hidden" name="id" value="<?php echo $row_student['id']; ?>">
</form>
<p>&nbsp;</p>

<?php
mysql_free_result($student);
mysql_free_result($users);
mysql_free_result($classes);
include("../include/footer.php");

?>