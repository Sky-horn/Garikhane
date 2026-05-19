<?php
include 'includes/db_connect.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_id'])) {
    $task_id = intval($_POST['task_id']);
    // Trim and lowercase to prevent any "Active " vs "active" mismatch
    $new_status = strtolower(trim($_POST['new_status'])); 
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE tasks SET status = '$new_status' WHERE id = $task_id AND user_id = $user_id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?page=kanban");
        exit();
    } else {
        die("Database Error: " . mysqli_error($conn));
    }
}
?>