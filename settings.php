<?php
include_once 'includes/db_connect.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$u_id = $_SESSION['user_id'];

// Fetch user info
$user_res = mysqli_query($conn, "SELECT username, email, created_at FROM users WHERE id = $u_id");
$user_data = mysqli_fetch_assoc($user_res);
?>

<h2 class="section-title">User Settings</h2>

<div class="stats-grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
    <div class="stats-card">
        <h4 style="margin-bottom: 20px; color: #38bdf8;">👤 Profile Information</h4>
        <div style="margin-bottom: 15px;">
            <label style="display:block; color:#64748b; font-size:0.8rem;">Username</label>
            <p style="font-size:1.1rem; color:white;"><?php echo htmlspecialchars($user_data['username']); ?></p>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display:block; color:#64748b; font-size:0.8rem;">Email Address</label>
            <p style="font-size:1.1rem; color:white;"><?php echo htmlspecialchars($user_data['email'] ?? 'Not set'); ?></p>
        </div>
        <div>
            <label style="display:block; color:#64748b; font-size:0.8rem;">Member Since</label>
            <p style="font-size:1.1rem; color:white;"><?php echo date('M Y', strtotime($user_data['created_at'])); ?></p>
        </div>
    </div>

    <div class="stats-card">
        <h4 style="margin-bottom: 20px; color: #fbbf24;">⚙️ App Preferences</h4>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
            <span>Dark Mode</span>
            <span style="color:#10b981;">Always On</span>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
            <span>GPA Scale</span>
            <span style="color:#38bdf8;">4.0 Scale</span>
        </div>
        <button class="btn-add" style="width:100%; background:#ef4444 !important;" onclick="window.location.href='logout.php'">Logout Session</button>
    </div>
</div>