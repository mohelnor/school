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
$query_teachers = "SELECT teachers.id , users.full_name as user, subjects.subject , teachers.more FROM teachers , users , subjects WHERE 
users.id = teachers.user AND subjects.id = teachers.subject";
$teachers = mysql_query($query_teachers,$conn) or die(mysql_error($conn));
$row_teachers = mysql_fetch_assoc($teachers);
$totalRows_teachers = mysql_num_rows($teachers);

include('../include/header.php');
?>
<h1>الأساتذة</h1>

<div class="d-print-none">
  <a href="add.php" class="btn btn-warning">إضافة</a>
  <button class="btn btn-dark float-end" onclick="print()">تقرير كامل <i class="fas fa-print"></i></button>
  <hr />
</div>

<table class="table table-responsive">
  <tr>
    <th>id</th>
    <th>user</th>
    <th>subject</th>
    <th>more</th>
    <th class="d-print-none">actions</th>
  </tr>
  <?php do { ?>
    <tr>
      <th><?php echo $row_teachers['id']; ?></th>
      <td><?php echo $row_teachers['user']; ?></td>
      <td><?php echo $row_teachers['subject']; ?></td>
      <td><?php echo $row_teachers['more']; ?></td>
      <td class="d-print-none"><a href="edit.php?id=<?php echo $row_teachers['id']; ?>"><i class="fas fa-edit text-success"></i></a> |
        <a href="delete.php?id=<?php echo $row_teachers['id']; ?>" onclick="return confirm('هل تريد الحذف')"><i class="fas fa-trash-alt text-danger"></i></a>
      </td>    </tr>
    <?php } while ($row_teachers = mysql_fetch_assoc($teachers)); ?>
  </table>
<?php
mysql_free_result($teachers);
include("../include/footer.php");
?>