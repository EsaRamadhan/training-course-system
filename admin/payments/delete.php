<?php
include('../layout/header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn->query("DELETE FROM payments WHERE payment_id = $id");

    header("Location: list.php");
}
?>