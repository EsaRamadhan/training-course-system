<?php
require_once(__DIR__ . '/../layout/header.php');

$id = $_GET['id'];

// 🔥 hapus payment dulu (biar gak error foreign key)
$conn->query("DELETE FROM payments WHERE enrollment_id = $id");

// baru hapus enrollment
$conn->query("DELETE FROM enrollment WHERE enrollment_id = $id");

header("Location: list.php");
exit();