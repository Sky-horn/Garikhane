<?php
session_start();
include 'includes/db_connect.php';

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];
    
    $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
    $data = mysqli_fetch_array($res);

    if ($data && password_verify($pass, $data['password'])) {
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Prodo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-wrapper">
    <div class="auth-card">
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Sign In</button>
        </form>
        <a href="register.php">New here? Create an account</a>
    </div>
</body>
</body>
</html>