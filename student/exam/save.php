<?php require_once '../../Connections/conn.php';

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

if (isset($_POST['sub'])) {

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
        $exam = $colname_exam = $row_exams['id'];
    }

    if (isset($exam)) {
        $colname_questions = $exam;
    }

    $query_questions = sprintf("SELECT * FROM questions WHERE exam = %s", GetSQLValueString($colname_questions, "int"));
    $questions = mysql_query($query_questions, $conn) or die(mysql_error());
    $row_questions = mysql_fetch_assoc($questions);
    $totalRows_questions = mysql_num_rows($questions);

    // HERE COME THE REAL WORK ...
    do {
        $query_qus_ans = sprintf("SELECT * FROM qus_ans WHERE question  = %s", GetSQLValueString($row_questions['id'], "int"));
        $qus_ans = mysql_query($query_qus_ans, $conn) or die(mysql_error());
        $row_qus_ans = mysql_fetch_assoc($qus_ans);
        $totalRows_qus_ans = mysql_num_rows($qus_ans);

        echo $row_questions['question'] . '<br/>';
        echo $exam . $row_questions['id'] . '<br/>';

        echo $_POST[$exam . $row_questions['id']];

        //  RESULT LOGIC ...
        if ($_POST[$exam . $row_questions['id']] == $row_questions['answer']) {
            $total_marks += $row_questions['degree'];
        }
    } while ($row_questions = mysql_fetch_assoc($questions));

    // SEE RESULT ...
    // echo '<br/>'.$total_marks;

    $insertSQL = sprintf("INSERT INTO `result` (student, `class`, exam, mark) VALUES (%s, %s, %s, %s)",
        GetSQLValueString($student, "int"),
        GetSQLValueString($class, "int"),
        GetSQLValueString($exam, "int"),
        GetSQLValueString($total_marks, "int"));

    mysql_select_db($database_conn, $conn);
    $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

    $insertGoTo = "../index.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));

} else {
    echo 'Not valid answers ... ';
}
