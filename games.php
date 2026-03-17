<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brain Games – AptCode</title>
  <link rel="stylesheet" href="css/main.css">
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar" id="navbar">
  <div class="nav-inner">
    <a class="logo" href="index.php"><span class="logo-apt">Apt</span><span class="logo-code">Code</span></a>
    <ul class="nav-links">
      <li><a href="aptitude.php">Aptitude</a></li>
      <li><a href="coding.php">Coding</a></li>
      <li><a href="games.php" class="active">Games</a></li>
      <li><a href="daily.php">Daily</a></li>
      <li><a href="leaderboard.php">Leaderboard</a></li>
    </ul>
    <div class="nav-auth">
      <?php if($isLoggedIn): ?>
        <a href="dashboard.php" class="btn btn-ghost">Dashboard</a>
        <a href="php/logout.php" class="btn btn-outline">Logout</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-ghost">Login</a>
        <a href="register.php" class="btn btn-primary">Sign Up</a>
      <?php endif; ?>
    </div>
    <button class="hamburger" id="hamburger"><span></span><span></span><span></span></button>
  </div>
</nav>

<section class="page-hero">
  <div class="container">
    <div class="section-tag">Interactive Learning</div>
    <h1>🎮 Brain Games</h1>
    <p>Sharpen your memory, logic, and problem-solving skills with interactive mini-games. Each game earns XP!</p>
  </div>
</section>

<section class="page-content">
  <div class="container">
    <div class="games-grid">
      <!-- Memory Match -->
      <div class="game-card">
        <div class="game-icon">🃏</div>
        <h3>Memory Match</h3>
        <p>Find matching emoji pairs. Tests short-term memory and concentration. Beat it in minimum flips!</p>
        <div style="font-family:var(--font-mono);font-size:0.78rem;color:var(--c-yellow);margin-bottom:12px">+30 XP on win</div>
        <button class="btn btn-primary" onclick="openGame('memory')">Play Now</button>
      </div>

      <!-- Sliding Puzzle -->
      <div class="game-card">
        <div class="game-icon">🔢</div>
        <h3>Number Puzzle</h3>
        <p>Arrange tiles 1-8 in order using the empty space. Classic 8-puzzle that trains spatial reasoning.</p>
        <div style="font-family:var(--font-mono);font-size:0.78rem;color:var(--c-yellow);margin-bottom:12px">+25 XP on solve</div>
        <button class="btn btn-primary" onclick="openGame('puzzle')">Play Now</button>
      </div>

      <!-- Speed Typing -->
      <div class="game-card">
        <div class="game-icon">⌨️</div>
        <h3>Speed Typing</h3>
        <p>Type code snippets as fast as you can! Improves typing speed and familiarity with syntax.</p>
        <div style="font-family:var(--font-mono);font-size:0.78rem;color:var(--c-yellow);margin-bottom:12px">+20 XP per round</div>
        <button class="btn btn-primary" onclick="openGame('typing')">Play Now</button>
      </div>

      <!-- Math Speed -->
      <div class="game-card">
        <div class="game-icon">🔥</div>
        <h3>Math Blitz</h3>
        <p>Answer rapid arithmetic questions in 60 seconds. Builds calculation speed for aptitude tests!</p>
        <div style="font-family:var(--font-mono);font-size:0.78rem;color:var(--c-yellow);margin-bottom:12px">+1 XP per correct</div>
        <button class="btn btn-primary" onclick="openGame('mathblitz')">Play Now</button>
      </div>

      <!-- Word Scramble -->
      <div class="game-card">
        <div class="game-icon">📝</div>
        <h3>Word Scramble</h3>
        <p>Unscramble CS/programming terms as fast as possible. Builds vocabulary for verbal rounds.</p>
        <div style="font-family:var(--font-mono);font-size:0.78rem;color:var(--c-yellow);margin-bottom:12px">+5 XP per word</div>
        <button class="btn btn-primary" onclick="openGame('scramble')">Play Now</button>
      </div>

      <!-- Pattern IQ -->
      <div class="game-card">
        <div class="game-icon">🔍</div>
        <h3>Pattern IQ</h3>
        <p>Find the next number in logical sequences. Directly prepares you for logical reasoning sections!</p>
        <div style="font-family:var(--font-mono);font-size:0.78rem;color:var(--c-yellow);margin-bottom:12px">+15 XP per correct</div>
        <button class="btn btn-primary" onclick="openGame('pattern')">Play Now</button>
      </div>
    </div>
  </div>
</section>

<!-- ===== GAME MODALS ===== -->

