<?php require_once('../../Connections/conn.php'); ?>
<?php
$query_users = "SELECT * FROM users";
$colname_users = "-1";
if (isset($_GET['type'])) {
  $colname_users = (get_magic_quotes_gpc()) ? $_GET['type'] : addslashes($_GET['type']);
  $query_users = sprintf("SELECT * FROM users WHERE type = '%s'", $colname_users);
}

$users = mysql_query($query_users, $conn) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

include("../include/header.php");
?>
<h1>المستخدمين</h1>

<div class="d-print-none">
  <a href="add.php" class="btn btn-warning">إضافة</a>
  <a href="?type=admin" class="btn btn-success">مدير</a>
  <a href="?type=teacher" class="btn btn-secondry">أستاذ</a>
  <a href="?type=student" class="btn btn-info">طالب</a>
  <button class="btn btn-dark float-end" onclick="print()">تقرير<i class="fas fa-print"></i></button>
  <hr />
</div>

<table class="table table-responsive">
  <tr>
    <th>id</th>
    <th>user</th>
    <th>full_name</th>
    <th>email</th>
    <th>password</th>
    <th>phone</th>
    <th>type</th>
    <th>gender</th>
    <th>D_O_B</th>
    <th>status</th>
    <th>created</th>
    <th class="d-print-none">actions</th>
  </tr>
  <?php do { ?>
    <tr>
      <th><?php echo $row_users['id']; ?></th>
      <td><?php echo $row_users['user']; ?></td>
      <td><?php echo $row_users['full_name']; ?></td>
      <td><?php echo $row_users['email']; ?></td>
      <td><?php echo $row_users['password']; ?></td>
      <td><?php echo $row_users['phone']; ?></td>
      <td><?php echo $row_users['type']; ?></td>
      <td><?php echo $row_users['gender']; ?></td>
      <td><?php echo $row_users['D_O_B']; ?></td>
      <td><?php echo $row_users['status']; ?></td>
      <td><?php echo $row_users['created']; ?></td>
      <td class="d-print-none"><a href="edit.php?id=<?php echo $row_users['id']; ?>"><i class="fas fa-edit text-success"></i></a> |
        <a href="delete.php?id=<?php echo $row_users['id']; ?>" onclick="return confirm('هل تريد الحذف')"><i class="fas fa-trash-alt text-danger"></i></a>
      </td>
    </tr>
    <?php } while ($row_users = mysql_fetch_assoc($users)); ?>
</table>
</body>
</html>
<?php
include("../include/footer.php");
mysql_free_result($users);
?>
