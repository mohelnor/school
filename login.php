<?php
include 'Connections/conn.php';

session_unset();

if (isset($_POST['phone'])) {

    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `users` WHERE phone = $phone AND password = $password";
    $result = mysql_query($sql, $conn) or die(mysql_error());

    if (mysql_num_rows($result)) {
        //  get user info .......
        $row = mysql_fetch_assoc($result);
        $_SESSION['user'] = $row;
        header('Location: admin/index.php');
    } else {
        echo "<script>
alert('الحساب غير متاح');
</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Login </title>
  <link rel="icon" href="assets/img/logo.jpg" type="image/x-icon">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.rtl.min.css">
</head>

<style>
  body {
    margin: 0;
    padding: 0;
    background-color: #eeeecc;
  }
</style>

<body>

  <div class="card w-25 mx-auto mt-5 p-0 m-0 text-right border-0 shadow">
    <div class="card-body vh-25">
    </div>
    <div class="card-body">
      <form method="POST">
        <div class="form-group">
          <label for="exampleInputEmail1">رقم الهاتف</label>
          <input type="phone" name="phone" class="form-control" placeholder="0XXXXXXXXX" autocomplete="false">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">كلمة المرور</label>
          <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="false">
        </div>
        <div class="m-2"></div>
        <div class="text-center">
          <button type="submit" class="btn btn-warning w-100">تسجيل الدحول</button>
        </div>
      </form>
    </div>

    <div class="card-footer font-bold">
      <center>
        نظام الجامعة
      </center>
    </div>
  </div>
</body>
</html>
