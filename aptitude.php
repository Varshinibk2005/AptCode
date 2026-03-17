<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
require_once 'php/db.php';

// Fetch questions from DB or use seed data
$questions = [];
if ($conn) {
    $topic = $_GET['topic'] ?? '';
    $diff  = $_GET['diff'] ?? '';
    $sql = "SELECT * FROM aptitude_questions WHERE 1=1";
    if ($topic) $sql .= " AND topic='".mysqli_real_escape_string($conn,$topic)."'";
    if ($diff)  $sql .= " AND difficulty='".mysqli_real_escape_string($conn,$diff)."'";
    $sql .= " ORDER BY RAND() LIMIT 20";
    $res = $conn->query($sql);
    if ($res) $questions = $res->fetch_all(MYSQLI_ASSOC);
}

// Fallback seed data if DB not available
if (empty($questions)) {
    $questions = [
        ['id'=>1,'topic'=>'quantitative','difficulty'=>'easy','question_text'=>'If 20% of a number is 80, what is 30% of that number?','option_a'=>'100','option_b'=>'120','option_c'=>'140','option_d'=>'160','correct_answer'=>'B','explanation'=>'20% = 80, so 100% = 400. 30% of 400 = 120.','points'=>10],
        ['id'=>2,'topic'=>'quantitative','difficulty'=>'easy','question_text'=>'A train travels 300 km in 5 hours. What is its average speed?','option_a'=>'50 km/h','option_b'=>'60 km/h','option_c'=>'55 km/h','option_d'=>'70 km/h','correct_answer'=>'B','explanation'=>'Speed = Distance/Time = 300/5 = 60 km/h.','points'=>10],
        ['id'=>3,'topic'=>'logical','difficulty'=>'easy','question_text'=>'Find the odd one out: 2, 3, 5, 7, 9, 11','option_a'=>'9','option_b'=>'7','option_c'=>'11','option_d'=>'3','correct_answer'=>'A','explanation'=>'All others are prime. 9 = 3×3 is composite.','points'=>10],
        ['id'=>4,'topic'=>'logical','difficulty'=>'medium','question_text'=>'In a class of 40 students, 25 play cricket, 15 play football, and 5 play both. How many play neither?','option_a'=>'5','option_b'=>'10','option_c'=>'8','option_d'=>'6','correct_answer'=>'A','explanation'=>'n(C∪F) = 25+15-5 = 35. Neither = 40-35 = 5.','points'=>15],
        ['id'=>5,'topic'=>'verbal','difficulty'=>'easy','question_text'=>'Choose the synonym of BENEVOLENT','option_a'=>'Kind','option_b'=>'Cruel','option_c'=>'Selfish','option_d'=>'Angry','correct_answer'=>'A','explanation'=>'Benevolent means well-meaning and kindly.','points'=>10],
        ['id'=>6,'topic'=>'puzzles','difficulty'=>'easy','question_text'=>'I have cities but no houses. I have mountains but no trees. I have water but no fish. What am I?','option_a'=>'A painting','option_b'=>'A map','option_c'=>'A globe','option_d'=>'A book','correct_answer'=>'B','explanation'=>'A map has representations of cities, mountains, and water but none of the actual things.','points'=>10],
        ['id'=>7,'topic'=>'quantitative','difficulty'=>'medium','question_text'=>'Two pipes A and B can fill a tank in 12 and 15 hours respectively. If both are opened together, how long will it take?','option_a'=>'6.5 hours','option_b'=>'6 hours 40 minutes','option_c'=>'7 hours','option_d'=>'5 hours 30 minutes','correct_answer'=>'B','explanation'=>'Combined rate = 1/12+1/15 = 9/60 = 3/20. Time = 20/3 ≈ 6h 40min.','points'=>15],
        ['id'=>8,'topic'=>'puzzles','difficulty'=>'medium','question_text'=>'A rooster lays an egg on the peak of a roof. Which way does the egg roll?','option_a'=>'Left','option_b'=>'Right','option_c'=>'Roosters do not lay eggs','option_d'=>'Down the steeper slope','correct_answer'=>'C','explanation'=>'Roosters are male chickens and do not lay eggs!','points'=>15],
        ['id'=>9,'topic'=>'speed','difficulty'=>'easy','question_text'=>'A car goes from A to B at 60 km/h and returns at 40 km/h. What is the average speed for the whole journey?','option_a'=>'50 km/h','option_b'=>'48 km/h','option_c'=>'52 km/h','option_d'=>'45 km/h','correct_answer'=>'B','explanation'=>'Harmonic mean: 2×60×40/(60+40) = 4800/100 = 48 km/h.','points'=>10],
        ['id'=>10,'topic'=>'verbal','difficulty'=>'medium','question_text'=>'Choose the word that best fills the blank: "The scientist\'s theory was _____, supported by decades of research."','option_a'=>'Dubious','option_b'=>'Tenuous','option_c'=>'Robust','option_d'=>'Fragile','correct_answer'=>'C','explanation'=>'Robust means strong and well-supported, fitting the context perfectly.','points'=>15],
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aptitude Practice – AptCode</title>
  <link rel="stylesheet" href="css/main.css">
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar" id="navbar">
  <div class="nav-inner">
    <a class="logo" href="index.php"><span class="logo-apt">Apt</span><span class="logo-code">Code</span></a>
    <ul class="nav-links">
      <li><a href="aptitude.php" class="active">Aptitude</a></li>
      <li><a href="coding.php">Coding</a></li>
      <li><a href="games.php">Games</a></li>
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
    <div class="section-tag">Practice Section</div>
    <h1>🧠 Aptitude Questions</h1>
    <p>Master logical reasoning, quantitative aptitude, verbal ability, and puzzles with step-by-step explanations.</p>
    <div id="session-score-banner" style="display:none" class="alert alert-success">
      🏆 Session Score: <strong id="session-score">0</strong> XP earned this session!
    </div>
  </div>
</section>

<section class="page-content">
  <div class="container">
    <!-- Filters -->
    <div class="filter-bar">
      <span style="font-size:0.85rem;color:var(--text-2);font-weight:700;font-family:var(--font-mono)">TOPIC:</span>
      <button class="filter-btn active" data-filter="topic" data-val="">All</button>
      <button class="filter-btn" data-filter="topic" data-val="quantitative">🔢 Quantitative</button>
      <button class="filter-btn" data-filter="topic" data-val="logical">🔁 Logical</button>
      <button class="filter-btn" data-filter="topic" data-val="verbal">📝 Verbal</button>
      <button class="filter-btn" data-filter="topic" data-val="puzzles">🧩 Puzzles</button>
      <button class="filter-btn" data-filter="topic" data-val="speed">⏱️ Speed</button>
      <span style="font-size:0.85rem;color:var(--text-2);font-weight:700;font-family:var(--font-mono);margin-left:8px">DIFF:</span>
      <button class="filter-btn diff-easy active" data-filter="diff" data-val="">All</button>
      <button class="filter-btn diff-easy" data-filter="diff" data-val="easy">Easy</button>
      <button class="filter-btn diff-medium" data-filter="diff" data-val="medium">Medium</button>
      <button class="filter-btn diff-hard" data-filter="diff" data-val="hard">Hard</button>
    </div>

    <!-- Questions -->
    <div class="questions-grid" id="questions-container">
      <?php foreach($questions as $i => $q): ?>
      <div class="question-card" data-topic="<?= $q['topic'] ?>" data-diff="<?= $q['difficulty'] ?>">
        <div class="q-header">
          <span class="q-num">Q<?= $i+1 ?>.</span>
          <span class="q-topic"><?= ucfirst($q['topic']) ?></span>
          <span class="q-diff-<?= $q['difficulty'] ?>"><?= ucfirst($q['difficulty']) ?></span>
          <span style="margin-left:auto;font-family:var(--font-mono);font-size:0.78rem;color:var(--c-yellow)">+<?= $q['points'] ?> XP</span>
        </div>
        <div class="q-text"><?= htmlspecialchars($q['question_text']) ?></div>
        <div class="q-options" id="opts-<?= $q['id'] ?>">
          <?php foreach(['a','b','c','d'] as $opt): ?>
            <button class="q-option"
              data-q="<?= $q['id'] ?>"
              data-opt="<?= strtoupper($opt) ?>"
              data-correct="<?= strtoupper($q['correct_answer']) ?>"
              data-points="<?= $q['points'] ?>"
              onclick="answerQuestion(this)">
              <strong><?= strtoupper($opt) ?>.</strong> <?= htmlspecialchars($q['option_'.strtolower($opt)]) ?>
            </button>
          <?php endforeach; ?>
        </div>
        <div class="explanation-box" id="exp-<?= $q['id'] ?>">
          <div class="exp-label">💡 Explanation</div>
          <div class="exp-text"><?= htmlspecialchars($q['explanation'] ?? 'No explanation provided.') ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div id="notification-area"></div>
<script src="js/main.js"></script>
<script>
var sessionScore = 0;
var isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

function answerQuestion(btn) {
  var q_id = btn.dataset.q;
  var opts = document.querySelectorAll('[data-q="' + q_id + '"]');
  // Disable all options
  opts.forEach(function(o) { o.disabled = true; });

  var isCorrect = btn.dataset.opt === btn.dataset.correct;
  var points = parseInt(btn.dataset.points);

  if (isCorrect) {
    btn.classList.add('correct');
    showNotif('✅ Correct! +' + points + ' XP', 'success');
    sessionScore += points;
    showPointsFloat(btn, '+' + points + ' XP');
    // Mark correct answer
  } else {
    btn.classList.add('wrong');
    // Highlight correct
    opts.forEach(function(o) {
      if (o.dataset.opt === btn.dataset.correct) o.classList.add('correct');
    });
    showNotif('❌ Wrong! The answer was ' + btn.dataset.correct, 'error');
  }

  // Show explanation
  var exp = document.getElementById('exp-' + q_id);
  if (exp) exp.classList.add('visible');

  // Update session score
  document.getElementById('session-score').textContent = sessionScore;
  document.getElementById('session-score-banner').style.display = 'flex';

  // Save to DB if logged in
  if (isLoggedIn) {
    var fd = new FormData();
    fd.append('type', 'aptitude');
    fd.append('question_id', q_id);
    fd.append('status', isCorrect ? 'correct' : 'wrong');
    fd.append('score', isCorrect ? points : 0);
    fd.append('action', isCorrect ? 'Answered aptitude question correctly' : 'Attempted aptitude question');
    fd.append('icon', isCorrect ? '🧠' : '📝');
    fetch('php/save_score.php', { method: 'POST', body: fd })
      .then(r => r.json()).then(d => {
        if (d.success && d.points > 0) {
          // Score saved
        }
      }).catch(function(){});
  }
}

// Filter functionality
var activeTopic = '', activeDiff = '';
document.querySelectorAll('.filter-btn').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var filter = this.dataset.filter;
    var val = this.dataset.val;
    if (filter === 'topic') {
      activeTopic = val;
      document.querySelectorAll('[data-filter="topic"]').forEach(function(b){ b.classList.remove('active'); });
    } else {
      activeDiff = val;
      document.querySelectorAll('[data-filter="diff"]').forEach(function(b){ b.classList.remove('active'); });
    }
    this.classList.add('active');
    filterQuestions();
  });
});

function filterQuestions() {
  document.querySelectorAll('.question-card').forEach(function(card) {
    var topicMatch = !activeTopic || card.dataset.topic === activeTopic;
    var diffMatch  = !activeDiff  || card.dataset.diff === activeDiff;
    card.style.display = (topicMatch && diffMatch) ? '' : 'none';
  });
}

function showPointsFloat(elem, text) {
  var rect = elem.getBoundingClientRect();
  var el = document.createElement('div');
  el.className = 'points-float';
  el.textContent = text;
  el.style.left = (rect.left + window.scrollX + rect.width/2) + 'px';
  el.style.top = (rect.top + window.scrollY) + 'px';
  document.body.appendChild(el);
  setTimeout(function(){ el.remove(); }, 1500);
}
</script>
</body>
</html>
