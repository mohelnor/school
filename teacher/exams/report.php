<?php require_once '../../Connections/conn.php';?>
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
    $updateSQL = sprintf("UPDATE exams SET exam=%s, subject=%s, `class`=%s, duration=%s, marks=%s, created=%s WHERE id=%s",
        GetSQLValueString($_POST['exam'], "text"),
        GetSQLValueString($_POST['subject'], "int"),
        GetSQLValueString($_POST['class'], "int"),
        GetSQLValueString($_POST['duration'], "int"),
        GetSQLValueString($_POST['marks'], "int"),
        GetSQLValueString($_POST['created'], "date"),
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

$colname_exams = "-1";
if (isset($_GET['id'])) {
    $colname_exams = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_exams = sprintf("SELECT * FROM exams WHERE id = %s", GetSQLValueString($colname_exams, "int"));
$exams = mysql_query($query_exams, $conn) or die(mysql_error());
$row_exams = mysql_fetch_assoc($exams);
$totalRows_exams = mysql_num_rows($exams);

mysql_select_db($database_conn, $conn);
$query_classes = "SELECT * FROM classes";
$classes = mysql_query($query_classes, $conn) or die(mysql_error());
$row_classes = mysql_fetch_assoc($classes);
$totalRows_classes = mysql_num_rows($classes);

mysql_select_db($database_conn, $conn);
$query_subjects = "SELECT * FROM subjects";
$subjects = mysql_query($query_subjects, $conn) or die(mysql_error());
$row_subjects = mysql_fetch_assoc($subjects);
$totalRows_subjects = mysql_num_rows($subjects);

include '../include/header.php';

?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Exam:</td>
      <td><input type="text" name="exam" value="<?php echo htmlentities($row_exams['exam'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Subject:</td>
      <td><select name="subject">
        <?php
do {
    ?>
        <option value="<?php echo $row_subjects['id'] ?>" <?php if (!(strcmp($row_subjects['id'], htmlentities($row_exams['subject'], ENT_COMPAT, '')))) {echo "SELECTED";}?>><?php echo $row_subjects['subject'] ?></option>
        <?php
} while ($row_subjects = mysql_fetch_assoc($subjects));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Class:</td>
      <td><select name="class">
        <?php
do {
    ?>
        <option value="<?php echo $row_classes['id'] ?>" <?php if (!(strcmp($row_classes['id'], htmlentities($row_exams['class'], ENT_COMPAT, '')))) {echo "SELECTED";}?>><?php echo $row_classes['class'] ?></option>
        <?php
} while ($row_classes = mysql_fetch_assoc($classes));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Duration:</td>
      <td><input type="text" name="duration" value="<?php echo htmlentities($row_exams['duration'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Marks:</td>
      <td><input type="text" name="marks" value="<?php echo htmlentities($row_exams['marks'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Created:</td>
      <td><input type="datetime-local" name="created" value="<?php echo htmlentities($row_exams['created'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_exams['id']; ?>">
</form>
<p>&nbsp;</p>


<?php

include '../include/footer.php';

mysql_free_result($exams);

mysql_free_result($classes);

mysql_free_result($subjects);

?>