<?php require_once '../../Connections/conn.php';?>
<?php
date_default_timezone_set('Africa/Khartoum');

$student = 0;
$class = 0;
$exam = 0;
$total_marks = 0;

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

$colname_exams = "-1";
if (isset($row_student)) {
    $student = $row_student['id'];
    $class = $row_student['class'];
    $colname_exams = $row_student['class'];
}

// $query_exams = sprintf("SELECT * FROM `exams` WHERE class = %s AND created = now()", GetSQLValueString($colname_exams, "int"));
$query_exams = sprintf("SELECT * FROM `exams` WHERE class = %s", GetSQLValueString($colname_exams, "int"));
$exams = mysql_query($query_exams, $conn) or die(mysql_error());
$row_exams = mysql_fetch_assoc($exams);
$totalRows_exams = mysql_num_rows($exams);

$colname_exam = "-1";
if (isset($row_exams)) {
    $now = date("Y-m-d H:i:s");
    $next = $row_exams['created'];
    // $mins = ($next - $now) / 60;
    $mins = mydates($next);

    $exam = $colname_exam = $row_exams['id'];
}

$query_questions = sprintf("SELECT * FROM questions WHERE exam = %s", GetSQLValueString($exam, "int"));
$questions = mysql_query($query_questions, $conn) or die(mysql_error());
$row_questions = mysql_fetch_assoc($questions);
$totalRows_questions = mysql_num_rows($questions);

include '../include/header.php';

$query_result = sprintf("SELECT * FROM `result` WHERE student = %s AND exam = %s", GetSQLValueString($student, "int"), GetSQLValueString($exam, "int"));
$result = mysql_query($query_result, $conn) or die(mysql_error());
$row_result = mysql_fetch_assoc($result);
$totalRows_result = mysql_num_rows($result);

if (!isset($row_result['id']) and ($mins < 30)) {

    if (isset($row_exams['id'])) {
        ?>

<script>
    setTimeout("location.reload(true);",1500);
</script>

<h1>الأمتحان - <?php
echo $row_exams['exam'];
        ?></h1>
<hr />

<form action="save.php" method="post" enctype="multipart/form-data">
<table class="table table-responsive">
  <?php do {
            $query_qus_ans = sprintf("SELECT * FROM qus_ans WHERE question  = %s", GetSQLValueString($row_questions['id'], "int"));
            $qus_ans = mysql_query($query_qus_ans, $conn) or die(mysql_error());
            $row_qus_ans = mysql_fetch_assoc($qus_ans);
            $totalRows_qus_ans = mysql_num_rows($qus_ans);

            ?>
    <tr colspan="4">
    <td class="fs-2"><?php echo $row_questions['question']; ?></td>
    </tr>
    <tr colspan="4">
    <?php do {?>
        <td><?php echo $row_qus_ans['answer']; ?> <input type="radio" name="<?php echo $exam . $row_questions['id']; ?>" value="<?php echo $row_qus_ans['ans_id']; ?>"></td>
    <?php } while ($row_qus_ans = mysql_fetch_assoc($qus_ans));
            ?>
    </tr>
    <?php } while ($row_questions = mysql_fetch_assoc($questions));
        ?>
   <tr colspan="3">
      <td align="center"><input class="btn btn-success" type="submit" value="حفظ" name="sub"></td>
   </tr>
</table>

</form>
<?php

    } else {
        ?>
<table>
    <td>
       لا يوجد إمتحان
    </td>
</table>

    <?php
}
}

include '../include/footer.php';
// mysql_free_result($exam);
?>

