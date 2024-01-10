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
  $insertSQL = sprintf("INSERT INTO shedule (schedule, type, `class`, period) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['schedule'], "text"),
                       GetSQLValueString($_POST['type'], "int"),
                       GetSQLValueString($_POST['class'], "int"),
                       GetSQLValueString($_POST['period'], "date"));

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
$query_classes = "SELECT * FROM classes";
$classes = mysql_query($query_classes, $conn) or die(mysql_error());
$row_classes = mysql_fetch_assoc($classes);
$totalRows_classes = mysql_num_rows($classes);


include('../include/header.php');
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Type:</td>
      <td><select name="type">
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>exam</option>
        <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>classes</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Class:</td>
      <td><select name="class">
        <?php 
do {  
?>
        <option value="<?php echo $row_classes['id']?>" <?php if (!(strcmp($row_classes['id'], $row_classes['id']))) {echo "SELECTED";} ?>><?php echo $row_classes['room']?></option>
        <?php
} while ($row_classes = mysql_fetch_assoc($classes));
?>
      </select></td>
      <tr>
        <tr valign="baseline">
          <td nowrap align="right">Period:</td>
          <td><input type="datetime-local" name="period" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Schedule:</td>
          <td>
          <textarea class="ckeditor" cols="80" id="editor1" name="schedule" rows="10">
        </textarea>    
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

<script src="../../assets//ckeditor/ckeditor.js"></script>


<?php
mysql_free_result($classes);

include("../include/footer.php");

?>
