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
$query_answers = "SELECT * FROM answers";
$answers = mysql_query($query_answers, $conn) or die(mysql_error());
$row_answers = mysql_fetch_assoc($answers);
$totalRows_answers = mysql_num_rows($answers);

include '../include/header.php';

?>
<h1>الأجوبة</h1>
<div class="d-print-none p-2">
  <a href="add.php" class="btn btn-warning">إضافة</a>
  <button class="btn btn-dark float-end" onclick="print()">تقرير كامل <i class="fas fa-print"></i></button>
  <hr />
</div>

<table class="table table-responsive">
  <tr>
    <th>id</th>
    <th>answer</th>
    <th class="d-print-none">actions</th>
  </tr>
  <?php do { ?>
    <tr>
      <th><?php echo $row_answers['id']; ?></th>
      <td><?php echo $row_answers['answer']; ?></td>
      <td class="d-print-none"><a href="edit.php?id=<?php echo $row_answers['id']; ?>"><i class="fas fa-edit text-success"></i></a> |
        <a href="delete.php?id=<?php echo $row_answers['id']; ?>" onclick="return confirm('هل تريد الحذف')"><i class="fas fa-trash-alt text-danger"></i></a>
      </td>
    </tr>
    <?php } while ($row_answers = mysql_fetch_assoc($answers)); 
?>
</table>

<?php
include '../include/footer.php';
mysql_free_result($answers);
?>