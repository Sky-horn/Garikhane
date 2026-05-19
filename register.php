<?php
ob_start(); // Prevents "Headers already sent" errors
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Fix the path to your database connection
include 'includes/db_connect.php'; 

$error = ""; 

if (isset($_POST['register'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    
    // Check if username exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
    
    if (mysqli_num_rows($check) > 0) {
        $error = "Username already taken!";
    } else {
        // Define SQL string
        $sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
        
        if (mysqli_query($conn, $sql)) {
            // Set session data
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            $_SESSION['username'] = $user;

            // Redirect to dashboard_summary.php
            header("Location: login.php"); 
            exit(); 
        } else {
            $error = "System error. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Prodo</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --onyx: #0a0c10;
            --glass: #161b22;
            --cyan: #00f2ff;
            --border: #30363d;
        }

        body {
            margin: 0; background: var(--onyx); color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex; justify-content: center; align-items: center; height: 100vh;
        }

        .auth-card {
            background: var(--glass); padding: 40px; border-radius: 4px;
            border: 1px solid var(--border); width: 100%; max-width: 400px;
            position: relative; box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }

        .auth-card::before {
            content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: var(--cyan);
        }

        h2 { color: var(--cyan); text-transform: uppercase; letter-spacing: 2px; text-align: center; margin-bottom: 30px; }

        input {
            width: 100%; padding: 14px; margin-bottom: 20px;
            background: #0d1117; border: 1px solid var(--border);
            border-radius: 4px; color: white; box-sizing: border-box; outline: none;
        }

        button {
            width: 100%; padding: 16px; background: var(--cyan); color: var(--onyx);
            border: none; border-radius: 4px; font-weight: 800; text-transform: uppercase; cursor: pointer;
        }

        .error { color: #ff7b72; text-align: center; margin-bottom: 15px; font-size: 0.9rem; }
    </style>
</head>
<body class="auth-wrapper">
    <div class="auth-card">
        <h2>Join Prodo</h2>
        
        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Choose Username" required>
            <input type="password" name="password" placeholder="Create Password" required>
            <button type="submit" name="register">Create Account</button>
        </form>
        
        <div style="margin-top: 20px; text-align: center;">
            <a href="login.php" style="color: #8b949e; text-decoration: none; font-size: 0.8rem;">
                Already have an account? <span style="color: #00f2ff;">Login</span>
            </a>
        </div>
    </div>
</body>
</html>