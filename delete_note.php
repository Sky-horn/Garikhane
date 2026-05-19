<?php
include 'includes/db_connect.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $note_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Security check: Only delete if the note belongs to the user
    $query = "DELETE FROM notes WHERE id = $note_id AND user_id = $user_id";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?page=notes");
        exit();
    }
}
?>