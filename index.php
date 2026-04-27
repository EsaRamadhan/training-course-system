<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// redirect berdasarkan role
if ($_SESSION['user']['role'] == 'admin') {
    header("Location: admin/dashboard.php");
} else {
    header("Location: user/dashboard.php");
}
?>