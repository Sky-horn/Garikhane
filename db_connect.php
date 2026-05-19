<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_suite";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// CRITICAL: Syncs PHP and MySQL to Nepal time so "Today" matches
date_default_timezone_set('Asia/Kathmandu'); 
mysqli_query($conn, "SET time_zone = '+05:45'");
?>