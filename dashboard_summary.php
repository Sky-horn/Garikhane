<?php
include_once 'includes/db_connect.php';

// Fixes the warnings for $u_id and $today
$u_id  = $_SESSION['user_id'] ?? 0;
$today = date('Y-m-d');

// Fetch Task Stats
$task_query = "SELECT COUNT(*) as total,
               SUM(CASE WHEN status = 'done' THEN 1 ELSE 0 END) as completed
               FROM tasks WHERE user_id = $u_id AND DATE(due_date) = '$today'";
$task_res        = mysqli_query($conn, $task_query);
$task_data       = mysqli_fetch_assoc($task_res);
$total_tasks     = $task_data['total']     ?? 0;
$completed_tasks = $task_data['completed'] ?? 0;
$percent         = ($total_tasks > 0) ? round(($completed_tasks / $total_tasks) * 100) : 0;

// Fetch GPA
$gpa_query   = "SELECT SUM(grade_point * credits) / SUM(credits) as current_gpa FROM grades WHERE user_id = $u_id";
$gpa_res     = mysqli_query($conn, $gpa_query);
$gpa_data    = mysqli_fetch_assoc($gpa_res);
$current_gpa = number_format($gpa_data['current_gpa'] ?? 0.00, 2);
?>

<div class="dashboard-wrapper" style="padding: 20px; color: white;">

    <div class="header-content" style="margin-bottom: 25px;">
        <h1 style="font-size: 2.2rem; margin: 0;">Good Day, <?php echo htmlspecialchars($_SESSION['username']); ?>! 🎓</h1>
        <p style="color: #94a3b8; margin-top: 5px;">Here is your academic overview for today.</p>
    </div>

    <div class="flex-row" style="display: flex; gap: 20px; margin-bottom: 25px;">

        <div style="flex: 1; background: #1e293b; padding: 40px 20px; border-radius: 12px; border: 1px solid #334155; text-align: center; border-top: 4px solid #10b981;">
            <p style="color: #94a3b8; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Academic GPA</p>
            <h2 style="font-size: 5rem; color: #10b981; margin: 10px 0; font-weight: bold;"><?php echo $current_gpa; ?></h2>
            <a href="index.php?page=gpa" style="color: #38bdf8; text-decoration: none; font-size: 0.9rem;">Manage Grades →</a>
        </div>

        <div style="flex: 1; background: #1e293b; padding: 40px 20px; border-radius: 12px; border: 1px solid #334155; text-align: center; border-top: 4px solid #38bdf8;">
            <p style="color: #94a3b8; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Tasks Completed</p>
            <h2 style="font-size: 5rem; color: #38bdf8; margin: 10px 0; font-weight: bold;"><?php echo $percent; ?>%</h2>
            <div style="width: 80%; background: #0f172a; height: 10px; border-radius: 10px; margin: 0 auto 10px;">
                <div style="width: <?php echo $percent; ?>%; background: #38bdf8; height: 100%; border-radius: 10px;"></div>
            </div>
            <p style="color: #64748b; font-size: 0.85rem;"><?php echo $completed_tasks; ?> of <?php echo $total_tasks; ?> tasks finished</p>
        </div>
    </div>

    <div class="quick-add-section" style="background: #1e293b; padding: 30px; border-radius: 12px; border: 1px solid #334155;">
        <h4 style="color: white; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">⚡ Quick Add Task</h4>

        <!--
            FIX 1: action now points to "includes/add_task.php" (relative to root, where index.php lives).
            FIX 2: A hidden "redirect_to" field tells add_task.php to return to the dashboard after saving.
        -->
        <form action="includes/add_task.php" method="POST" style="display: flex; gap: 15px;">
            <input type="hidden" name="redirect_to" value="index.php?page=dashboard_summary">
            <input type="text" name="task_name" placeholder="What's the next goal?" required
                   style="flex: 3; background: #0f172a; border: 1px solid #334155; color: white; padding: 15px; border-radius: 8px; outline: none;">
            <input type="date" name="due_date" value="<?php echo $today; ?>"
                   style="flex: 1; background: #0f172a; border: 1px solid #334155; color: white; padding: 15px; border-radius: 8px;">
            <button type="submit" style="flex: 1; background: #38bdf8; color: #0f172a; border: none; font-weight: bold; border-radius: 8px; cursor: pointer; font-size: 1rem;">Add Task</button>
        </form>
    </div>
</div>
