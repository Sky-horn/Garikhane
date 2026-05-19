<?php
include_once 'includes/db_connect.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$u_id = $_SESSION['user_id'];

// Fetches tasks scheduled for the current calendar day
$query = "SELECT * FROM tasks 
          WHERE user_id = $u_id 
          AND DATE(due_date) = CURDATE() 
          AND status != 'done' 
          ORDER BY due_date ASC";

$result = mysqli_query($conn, $query);
?>

<div class="stats-card">
    <h4 style="margin-bottom: 15px;">📅 Today's Schedule</h4>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($t = mysqli_fetch_assoc($result)): ?>
            <div style="padding: 10px; background: #0f172a; border-radius: 8px; margin-bottom: 8px; border-left: 3px solid #38bdf8; display: flex; justify-content: space-between;">
                <span><?php echo htmlspecialchars($t['task_name']); ?></span>
                <small style="color: #64748b;"><?php echo date('h:i A', strtotime($t['due_date'])); ?></small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="color: #64748b; font-size: 0.8rem; text-align: center;">No tasks for today!</p>
    <?php endif; ?>
</div>