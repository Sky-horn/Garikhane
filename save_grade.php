<?php
include 'includes/db_connect.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $course = mysqli_real_escape_string($conn, $_POST['course_name']);
    $credits = intval($_POST['credits']);
    $grade = floatval($_POST['grade_point']);
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO grades (user_id, course_name, credits, grade_point) VALUES ('$user_id', '$course', '$credits', '$grade')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?page=gpa");
        exit();
    }
}
?>