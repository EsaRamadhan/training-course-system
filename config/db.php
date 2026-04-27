<?php
$conn = new mysqli("localhost", "root", "", "language_course_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>