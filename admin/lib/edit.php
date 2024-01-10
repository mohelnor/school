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
    $uploadOk = 1;
    $target_dir = "../../assets/images/uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";

            $updateSQL = sprintf("UPDATE assets SET asset=%s, src=%s, `class`=%s, subject=%s WHERE id=%s",
                GetSQLValueString($_POST['asset'], "text"),
                GetSQLValueString($_POST['src'], "text"),
                GetSQLValueString($_POST['class'], "int"),
                GetSQLValueString($_POST['subject'], "int"),
                GetSQLValueString($_POST['id'], "int"));

            mysql_select_db($database_conn, $conn);
            $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

            $updateGoTo = "index.php";
            if (isset($_SERVER['QUERY_STRING'])) {
                $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
                $updateGoTo .= $_SERVER['QUERY_STRING'];
            }
            header(sprintf("Location: %s", $updateGoTo));
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

}

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

$colname_lib = "-1";
if (isset($_GET['id'])) {
    $colname_lib = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_lib = sprintf("SELECT * FROM assets WHERE id = %s", GetSQLValueString($colname_lib, "int"));
$lib = mysql_query($query_lib, $conn) or die(mysql_error());
$row_lib = mysql_fetch_assoc($lib);
$totalRows_lib = mysql_num_rows($lib);

include '../include/header.php';
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Asset:</td>
      <td><input type="text" name="asset" value="<?php echo htmlentities($row_lib['asset'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Src:</td>
      <td>
  <?php echo htmlentities($row_lib['src'], ENT_COMPAT, ''); ?>
  <input type="file" name="fileToUpload" id="fileToUpload">
    </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Class:</td>
      <td><select name="class">
        <?php
do {
    ?>
        <option value="<?php echo $row_classes['id'] ?>" <?php if (!(strcmp($row_classes['id'], htmlentities($row_lib['class'], ENT_COMPAT, '')))) {echo "SELECTED";}?>><?php echo $row_classes['class'] ?></option>
        <?php
} while ($row_classes = mysql_fetch_assoc($classes));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Subject:</td>
      <td><select name="subject">
        <?php
do {
    ?>
        <option value="<?php echo $row_subjects['id'] ?>" <?php if (!(strcmp($row_subjects['id'], htmlentities($row_lib['subject'], ENT_COMPAT, '')))) {echo "SELECTED";}?>><?php echo $row_subjects['subject'] ?></option>
        <?php
} while ($row_subjects = mysql_fetch_assoc($subjects));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_lib['id']; ?>">
</form>
<p>&nbsp;</p>

<?php

mysql_free_result($classes);

mysql_free_result($subjects);

mysql_free_result($lib);
include "../include/footer.php";

?>