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
  $insertSQL = sprintf("INSERT INTO teachers (`user`, subject, more) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['user'], "int"),
                       GetSQLValueString($_POST['subject'], "int"),
                       GetSQLValueString($_POST['more'], "text"));

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
$query_users = "SELECT * FROM users WHERE type ='teacher'";
$users = mysql_query($query_users, $conn) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

mysql_select_db($database_conn, $conn);
$query_subjects = "SELECT * FROM subjects";
$subjects = mysql_query($query_subjects, $conn) or die(mysql_error());
$row_subjects = mysql_fetch_assoc($subjects);
$totalRows_subjects = mysql_num_rows($subjects);

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
        <option value="<?php echo $row_users['id']?>" <?php if (!(strcmp($row_users['id'], $row_users['id']))) {echo "SELECTED";} ?>><?php echo $row_users['full_name']?></option>
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
        <option value="<?php echo $row_subjects['id']?>" <?php if (!(strcmp($row_subjects['id'], $row_subjects['id']))) {echo "SELECTED";} ?>><?php echo $row_subjects['subject']?></option>
        <?php
} while ($row_subjects = mysql_fetch_assoc($subjects));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">More:</td>
      <td><textarea name="more" cols="50" rows="5"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($users);

mysql_free_result($subjects);
include("../include/footer.php");
?>