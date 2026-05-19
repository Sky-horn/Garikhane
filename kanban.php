<?php
include_once 'includes/db_connect.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$u_id = $_SESSION['user_id'];

function renderTasks($conn, $u_id, $status) {
    $query  = "SELECT * FROM tasks WHERE user_id = $u_id AND status = '$status' ORDER BY due_date ASC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($task = mysqli_fetch_assoc($result)) {
            echo '<div class="stats-card" style="margin-bottom: 12px; padding: 15px; border: 1px solid #334155; background: #1e293b;">';
                echo '<div style="margin-bottom: 10px; font-weight: 600;">' . htmlspecialchars($task['task_name']) . '</div>';

                echo '<div style="display: flex; justify-content: space-between; align-items: center;">';
                    if (!empty($task['due_date'])) {
                        echo '<small style="color: #94a3b8;">📅 ' . date('M d', strtotime($task['due_date'])) . '</small>';
                    } else {
                        echo '<span></span>';
                    }

                    echo '<div style="display: flex; gap: 10px; align-items: center;">';
                        // Delete button
                        echo '<form action="delete_task.php" method="POST" onsubmit="return confirm(\'Delete this task?\');" style="margin:0;">';
                            echo '<input type="hidden" name="task_id" value="' . $task['id'] . '">';
                            echo '<button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; font-size:1rem; padding:0;">🗑️</button>';
                        echo '</form>';

                        // Move-status button
                        echo '<form action="update_status.php" method="POST" style="margin:0;">';
                            echo '<input type="hidden" name="task_id" value="' . $task['id'] . '">';
                            if ($status == 'todo') {
                                echo '<button type="submit" name="new_status" value="active" class="btn-add" style="padding: 5px 10px; font-size: 0.7rem; background: #fbbf24 !important; color: #0f172a !important;">Start ⚡</button>';
                            } elseif ($status == 'active') {
                                echo '<button type="submit" name="new_status" value="done" class="btn-add" style="padding: 5px 10px; font-size: 0.7rem; background: #10b981 !important;">Finish ✅</button>';
                            }
                        echo '</form>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p style="color: #475569; font-size: 0.8rem; text-align: center; padding: 10px;">No tasks found.</p>';
    }
}
?>

<h2 class="section-title">Kanban Board</h2>

<!-- ✅ FIX: Quick-add form that redirects back to the Kanban board after saving -->
<div style="background: #1e293b; padding: 20px; border-radius: 12px; border: 1px solid #334155; margin-bottom: 25px;">
    <h4 style="color: white; margin: 0 0 15px; display: flex; align-items: center; gap: 8px;">⚡ Add Task to Board</h4>
    <form action="includes/add_task.php" method="POST" style="display: flex; gap: 12px; flex-wrap: wrap;">
        <input type="hidden" name="redirect_to" value="index.php?page=kanban">
        <input type="text" name="task_name" placeholder="New task name..." required
               style="flex: 3; min-width: 200px; background: #0f172a; border: 1px solid #334155; color: white; padding: 12px; border-radius: 8px; outline: none;">
        <input type="date" name="due_date" value="<?php echo date('Y-m-d'); ?>"
               style="flex: 1; min-width: 140px; background: #0f172a; border: 1px solid #334155; color: white; padding: 12px; border-radius: 8px;">
        <button type="submit"
                style="flex: 1; min-width: 120px; background: #38bdf8; color: #0f172a; border: none; font-weight: bold; border-radius: 8px; cursor: pointer; font-size: 1rem; padding: 12px;">
            Add Task
        </button>
    </form>
</div>

<div class="kanban-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; align-items: start;">

    <div class="kanban-col" style="background: rgba(30, 41, 59, 0.5); padding: 20px; border-radius: 12px; border-top: 4px solid #38bdf8; min-height: 300px;">
        <h3 style="color: #38bdf8; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
            <span>📝</span> To-Do
        </h3>
        <?php renderTasks($conn, $u_id, 'todo'); ?>
    </div>

    <div class="kanban-col" style="background: rgba(30, 41, 59, 0.5); padding: 20px; border-radius: 12px; border-top: 4px solid #fbbf24; min-height: 300px;">
        <h3 style="color: #fbbf24; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
            <span>⚡</span> Active
        </h3>
        <?php renderTasks($conn, $u_id, 'active'); ?>
    </div>

    <div class="kanban-col" style="background: rgba(30, 41, 59, 0.5); padding: 20px; border-radius: 12px; border-top: 4px solid #10b981; min-height: 300px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="color: #10b981; margin: 0; display: flex; align-items: center; gap: 8px;">
                <span>✅</span> Done
            </h3>
            <form action="clear_tasks.php" method="POST" onsubmit="return confirm('Permanently delete all completed tasks?');">
                <button type="submit" class="badge-warn"
                        style="border: none; cursor: pointer; font-size: 0.7rem; padding: 5px 10px; border-radius: 4px; background: #ef4444; color: white;">
                    Clear All
                </button>
            </form>
        </div>
        <?php renderTasks($conn, $u_id, 'done'); ?>
    </div>

</div>
