<?php
include_once 'includes/db_connect.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$u_id = $_SESSION['user_id'];

// Default empty values
$view_title = "";
$view_content = "";

// Check if a specific note was clicked
if (isset($_GET['note_id'])) {
    $note_id = intval($_GET['note_id']);
    $res = mysqli_query($conn, "SELECT * FROM notes WHERE id = $note_id AND user_id = $u_id");
    if ($note = mysqli_fetch_assoc($res)) {
        $view_title = $note['title'];
        $view_content = $note['content'];
    }
}

$notes_query = mysqli_query($conn, "SELECT * FROM notes WHERE user_id = $u_id ORDER BY created_at DESC");
?>

<h2 class="section-title">Study Notes</h2>
<div class="stats-grid" style="grid-template-columns: 1fr 2fr; gap: 20px;">
    
    <div class="stats-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h4>My Library</h4>
            <a href="index.php?page=notes" style="text-decoration:none; font-size:0.8rem; color:#38bdf8;">+ New Note</a>
        </div>
        <ul style="list-style:none; padding:0; margin-top:15px;">
            <?php while($n = mysqli_fetch_assoc($notes_query)): ?>
                <li style="padding:10px; border-bottom:1px solid #334155;">
                    <a href="index.php?page=notes&note_id=<?php echo $n['id']; ?>" 
                       style="text-decoration:none; color: <?php echo ($view_title == $n['title']) ? '#38bdf8' : '#94a3b8'; ?>;">
                        📔 <?php echo htmlspecialchars($n['title']); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <div class="stats-card">
        <form action="save_note.php" method="POST">
            <input type="text" name="title" value="<?php echo htmlspecialchars($view_title); ?>" placeholder="Note Title..." required 
                   style="width:100%; background:#0f172a; border:1px solid #334155; color:white; padding:12px; border-radius:8px; margin-bottom:15px;">
            
            <textarea name="content" rows="15" placeholder="Write or view your notes here..." required
                      style="width:100%; background:#0f172a; border:1px solid #334155; color:white; padding:12px; border-radius:8px; font-family:serif; line-height:1.6; resize:none;"><?php echo htmlspecialchars($view_content); ?></textarea>
            
            <button type="submit" class="btn-add" style="width:100%; margin-top:15px;">💾 Save / Update Note</button>
        </form>
    </div>
</div>
<ul style="list-style:none; padding:0; margin-top:15px;">
    <?php while($n = mysqli_fetch_assoc($notes_query)): ?>
        <li style="padding:10px; border-bottom:1px solid #334155; display: flex; justify-content: space-between; align-items: center;">
            <a href="index.php?page=notes&note_id=<?php echo $n['id']; ?>" 
               style="text-decoration:none; color: <?php echo ($view_title == $n['title']) ? '#38bdf8' : '#94a3b8'; ?>; flex-grow: 1;">
                📔 <?php echo htmlspecialchars($n['title']); ?>
            </a>
            
            <a href="delete_note.php?id=<?php echo $n['id']; ?>" 
               onclick="return confirm('Delete this note?');"
               style="color: #ef4444; text-decoration: none; font-weight: bold; padding-left: 10px;">×</a>
        </li>
    <?php endwhile; ?>
</ul>