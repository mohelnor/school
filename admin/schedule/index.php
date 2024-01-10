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

mysql_select_db($database_conn, $conn);
$query_schedule = "SELECT shedule.id,shedule.schedule,shedule.type,classes.class ,shedule.period FROM shedule,classes WHERE classes.id = shedule.class";

if (isset($_GET['type'])) {
  $type = $_GET['type'];
  $query_schedule = sprintf("SELECT shedule.id,shedule.schedule,shedule.type,classes.class ,shedule.period FROM shedule,classes WHERE classes.id = shedule.class AND shedule.type = %s", GetSQLValueString($type, "int"));
}

$schedule = mysql_query($query_schedule, $conn) or die(mysql_error());
$row_schedule = mysql_fetch_assoc($schedule);
$totalRows_schedule = mysql_num_rows($schedule);


include('../include/header.php');
?>
<h1>الجداول</h1>

<div class="d-print-none">
  <a href="add.php" class="btn btn-warning">إضافة</a>
  <a href="?type=1" class="btn btn-danger">إمتحانات</a>
  <a href="?type=2" class="btn btn-warning">حصص</a>
  <button class="btn btn-dark float-end" onclick="print()">تقرير كامل <i class="fas fa-print"></i></button>
  <hr />
</div>

<table class="table table-responsive">
  <tr>
    <th>class</th>
    <th>period</th>
    <th class="d-print-none">actions</th>
  </tr>
  <?php do { ?>
    <tr>
    <td><?php echo $row_schedule['class']; ?></td>
    <td><?php echo $row_schedule['period']; ?></td>
    <td class="d-print-none"><a href="edit.php?id=<?php echo $row_schedule['id']; ?>"><i class="fas fa-edit text-success"></i></a> |
    <a href="delete.php?id=<?php echo $row_schedule['id']; ?>" onclick="return confirm('هل تريد الحذف')"><i class="fas fa-trash-alt text-danger"></i></a>
  </td>
  </tr>
  <tr>
    <td colspan="5"><?php echo $row_schedule['schedule']; ?></td>
  </tr>
  <?php } while ($row_schedule = mysql_fetch_assoc($schedule));
  ?>
</table>

<?php

include("../include/footer.php");
mysql_free_result($schedule);
?>