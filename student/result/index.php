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

$colname_results = "-1";
if (isset($row_student)) {
    $colname_results = $row_student['id'];
    $std_class_results = $row_student['class'];
}
mysql_select_db($database_conn, $conn);
// $query_results = sprintf("SELECT * FROM `result` WHERE student = %s AND class = %s", GetSQLValueString($colname_results, "int"), GetSQLValueString($std_class_results, "int"));
$query_results = sprintf("SELECT classes.class , exams.exam , result.mark FROM `result` , exams , classes WHERE classes.id = result.class AND exams.id = result.exam AND result.student = %s AND result.class = %s", GetSQLValueString($colname_results, "int"), GetSQLValueString($std_class_results, "int"));
$results = mysql_query($query_results, $conn) or die(mysql_error());
$row_results = mysql_fetch_assoc($results);
$totalRows_results = mysql_num_rows($results);

include '../include/header.php';
?>

<h1>النتيجة</h1>
<div class="d-print-none p-2">
  <button class="btn btn-dark float-end" onclick="print()"><i class="fas fa-print"></i></button>
  <hr />
</div>

<table class="table table-responsive">
  <tr>
    <th>class</th>
    <th>exam</th>
    <th>mark</th>
  </tr>
  <?php do {?>
    <tr>
      <td><?php echo $row_results['class']; ?></td>
      <td><?php echo $row_results['exam']; ?></td>
      <td><?php echo $row_results['mark']; ?></td>
    </tr>
    <?php } while ($row_results = mysql_fetch_assoc($results));

mysql_free_result($results);?>
</table>

<?php
include '../include/footer.php';
?>