<!-- MEMORY MATCH -->
<div class="game-modal" id="modal-memory">
  <div class="game-inner">
    <div class="game-modal-header">
      <h2>🃏 Memory Match</h2>
      <button class="modal-close" onclick="closeGame('memory')">✕</button>
    </div>
    <div class="game-stats" style="margin-bottom:16px">
      <div class="gs-stat"><div class="gs-val" id="mem-flips">0</div><div class="gs-label">Flips</div></div>
      <div class="gs-stat"><div class="gs-val" id="mem-matches">0</div><div class="gs-label">Matches</div></div>
      <div class="gs-stat"><div class="gs-val" id="mem-time">0s</div><div class="gs-label">Time</div></div>
    </div>
    <div class="memory-grid" id="memory-grid"></div>
    <div id="mem-result" style="display:none;text-align:center;margin-top:16px">
      <div style="font-size:2rem;margin-bottom:8px">🎉</div>
      <div style="font-size:1.2rem;font-weight:800;color:var(--accent)">Completed!</div>
      <div id="mem-result-text" style="color:var(--text-2);margin:8px 0"></div>
      <button class="btn btn-primary" onclick="initMemory()" style="margin-top:10px">Play Again</button>
    </div>
    <button class="btn btn-outline btn-block mt-4" onclick="initMemory()">🔄 New Game</button>
  </div>
</div>

<!-- SLIDING PUZZLE -->
<div class="game-modal" id="modal-puzzle">
  <div class="game-inner">
    <div class="game-modal-header">
      <h2>🔢 Number Puzzle</h2>
      <button class="modal-close" onclick="closeGame('puzzle')">✕</button>
    </div>
    <div class="game-stats" style="margin-bottom:16px">
      <div class="gs-stat"><div class="gs-val" id="puz-moves">0</div><div class="gs-label">Moves</div></div>
      <div class="gs-stat"><div class="gs-val" id="puz-time">0s</div><div class="gs-label">Time</div></div>
    </div>
    <div class="puzzle-grid" id="puzzle-grid"></div>
    <div id="puz-result" style="display:none;text-align:center;margin-top:16px">
      <div style="font-size:2rem">🏆</div>
      <div style="font-size:1.2rem;font-weight:800;color:var(--accent);margin:8px 0">Puzzle Solved!</div>
      <div id="puz-result-text" style="color:var(--text-2);margin-bottom:12px"></div>
      <button class="btn btn-primary" onclick="initPuzzle()">Play Again</button>
    </div>
    <button class="btn btn-outline btn-block mt-4" onclick="initPuzzle()">🔄 Shuffle</button>
  </div>
</div>

<!-- SPEED TYPING -->
<div class="game-modal" id="modal-typing">
  <div class="game-inner">
    <div class="game-modal-header">
      <h2>⌨️ Speed Typing</h2>
      <button class="modal-close" onclick="closeGame('typing')">✕</button>
    </div>
    <div class="game-stats" style="margin-bottom:16px">
      <div class="gs-stat"><div class="gs-val" id="typ-wpm">0</div><div class="gs-label">WPM</div></div>
      <div class="gs-stat"><div class="gs-val" id="typ-acc">100%</div><div class="gs-label">Accuracy</div></div>
      <div class="gs-stat"><div class="gs-val" id="typ-time">60s</div><div class="gs-label">Time Left</div></div>
    </div>
    <div class="typing-text" id="typing-display"></div>
    <textarea class="typing-input" id="typing-input" rows="3" placeholder="Start typing here..."></textarea>
    <div id="typ-result" style="display:none;margin-top:14px;text-align:center">
      <div style="font-size:2rem">⌨️</div>
      <div style="font-size:1.2rem;font-weight:800;color:var(--accent);margin:8px 0">Time's Up!</div>
      <div id="typ-result-text" style="color:var(--text-2);margin-bottom:12px"></div>
      <button class="btn btn-primary" onclick="initTyping()">Try Again</button>
    </div>
    <button class="btn btn-outline btn-block mt-4" onclick="initTyping()">🔄 New Text</button>
  </div>
</div>

