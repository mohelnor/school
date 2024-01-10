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
  $updateSQL = sprintf("UPDATE teachers SET `user`=%s, subject=%s, more=%s WHERE id=%s",
                       GetSQLValueString($_POST['user'], "int"),
                       GetSQLValueString($_POST['subject'], "int"),
                       GetSQLValueString($_POST['more'], "text"),
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

$query_subjects = "SELECT * FROM subjects";
$subjects = mysql_query($query_subjects, $conn) or die(mysql_error());
$row_subjects = mysql_fetch_assoc($subjects);
$totalRows_subjects = mysql_num_rows($subjects);

$query_users = "SELECT * FROM users WHERE type ='teacher'";
$users = mysql_query($query_users, $conn) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

$colname_teacher = "-1";
if (isset($_GET['id'])) {
  $colname_teacher = $_GET['id'];
}

$query_teacher = sprintf("SELECT * FROM teachers WHERE id = %s", GetSQLValueString($colname_teacher, "int"));
$teacher = mysql_query($query_teacher, $conn) or die(mysql_error());
$row_teacher = mysql_fetch_assoc($teacher);
$totalRows_teacher = mysql_num_rows($teacher);


include('../include/header.php');
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">User:</td>
      <td><select name="user">
        <?php 
do {  
?>
        <option value="<?php echo $row_users['id']?>" <?php if (!(strcmp($row_users['id'], htmlentities($row_teacher['user'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>><?php echo $row_users['user']?></option>
        <?php
} while ($row_users = mysql_fetch_assoc($users));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Subject:</td>
      <td><select name="subject">
        <?php 
do {  
?>
        <option value="<?php echo $row_subjects['id']?>" <?php if (!(strcmp($row_subjects['id'], htmlentities($row_teacher['subject'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>><?php echo $row_subjects['subject']?></option>
        <?php
} while ($row_subjects = mysql_fetch_assoc($subjects));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">More:</td>
      <td><input type="text" name="more" value="<?php echo htmlentities($row_teacher['more'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_teacher['id']; ?>">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($subjects);

mysql_free_result($users);

mysql_free_result($teacher);
include("../include/footer.php");
?>