<?php
session_start();

// if (!isset($_SESSION['user'])) {
//     header('Location: /school/');
// }

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conn = "localhost";
$database_conn = "school";
$username_conn = "root";
$password_conn = "root1234";
$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_conn, $conn);

function mydates($date = null, $diff = "minutes") {
    $start_date = new DateTime($date);
    $since_start = $start_date->diff(new DateTime( date('Y-m-d H:i:s') )); // date now
    // print_r($since_start);
    switch ($diff) {
       case 'seconds':
           return $since_start->s;
           break;
       case 'minutes':
           return $since_start->i;
           break;
       case 'hours':
           return $since_start->h;
           break;
       case 'days':
           return $since_start->d;
           break;      
       default:
           # code...
           break;
    }
   }

?>