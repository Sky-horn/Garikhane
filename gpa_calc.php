<?php
$gpa = null;
if(isset($_POST['calc'])) {
    $pts = 0; $crs = 0;
    foreach($_POST['g'] as $i => $gr) {
        $cr = $_POST['c'][$i];
        $pts += ($gr * $cr); $crs += $cr;
    }
    $gpa = ($crs > 0) ? round($pts / $crs, 2) : 0;
}
?>
<h2 class="section-title">GPA Calculator</h2>
<div class="stats-grid" style="grid-template-columns: 1fr 2fr;">
    <div class="stats-card">
        <h4>Calculate New</h4>
        <form action="" method="POST">
            <label style="display:block; margin-bottom: 5px; font-size: 0.8rem; color: #94a3b8;">Grade (0.0 - 4.0)</label>
            <input type="number" step="0.1" name="grade" placeholder="4.0" 
                   style="width: 100%; background: #0f172a; border: 1px solid #334155; color: white; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
            
            <label style="display:block; margin-bottom: 5px; font-size: 0.8rem; color: #94a3b8;">Credits</label>
            <input type="number" name="credits" placeholder="3" 
                   style="width: 100%; background: #0f172a; border: 1px solid #334155; color: white; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
            
            <button type="submit" class="btn-add" style="width: 100%;">➕ Add Course</button>
        </form>
    </div>

    <div class="stats-card" style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
        <h4 style="color: #94a3b8;">Estimated Semester GPA</h4>
        <div class="stat-value" style="font-size: 4rem;">3.85</div>
        <span class="badge badge-good">Academic Excellence</span>
    </div>
</div>