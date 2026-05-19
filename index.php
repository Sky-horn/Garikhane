<?php
ob_start(); 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

include 'includes/db_connect.php'; 
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard_summary';

// Master Progress Calculation
$t_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM tasks WHERE user_id = $user_id");
$d_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM tasks WHERE user_id = $user_id AND status = 'done'");
$total = mysqli_fetch_assoc($t_res)['total'];
$done = mysqli_fetch_assoc($d_res)['total'];
$perc = ($total > 0) ? round(($done / $total) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PRODO | Workspace</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <nav class="sidebar">
            <div class="logo">PRODO</div>
            <div class="user-tag">👤 <?php echo $username; ?></div>
        <ul class="nav-links">
    <li><a href="index.php?page=dashboard_summary">🏠 Dashboard Home</a></li>
    <li><a href="index.php?page=scheduler">📅 Daily Scheduler</a></li>
    <li><a href="index.php?page=kanban">📋 Kanban Board</a></li>
    <li><a href="index.php?page=pomodoro">⏱️ Focus Timer</a></li>
    <li><a href="index.php?page=notes">📝 Study Notes</a></li>
    <li><a href="index.php?page=gpa_calc">📊 GPA Tracker</a></li>
    
    <li style="margin-top: 20px; border-top: 1px solid #334155; padding-top: 20px;">
        <a href="logout.php" style="color: #ef4444 !important;">🚪 Logout</a>
    </li>
</ul>
        </nav>

        <main class="main-content">
            <div class="stats-card progress-section">
                <h4>Overall Task Completion: <?php echo $perc; ?>%</h4>
                <div class="progress-container">
                    <div class="progress-bar" style="width: <?php echo $perc; ?>%"></div>
                </div>
                <small><?php echo $done; ?> of <?php echo $total; ?> tasks finished.</small>
            </div>

            <div class="tool-view">
                <?php 
                    $file = $page . ".php";
                    if (file_exists($file)) { include($file); } 
                    else { include('dashboard_summary.php'); }
                ?>
            </div>
        </main>
    </div>
</body>
</html>