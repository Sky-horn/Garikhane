<?php
include 'includes/db_connect.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_id'])) {
    $task_id = intval($_POST['task_id']);
    $user_id = $_SESSION['user_id'];

    $query = "DELETE FROM tasks WHERE id = $task_id AND user_id = $user_id";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?page=kanban");
        exit();
    }
}
?>