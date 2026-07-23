<?php
session_start();

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "kalro"
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
