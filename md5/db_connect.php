<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "wst_session";

$conn = mysqli_connect(
    $host,
    $username,
    $password,
    $database
);

if (!$conn) {
    die("Database connection failed.");
}
?>
