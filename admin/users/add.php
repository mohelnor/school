<?php require_once('../../Connections/conn.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO users (`user`, full_name, email, password, phone, type, gender, D_O_B, status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['full_name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['D_O_B'], "date"),
                       GetSQLValueString($_POST['status'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


include("../include/header.php");
?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">User:</td>
      <td><input type="text" name="user" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Full_name:</td>
      <td><input type="text" name="full_name" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Email:</td>
      <td><input type="text" name="email" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Password:</td>
      <td><input type="text" name="password" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Phone:</td>
      <td><input type="text" name="phone" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Type:</td>
      <td><select name="type">
        <option value="admin" <?php if (!(strcmp("admin", ""))) {echo "SELECTED";} ?>>admin</option>
        <option value="teacher" <?php if (!(strcmp("teacher", ""))) {echo "SELECTED";} ?>>teacher</option>
        <option value="student" <?php if (!(strcmp("student", ""))) {echo "SELECTED";} ?>>student</option>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Gender:</td>
      <td><select name="gender">
        <option value="male" <?php if (!(strcmp("male", ""))) {echo "SELECTED";} ?>>male</option>
        <option value="female" <?php if (!(strcmp("female", ""))) {echo "SELECTED";} ?>>female</option>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">D_O_B:</td>
      <td><input type="text" name="D_O_B" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Status:</td>
      <td><select name="status">
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>block</option>
        <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>unblock</option>
      </select>
      </td>
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

include("../include/footer.php");
?>