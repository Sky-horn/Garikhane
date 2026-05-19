<?php
include 'includes/db_connect.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $user_id = $_SESSION['user_id'];

    // Check if this note already exists for this user
    $check = mysqli_query($conn, "SELECT id FROM notes WHERE title = '$title' AND user_id = $user_id");
    
    if (mysqli_num_rows($check) > 0) {
        // UPDATE existing note
        $query = "UPDATE notes SET content = '$content' WHERE title = '$title' AND user_id = $user_id";
    } else {
        // INSERT new note
        $query = "INSERT INTO notes (user_id, title, content) VALUES ('$user_id', '$title', '$content')";
    }
    
    mysqli_query($conn, $query);
    header("Location: index.php?page=notes");
    exit();
}
?>