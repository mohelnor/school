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

$colname_student = "-1";
if (isset($_SESSION['user']['id'])) {
    $colname_student = $_SESSION['user']['id'];
}
mysql_select_db($database_conn, $conn);
$query_student = sprintf("SELECT * FROM students WHERE user = %s", GetSQLValueString($colname_student, "int"));
$student = mysql_query($query_student, $conn) or die(mysql_error());
$row_student = mysql_fetch_assoc($student);
$totalRows_student = mysql_num_rows($student);

mysql_select_db($database_conn, $conn);
$query_assets = "SELECT assets.id ,assets.src , subjects.subject, classes.class, asset FROM assets , subjects , classes WHERE subjects.id = assets.subject AND classes.id = assets.class";
$colname_assets = "-1";
if (isset($_GET['class'])) {
    $colname_assets = $_GET['class'];
    $query_assets = sprintf("SELECT assets.id ,assets.src , subjects.subject, classes.class, asset FROM assets , subjects , classes WHERE subjects.id = assets.subject AND classes.id = assets.class AND assets.class = %s", GetSQLValueString($colname_assets, "int"));
}
$assets = mysql_query($query_assets, $conn) or die(mysql_error());
$row_assets = mysql_fetch_assoc($assets);
$totalRows_assets = mysql_num_rows($assets);

include '../include/header.php';
?>

<h1>المكتبة</h1>

<hr />


<table class="table">
  <tr>
    <th>id</th>
    <th>subject</th>
    <th>class</th>
    <th>asset</th>
    <th class="d-print-none">actions</th>
  </tr>
  <?php do {?>
    <tr>
      <th><?php echo $row_assets['id']; ?></th>
      <td><?php echo $row_assets['subject']; ?></td>
      <td><?php echo $row_assets['class']; ?></td>
      <td><?php echo $row_assets['asset']; ?></td>
      <td class="d-print-none">
        <a href="<?php echo 'http://localhost/school/assets/images/uploads/' . $row_assets['src']; ?>"><i class="fas fa-file-download fa-lg text-danger"></i></a>
      </td>
    </tr>
    <?php } while ($row_assets = mysql_fetch_assoc($assets));
mysql_free_result($assets);?>
</table>

<?php

include "../include/footer.php";

?>