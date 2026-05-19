<?php
include 'includes/db_connect.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Only proceed if a POST request is made (security best practice)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // This removes ONLY the tasks that are finished
    $query = "DELETE FROM tasks WHERE user_id = $user_id AND status = 'done'";
    
    if (mysqli_query($conn, $query)) {
        // Go back to the Kanban board after deleting
        header("Location: index.php?page=kanban");
        exit();
    } else {
        echo "Error deleting tasks: " . mysqli_error($conn);
    }
} else {
    // If someone tries to access this file directly, send them back
    header("Location: index.php?page=kanban");
    exit();
}
?>