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
$query_assets = "SELECT assets.id , subjects.subject , classes.class , assets.asset , assets.src , assets.created,assets.updated FROM assets , subjects , classes WHERE assets.subject = subjects.id AND assets.class = classes.id ";
$colname_assets = "-1";
if (isset($_GET['class'])) {
  $colname_assets = $_GET['class'];
  $query_assets = sprintf("SELECT assets.id , subjects.subject , classes.class , assets.asset , assets.src , assets.created,assets.updated FROM assets , subjects , classes WHERE assets.subject = subjects.id AND assets.class = classes.id  AND assets.class = %s", GetSQLValueString($colname_assets, "int"));
}
$assets = mysql_query($query_assets, $conn) or die(mysql_error());
$row_assets = mysql_fetch_assoc($assets);
$totalRows_assets = mysql_num_rows($assets);

include('../include/header.php');
?>
<h1>الكتب</h1>

<div class="d-print-none">
  <a href="add.php" class="btn btn-warning">إضافة</a>
  <button class="btn btn-dark float-end" onclick="print()">تقرير كامل <i class="fas fa-print"></i></button>
  <hr />
</div>


<table class="table">
  <tr>
    <th>id</th>
    <th>subject</th>
    <th>class</th>
    <th>asset</th>
    <th>src</th>
    <th>created</th>
    <th>updated</th>
    <th>actions</th>
  </tr>
  <?php do { ?>
    <tr>
      <th><?php echo $row_assets['id']; ?></th>
      <td><?php echo $row_assets['subject']; ?></td>
      <td><?php echo $row_assets['class']; ?></td>
      <td><?php echo $row_assets['asset']; ?></td>
      <td><?php echo $row_assets['src']; ?></td>
      <td><?php echo $row_assets['created']; ?></td>
      <td><?php echo $row_assets['updated']; ?></td>
      <td class="d-print-none"><a href="edit.php?id=<?php echo $row_assets['id']; ?>"><i class="fas fa-edit text-success"></i></a> |
        <a href="delete.php?id=<?php echo $row_assets['id']; ?>" onclick="return confirm('هل تريد الحذف')"><i class="fas fa-trash-alt text-danger"></i></a>
      </td>
    </tr>
    <?php } while ($row_assets = mysql_fetch_assoc($assets)); 
mysql_free_result($assets);?>
</table>

<?php

include("../include/footer.php");

?>