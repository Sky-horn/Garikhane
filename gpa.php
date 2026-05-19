<?php
include_once 'includes/db_connect.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$u_id = $_SESSION['user_id'];

// Fetch all grades for the user
$grades_query = mysqli_query($conn, "SELECT * FROM grades WHERE user_id = $u_id");

$total_points = 0;
$total_credits = 0;
?>

<h2 class="section-title">Academic GPA Tracker</h2>

<div class="stats-grid" style="grid-template-columns: 1fr 2fr; gap: 20px;">
    <div class="stats-card">
        <h4>Add New Course</h4>
        <form action="save_grade.php" method="POST" style="margin-top:15px;">
            <input type="text" name="course_name" placeholder="Course Name" required 
                   style="width:100%; background:#0f172a; border:1px solid #334155; color:white; padding:10px; border-radius:8px; margin-bottom:10px;">
            <input type="number" name="credits" placeholder="Credits (e.g. 3)" required 
                   style="width:100%; background:#0f172a; border:1px solid #334155; color:white; padding:10px; border-radius:8px; margin-bottom:10px;">
            <select name="grade_point" required style="width:100%; background:#0f172a; border:1px solid #334155; color:white; padding:10px; border-radius:8px; margin-bottom:10px;">
                <option value="4.0">A (4.0)</option>
                <option value="3.7">A- (3.7)</option>
                <option value="3.3">B+ (3.3)</option>
                <option value="3.0">B (3.0)</option>
                <option value="2.7">B- (2.7)</option>
                <option value="2.0">C (2.0)</option>
            </select>
            <button type="submit" class="btn-add" style="width:100%;">➕ Add Course</button>
        </form>
    </div>

    <div class="stats-card">
        <h4>Semester Overview</h4>
        <table style="width:100%; margin-top:15px; border-collapse: collapse; color: #94a3b8;">
            <tr style="border-bottom: 2px solid #334155; text-align: left;">
                <th style="padding:10px;">Course</th>
                <th style="padding:10px;">Credits</th>
                <th style="padding:10px;">Grade</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($grades_query)): 
                $total_points += ($row['grade_point'] * $row['credits']);
                $total_credits += $row['credits'];
            ?>
            <tr style="border-bottom: 1px solid #1e293b;">
                <td style="padding:10px;"><?php echo htmlspecialchars($row['course_name']); ?></td>
                <td style="padding:10px;"><?php echo $row['credits']; ?></td>
                <td style="padding:10px; color:#38bdf8;"><?php echo $row['grade_point']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <div style="margin-top:20px; text-align:right;">
            <h3 style="color:white;">Current GPA: 
                <span style="color:#10b981;">
                    <?php echo ($total_credits > 0) ? round($total_points / $total_credits, 2) : "0.00"; ?>
                </span>
            </h3>
        </div>
    </div>
</div>