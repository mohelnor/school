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

$colname_schedule = "-1";
if (isset($row_student['class'])) {
    $colname_schedule = $row_student['class'];
}

$query_schedule = sprintf("SELECT * FROM shedule WHERE `class` = %s", GetSQLValueString($colname_schedule, "int"));

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $query_schedule = sprintf("SELECT * FROM shedule WHERE `class` = %s AND type =  %s", GetSQLValueString($colname_schedule, "int"), GetSQLValueString($type, "int"));
}

$schedule = mysql_query($query_schedule, $conn) or die(mysql_error());
$row_schedule = mysql_fetch_assoc($schedule);
$totalRows_schedule = mysql_num_rows($schedule);

include '../include/header.php';
?>

<h1>الجداول</h1>
<div class="d-print-none p-2">
  <a href="?type=1" class="btn btn-danger">إمتحانات</a>
  <a href="?type=2" class="btn btn-warning">حصص</a>
  <button class="btn btn-dark float-end" onclick="print()"><i class="fas fa-print"></i></button>
  <hr />
</div>


  <?php do {?>

    <?php echo $row_schedule['schedule']; ?>

    <?php } while ($row_schedule = mysql_fetch_assoc($schedule));
?>

<script>
       var table = document.getElementsByTagName("table")[0];
    table.className = "table-bordered";
</script>
<?php
mysql_free_result($schedule);
include '../include/footer.php';
?>