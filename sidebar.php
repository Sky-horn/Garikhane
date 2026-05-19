<div class="sidebar" style="display: flex; flex-direction: column; height: 100vh; background: #0f172a; width: 250px; border-right: 1px solid #1e293b;">
    <div class="logo" style="padding: 25px; color: #38bdf8; font-weight: bold; text-align: center; font-size: 1.5rem;">PRODO</div>
    
    <nav style="flex-grow: 1; padding: 10px 15px;">
        </nav>

    <div style="padding: 20px; border-top: 1px solid #1e293b; display: flex; flex-direction: column; align-items: center;">
        <a href="logout.php" style="color: #ef4444; text-decoration: none; font-weight: bold; font-size: 0.9rem; margin-bottom: 25px;">🚪 Logout</a>

        <div id="sideCircle" style="width: 80px; height: 80px; background: #1e293b; border: 3px solid #38bdf8; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
            <div id="sideDisplay" style="font-size: 1.1rem; font-weight: bold; color: white; font-family: monospace;">25:00</div>
            <button onclick="toggleSideTimer()" id="sideBtn" style="background: #10b981; border: none; color: white; font-size: 0.5rem; padding: 2px 5px; border-radius: 4px; cursor: pointer;">START</button>
            <button onclick="resetSideTimer()" style="position: absolute; bottom: -5px; right: -5px; background: #334155; border: none; color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 0.7rem; cursor: pointer;">↺</button>
        </div>
        <div style="margin-top: 10px; font-size: 0.65rem; color: #64748b;">
            MINS: <input type="number" id="sideInput" value="25" style="width: 25px; background: transparent; border: none; color: #38bdf8; text-align: center; font-weight: bold; outline: none;">
        </div>
    </div>
</div>

<script>
let sideT, sideL, sideA = false;
function toggleSideTimer() {
    const b = document.getElementById('sideBtn');
    if(!sideA){
        sideA = true;
        if(sideL == null) sideL = document.getElementById('sideInput').value * 60;
        sideT = setInterval(() => {
            if(sideL > 0) { sideL--; updateS(); }
            else { clearInterval(sideT); alert("Time is up!"); resetSideTimer(); }
        }, 1000);
        b.innerText = "PAUSE"; b.style.background = "#fbbf24"; b.style.color = "#000";
    } else {
        sideA = false; clearInterval(sideT);
        b.innerText = "RESUME"; b.style.background = "#10b981"; b.style.color = "#fff";
    }
}
function resetSideTimer(){
    clearInterval(sideT); sideA = false; sideL = null;
    document.getElementById('sideDisplay').innerText = document.getElementById('sideInput').value.padStart(2, '0') + ":00";
    document.getElementById('sideBtn').innerText = "START";
    document.getElementById('sideBtn').style.background = "#10b981";
}
function updateS(){
    let m = Math.floor(sideL/60).toString().padStart(2,'0');
    let s = (sideL%60).toString().padStart(2,'0');
    document.getElementById('sideDisplay').innerText = `${m}:${s}`;
}
</script>