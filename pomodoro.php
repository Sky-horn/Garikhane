<div class="timer-card" style="background: #1e293b; padding: 40px; border-radius: 24px; text-align: center; max-width: 450px; margin: 40px auto; border: 1px solid #334155; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
    <h3 style="color: #38bdf8; display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 25px;">
        ⏱️ Pomodoro Focus
    </h3>

    <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 10px;">Set Focus Minutes:</p>
    
    <input type="number" id="minutesInput" value="25" min="1" max="60" 
           style="background: #0f172a; border: 2px solid #38bdf8; color: white; padding: 12px; border-radius: 12px; text-align: center; width: 100px; font-size: 1.5rem; font-weight: bold; outline: none; margin-bottom: 20px;">

    <div id="timerDisplay" style="font-size: 6rem; font-weight: bold; color: white; font-family: 'Courier New', monospace; margin-bottom: 30px; letter-spacing: -2px;">25:00</div>

    <div style="display: flex; gap: 15px; justify-content: center;">
        <button onclick="startTimer()" id="startBtn" style="background: #10b981; color: white; border: none; padding: 14px 35px; border-radius: 12px; font-weight: bold; font-size: 1rem; cursor: pointer; transition: 0.3s; flex: 1;">START</button>
        
        <button onclick="pauseTimer()" id="pauseBtn" style="background: #fbbf24; color: #0f172a; border: none; padding: 14px 35px; border-radius: 12px; font-weight: bold; font-size: 1rem; cursor: pointer; display: none; flex: 1;">PAUSE</button>
        
        <button onclick="resetTimer()" style="background: #475569; color: white; border: none; padding: 14px 35px; border-radius: 12px; font-weight: bold; font-size: 1rem; cursor: pointer; transition: 0.3s; flex: 1;">RESET</button>
    </div>
</div>

<script>
let countdown;
let timeLeft;
let isPaused = true;

function startTimer() {
    if (!isPaused) return; 
    
    isPaused = false;
    // UI Swap: Hide Start, show Pause
    document.getElementById('startBtn').style.display = 'none';
    document.getElementById('pauseBtn').style.display = 'inline-block';

    if (timeLeft === undefined || timeLeft === null) {
        timeLeft = document.getElementById('minutesInput').value * 60;
    }

    countdown = setInterval(() => {
        if (timeLeft > 0) {
            timeLeft--;
            updateDisplay();
        } else {
            clearInterval(countdown);
            alert("Focus session complete!");
            resetTimer();
        }
    }, 1000);
}

function pauseTimer() {
    isPaused = true;
    clearInterval(countdown); // Stop the interval but keep timeLeft
    document.getElementById('pauseBtn').style.display = 'none';
    document.getElementById('startBtn').style.display = 'inline-block';
    document.getElementById('startBtn').innerText = 'RESUME';
}

function resetTimer() {
    clearInterval(countdown);
    isPaused = true;
    timeLeft = null;
    let originalMins = document.getElementById('minutesInput').value;
    document.getElementById('timerDisplay').innerText = originalMins.padStart(2, '0') + ":00";
    
    // Reset buttons to original state
    document.getElementById('startBtn').style.display = 'inline-block';
    document.getElementById('startBtn').innerText = 'START';
    document.getElementById('pauseBtn').style.display = 'none';
}

function updateDisplay() {
    const m = Math.floor(timeLeft / 60).toString().padStart(2, '0');
    const s = (timeLeft % 60).toString().padStart(2, '0');
    document.getElementById('timerDisplay').innerText = `${m}:${s}`;
}
</script>