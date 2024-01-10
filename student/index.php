<?php
// Start the session
session_start();

if ($_SESSION['user']['type'] == 'admin') {
    header('Location: ../admin/');
} elseif ($_SESSION['user']['type'] == 'teacher') {
    header('Location: ../teacher/');
} elseif ($_SESSION['user']['type'] == 'student') {
    header('Location: books/');
} else {
    header('Location: ../');
}

?>
