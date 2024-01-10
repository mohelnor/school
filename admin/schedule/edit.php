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
  $updateSQL = sprintf("UPDATE shedule SET schedule=%s, type=%s, `class`=%s, period=%s WHERE id=%s",
                       GetSQLValueString($_POST['schedule'], "text"),
                       GetSQLValueString($_POST['type'], "int"),
                       GetSQLValueString($_POST['class'], "int"),
                       GetSQLValueString($_POST['period'], "date"),
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
$query_classes = "SELECT * FROM classes";
$classes = mysql_query($query_classes, $conn) or die(mysql_error());
$row_classes = mysql_fetch_assoc($classes);
$totalRows_classes = mysql_num_rows($classes);

$colname_schedule = "-1";
if (isset($_GET['id'])) {
  $colname_schedule = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_schedule = sprintf("SELECT * FROM shedule WHERE id = %s", GetSQLValueString($colname_schedule, "int"));
$schedule = mysql_query($query_schedule, $conn) or die(mysql_error());
$row_schedule = mysql_fetch_assoc($schedule);
$totalRows_schedule = mysql_num_rows($schedule);

include('../include/header.php');
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Type:</td>
      <td><select name="type">
        <option value="1" <?php if (!(strcmp(1, htmlentities($row_schedule['type'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>exam</option>
        <option value="2" <?php if (!(strcmp(2, htmlentities($row_schedule['type'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>classes</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Class:</td>
      <td><select name="class">
        <?php 
do {  
  ?>
        <option value="<?php echo $row_classes['id']?>" <?php if (!(strcmp($row_classes['id'], htmlentities($row_schedule['class'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>><?php echo $row_classes['class']?></option>
        <?php
} while ($row_classes = mysql_fetch_assoc($classes));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Period:</td>
      <td><input type="datetime-local" name="period" value="<?php echo htmlentities($row_schedule['period'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <tr valign="baseline">
        <td nowrap align="right">Schedule:</td>
        <td>
        <textarea class="ckeditor" cols="80" id="editor1" name="schedule" rows="10">
        <?php echo htmlentities($row_schedule['schedule'], ENT_COMPAT, ''); ?>
      </textarea>  
        </td>
      </tr>
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_schedule['id']; ?>">
</form>
<p>&nbsp;</p>

<script src="../../assets/ckeditor/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#editor')).catch(
  error=>{
console.error(error);
  });
</script>

<?php

mysql_free_result($classes);

mysql_free_result($schedule);

include("../include/footer.php");

?>