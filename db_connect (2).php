<?php
include_once 'db_connect.php';
session_start();

if (isset($_POST['task_id']) && isset($_POST['new_status'])) {
    $task_id = mysqli_real_escape_string($conn, $_POST['task_id']);
    // We map whatever your Kanban sends to 'done' for the dashboard logic
    $raw_status = $_POST['new_status'];
    $status = ($raw_status === 'finished' || $raw_status === 'done') ? 'done' : 'pending';
    
    $u_id = $_SESSION['user_id'];

    $sql = "UPDATE tasks SET status = '$status' WHERE id = '$task_id' AND user_id = '$u_id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>