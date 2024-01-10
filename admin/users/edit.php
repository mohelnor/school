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
  $updateSQL = sprintf("UPDATE users SET `user`=%s, full_name=%s, email=%s, password=%s, phone=%s, type=%s, gender=%s, D_O_B=%s, status=%s WHERE id=%s",
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['full_name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['D_O_B'], "date"),
                       GetSQLValueString($_POST['status'], "int"),
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

$colname_users = "-1";
if (isset($_GET['id'])) {
  $colname_users = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_users = sprintf("SELECT * FROM users WHERE id = %s", GetSQLValueString($colname_users, "int"));
$users = mysql_query($query_users, $conn) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

include("../include/header.php");

?>


<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">User:</td>
      <td><input type="text" name="user" value="<?php echo htmlentities($row_users['user'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Full_name:</td>
      <td><input type="text" name="full_name" value="<?php echo htmlentities($row_users['full_name'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Email:</td>
      <td><input type="text" name="email" value="<?php echo htmlentities($row_users['email'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Password:</td>
      <td><input type="text" name="password" value="<?php echo htmlentities($row_users['password'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Phone:</td>
      <td><input type="text" name="phone" value="<?php echo htmlentities($row_users['phone'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Type:</td>
      <td><select name="type">
        <option value="admin" <?php if (!(strcmp("admin", htmlentities($row_users['type'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>admin</option>
        <option value="teacher" <?php if (!(strcmp("teacher", htmlentities($row_users['type'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>teacher</option>
        <option value="student" <?php if (!(strcmp("student", htmlentities($row_users['type'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>student</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Gender:</td>
      <td><select name="gender">
        <option value="male" <?php if (!(strcmp("male", htmlentities($row_users['gender'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>male</option>
        <option value="female" <?php if (!(strcmp("female", htmlentities($row_users['gender'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>female</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">D_O_B:</td>
      <td><input type="text" name="D_O_B" value="<?php echo htmlentities($row_users['D_O_B'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Status:</td>
      <td><input type="text" name="status" value="<?php echo htmlentities($row_users['status'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_users['id']; ?>">
</form>
<p>&nbsp;</p>

<?php

mysql_free_result($users);
include("../include/footer.php");
?>