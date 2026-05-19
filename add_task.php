<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Since this file lives inside includes/, db_connect.php is right beside it
include __DIR__ . '/db_connect.php';

// Basic Session Check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../register.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_name'])) {
    
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $user_id = $_SESSION['user_id'];
    $due_date = !empty($_POST['due_date']) ? mysqli_real_escape_string($conn, $_POST['due_date']) : date('Y-m-d H:i:s');

    // Matches the 'todo' requirement for your Kanban board
    $query = "INSERT INTO tasks (user_id, task_name, status, due_date) 
              VALUES ('$user_id', '$task_name', 'todo', '$due_date')";
    
    if (mysqli_query($conn, $query)) {
        // Uses redirect_to if sent by the form, otherwise defaults to dashboard
        header("Location: ../index.php?page=" . (isset($_POST['redirect_to']) ? $_POST['redirect_to'] : 'dashboard_summary'));
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>
