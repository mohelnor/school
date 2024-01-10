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
$query_students = "SELECT students.id , users.full_name as user, classes.class , students.created , students.updated FROM students , users , classes WHERE 
users.id = students.user AND classes.id = students.class";
$students = mysql_query($query_students, $conn) or die(mysql_error());
$row_students = mysql_fetch_assoc($students);
$totalRows_students = mysql_num_rows($students);

mysql_select_db($database_conn, $conn);
$query_classes = "SELECT * FROM classes";
$classes = mysql_query($query_classes, $conn) or die(mysql_error());
$row_classes = mysql_fetch_assoc($classes);
$totalRows_classes = mysql_num_rows($classes);

include('../include/header.php');
?>
<h1>الطلبة</h1>

<div class="d-print-none">
  <a href="add.php" class="btn btn-warning">إضافة</a>
  <button class="btn btn-dark float-end" onclick="print()">تقرير كامل <i class="fas fa-print"></i></button>
  <hr />
</div>

<table class="table table-responsive">
  <tr>
    <th>id</th>
    <th>user</th>
    <th>class</th>
    <th>created</th>
    <th>updated</th>
    <th class="d-print-none">actions</th>
  </tr>
  <?php do { ?>
    <tr>
      <th><?php echo $row_students['id']; ?></th>
      <td><?php echo $row_students['user']; ?></td>
      <td><?php echo $row_students['class']; ?></td>
      <td><?php echo $row_students['created']; ?></td>
      <td><?php echo $row_students['updated']; ?></td>
      <td class="d-print-none"><a href="edit.php?id=<?php echo $row_students['id']; ?>"><i class="fas fa-edit text-success"></i></a> |
        <a href="delete.php?id=<?php echo $row_students['id']; ?>" onclick="return confirm('هل تريد الحذف')"><i class="fas fa-trash-alt text-danger"></i></a>
      </td>
    </tr>
    <?php } while ($row_students = mysql_fetch_assoc($students));
 ?>
</table>
<?php
mysql_free_result($students);

mysql_free_result($classes);
include("../include/footer.php");

?>