<!-- MATH BLITZ -->
<div class="game-modal" id="modal-mathblitz">
  <div class="game-inner">
    <div class="game-modal-header">
      <h2>🔥 Math Blitz</h2>
      <button class="modal-close" onclick="closeGame('mathblitz')">✕</button>
    </div>
    <div class="game-stats" style="margin-bottom:16px">
      <div class="gs-stat"><div class="gs-val" id="math-score">0</div><div class="gs-label">Score</div></div>
      <div class="gs-stat"><div class="gs-val" id="math-streak2">0</div><div class="gs-label">Streak</div></div>
      <div class="gs-stat"><div class="gs-val" id="math-time">60s</div><div class="gs-label">Time Left</div></div>
    </div>
    <div id="math-question" style="text-align:center;font-size:2.5rem;font-weight:800;font-family:var(--font-mono);color:var(--text-0);margin:24px 0;letter-spacing:0.05em">Press Start!</div>
    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:14px" id="math-options"></div>
    <div id="math-feedback" style="text-align:center;height:28px;font-family:var(--font-mono);font-size:0.9rem;font-weight:700"></div>
    <div id="math-result" style="display:none;text-align:center;margin-top:14px">
      <div style="font-size:2rem">🏆</div>
      <div style="font-size:1.2rem;font-weight:800;color:var(--accent);margin:8px 0">Game Over!</div>
      <div id="math-result-text" style="color:var(--text-2);margin-bottom:12px"></div>
      <button class="btn btn-primary" onclick="initMath()">Play Again</button>
    </div>
    <button class="btn btn-primary btn-block" id="math-start-btn" onclick="startMath()">Start Game</button>
  </div>
</div>

<!-- WORD SCRAMBLE -->
<div class="game-modal" id="modal-scramble">
  <div class="game-inner">
    <div class="game-modal-header">
      <h2>📝 Word Scramble</h2>
      <button class="modal-close" onclick="closeGame('scramble')">✕</button>
    </div>
    <div class="game-stats" style="margin-bottom:16px">
      <div class="gs-stat"><div class="gs-val" id="scr-score">0</div><div class="gs-label">Score</div></div>
      <div class="gs-stat"><div class="gs-val" id="scr-time">30s</div><div class="gs-label">Time Left</div></div>
    </div>
    <div style="text-align:center;font-size:2rem;font-weight:800;font-family:var(--font-mono);color:var(--accent);letter-spacing:0.15em;margin:20px 0" id="scramble-word">?????</div>
    <div style="text-align:center;font-size:0.82rem;color:var(--text-2);margin-bottom:16px" id="scr-hint"></div>
    <input type="text" class="form-input" id="scramble-input" placeholder="Type the word..." autocomplete="off" style="text-align:center;font-family:var(--font-mono);font-size:1rem">
    <div style="display:flex;gap:8px;margin-top:10px">
      <button class="btn btn-primary btn-block" onclick="checkScramble()">Submit</button>
      <button class="btn btn-outline" onclick="nextScramble()">Skip →</button>
    </div>
    <div id="scr-feedback" style="text-align:center;margin-top:12px;height:24px;font-weight:700;font-family:var(--font-mono)"></div>
  </div>
</div>

<!-- PATTERN IQ -->
<div class="game-modal" id="modal-pattern">
  <div class="game-inner">
    <div class="game-modal-header">
      <h2>🔍 Pattern IQ</h2>
      <button class="modal-close" onclick="closeGame('pattern')">✕</button>
    </div>
    <div class="game-stats" style="margin-bottom:16px">
      <div class="gs-stat"><div class="gs-val" id="pat-score">0</div><div class="gs-label">Score</div></div>
      <div class="gs-stat"><div class="gs-val" id="pat-q">1</div><div class="gs-label">Question</div></div>
    </div>
    <div id="pat-sequence" style="text-align:center;font-size:1.5rem;font-family:var(--font-mono);color:var(--text-0);margin:20px 0;letter-spacing:0.1em;font-weight:700"></div>
    <div style="text-align:center;font-size:0.88rem;color:var(--text-2);margin-bottom:20px">What comes next?</div>
    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px" id="pat-options"></div>
    <div id="pat-explanation" style="display:none;margin-top:14px;padding:12px;background:var(--bg-0);border:1px solid var(--border);border-radius:var(--radius-sm);font-size:0.85rem;color:var(--text-1)"></div>
    <div id="pat-result" style="display:none;text-align:center;margin-top:14px">
      <div style="font-size:2rem">🧠</div>
      <div style="font-size:1.2rem;font-weight:800;color:var(--accent);margin:8px 0">Round Complete!</div>
      <div id="pat-result-text" style="color:var(--text-2);margin-bottom:12px"></div>
      <button class="btn btn-primary" onclick="initPattern()">New Round</button>
    </div>
  </div>
</div>

<div id="notification-area"></div>
<script src="js/main.js"></script>
<script src="js/games.js"></script>
</body>
</html>
