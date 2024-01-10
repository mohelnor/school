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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $insertSQL = sprintf("INSERT INTO exams (exam,class, subject, duration, marks, teacher,created) VALUES (%s, %s,%s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['exam'], "text"),
        GetSQLValueString($_POST['class'], "int"),
        GetSQLValueString($_POST['subject'], "int"),
        GetSQLValueString($_POST['duration'], "int"),
        GetSQLValueString($_POST['marks'], "int"),
        GetSQLValueString($_SESSION['user']['id'], "int"),
        GetSQLValueString($_POST['created'], "date"));

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
$query_subjects = "SELECT * FROM subjects";
$subjects = mysql_query($query_subjects, $conn) or die(mysql_error());
$row_subjects = mysql_fetch_assoc($subjects);
$totalRows_subjects = mysql_num_rows($subjects);

mysql_select_db($database_conn, $conn);
$query_classes = "SELECT * FROM classes";
$classes = mysql_query($query_classes, $conn) or die(mysql_error());
$row_classes = mysql_fetch_assoc($classes);
$totalRows_classes = mysql_num_rows($classes);

include '../include/header.php';

?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Exam:</td>
      <td><input type="text" name="exam" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Subject:</td>
      <td><select name="subject">
        <?php
do {
    ?>
        <option value="<?php echo $row_subjects['id'] ?>" <?php if (!(strcmp($row_subjects['id'], $row_subjects['id']))) {echo "SELECTED";}?>><?php echo $row_subjects['subject'] ?></option>
        <?php
} while ($row_subjects = mysql_fetch_assoc($subjects));
?>
      </select></td>
      <tr valign="baseline">
      <td nowrap align="right">Class:</td>
      <td><select name="class">
        <?php
do {
    ?>
        <option value="<?php echo $row_classes['id'] ?>" <?php if (!(strcmp($row_classes['id'], $row_classes['id']))) {echo "SELECTED";}?>><?php echo $row_classes['class'] ?></option>
        <?php
} while ($row_classes = mysql_fetch_assoc($classes));
?>
      </select></td>
    <tr>
      <tr>
        <tr valign="baseline">
          <td nowrap align="right">Duration:</td>
          <td><input type="text" name="duration" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Marks:</td>
          <td><input type="text" name="marks" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">created:</td>
          <td><input type="datetime-local" name="created" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" value="Insert record"></td>
        </tr>
      </table>
      <input type="hidden" name="teacher" value="<?php echo $_SESSION['user']['id']; ?>">
      <input type="hidden" name="MM_insert" value="form1">
    </form>
    <p>&nbsp;</p>
    <?php
include '../include/footer.php';
mysql_free_result($subjects);
?>