<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AptCode – Sharpen Your Mind, Master Code</title>
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
      <li><a href="games.php">Games</a></li>
      <li><a href="daily.php">Daily Challenge</a></li>
      <li><a href="leaderboard.php">Leaderboard</a></li>
    </ul>
    <div class="nav-auth">
      <?php if($isLoggedIn): ?>
        <a href="dashboard.php" class="btn btn-ghost">Dashboard</a>
        <a href="php/logout.php" class="btn btn-outline">Logout</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-ghost">Login</a>
        <a href="register.php" class="btn btn-primary">Get Started</a>
      <?php endif; ?>
    </div>
    <button class="hamburger" id="hamburger"><span></span><span></span><span></span></button>
  </div>
</nav>

<section class="hero">
  <div class="hero-bg"><canvas id="hero-canvas"></canvas><div class="hero-grid"></div></div>
  <div class="hero-content">
    <div class="hero-badge">🚀 Placement Prep Platform</div>
    <h1 class="hero-title">
      <span class="line">Sharpen Your</span>
      <span class="line accent">Aptitude.</span>
      <span class="line">Master</span>
      <span class="line accent2">Code.</span>
    </h1>
    <p class="hero-sub">Practice aptitude, solve coding challenges, play brain-training games, and compete with peers — all in one platform.</p>
    <div class="hero-cta">
      <?php if($isLoggedIn): ?>
        <a href="dashboard.php" class="btn btn-primary btn-lg">Go to Dashboard</a>
        <a href="daily.php" class="btn btn-outline btn-lg">Today's Challenge</a>
      <?php else: ?>
        <a href="register.php" class="btn btn-primary btn-lg">Start for Free</a>
        <a href="aptitude.php" class="btn btn-outline btn-lg">Explore Questions</a>
      <?php endif; ?>
    </div>
    <div class="hero-stats">
      <div class="stat"><span class="stat-num" data-target="500">0</span><span class="stat-label">Questions</span></div>
      <div class="stat-divider"></div>
      <div class="stat"><span class="stat-num" data-target="200">0</span><span class="stat-label">Coding Problems</span></div>
      <div class="stat-divider"></div>
      <div class="stat"><span class="stat-num" data-target="8">0</span><span class="stat-label">Mini Games</span></div>
    </div>
  </div>
  <div class="hero-visual">
    <div class="code-card floating">
      <div class="code-header">
        <span class="dot red"></span><span class="dot yellow"></span><span class="dot green"></span>
        <span class="code-file">daily_challenge.py</span>
      </div>
      <pre class="code-body"><span class="kw">def</span> <span class="fn">solve</span>(arr):
    <span class="cm"># Max subarray sum</span>
    max_s = curr = arr[<span class="num">0</span>]
    <span class="kw">for</span> x <span class="kw">in</span> arr[<span class="num">1</span>:]:
        curr = <span class="fn">max</span>(x, curr+x)
        max_s = <span class="fn">max</span>(max_s, curr)
    <span class="kw">return</span> max_s</pre>
    </div>
    <div class="score-card floating-2"><div class="score-icon">🏆</div><div><div class="score-label">Today's Score</div><div class="score-val">+120 XP</div></div></div>
    <div class="streak-card floating-3"><span class="streak-fire">🔥</span><span>7 Day Streak!</span></div>
  </div>
</section>

<section class="features">
  <div class="container">
    <div class="section-header">
      <div class="section-tag">What We Offer</div>
      <h2>Everything You Need to <span class="accent">Ace Placements</span></h2>
    </div>
    <div class="features-grid">
      <a href="aptitude.php" class="feature-card card-apt"><div class="feature-icon">🧠</div><h3>Aptitude Practice</h3><p>Logical reasoning, quantitative, verbal, and puzzles with detailed explanations.</p><div class="feature-arrow">→</div></a>
      <a href="coding.php" class="feature-card card-code"><div class="feature-icon">💻</div><h3>Coding Challenges</h3><p>Easy, Medium, Hard problems across DSA, algorithms, and competitive programming.</p><div class="feature-arrow">→</div></a>
      <a href="games.php" class="feature-card card-game"><div class="feature-icon">🎮</div><h3>Brain Games</h3><p>Interactive games that sharpen memory, logic, and problem-solving instincts.</p><div class="feature-arrow">→</div></a>
      <a href="daily.php" class="feature-card card-daily"><div class="feature-icon">📅</div><h3>Daily Challenges</h3><p>Fresh aptitude + coding problem every day. Stay consistent, stay sharp.</p><div class="feature-arrow">→</div></a>
      <a href="dashboard.php" class="feature-card card-dash"><div class="feature-icon">📊</div><h3>Progress Dashboard</h3><p>Track completed questions, scores, streaks, and improvement over time.</p><div class="feature-arrow">→</div></a>
      <a href="leaderboard.php" class="feature-card card-lead"><div class="feature-icon">🏆</div><h3>Leaderboard</h3><p>Compete with peers, earn badges, and climb to the top of the rankings.</p><div class="feature-arrow">→</div></a>
    </div>
  </div>
</section>

<section class="topics-section">
  <div class="container">
    <div class="section-header">
      <div class="section-tag">Aptitude Topics</div>
      <h2>Comprehensive <span class="accent">Topic Coverage</span></h2>
    </div>
    <div class="topics-grid">
      <?php $topics=[['icon'=>'🔢','name'=>'Quantitative','count'=>'120+ Qs','color'=>'--c-teal'],['icon'=>'🔁','name'=>'Logical Reasoning','count'=>'100+ Qs','color'=>'--c-purple'],['icon'=>'📝','name'=>'Verbal Ability','count'=>'80+ Qs','color'=>'--c-orange'],['icon'=>'🧩','name'=>'Puzzles','count'=>'60+ Qs','color'=>'--c-pink'],['icon'=>'📐','name'=>'Data Interpretation','count'=>'70+ Qs','color'=>'--c-green'],['icon'=>'⏱️','name'=>'Time & Speed','count'=>'50+ Qs','color'=>'--c-yellow']];
      foreach($topics as $t): ?><div class="topic-chip" style="--chip-color:var(<?=$t['color']?>)"><span class="topic-icon"><?=$t['icon']?></span><div><div class="topic-name"><?=$t['name']?></div><div class="topic-count"><?=$t['count']?></div></div></div><?php endforeach; ?>
    </div>
    <div class="center-btn"><a href="aptitude.php" class="btn btn-primary">Browse All Questions</a></div>
  </div>
</section>

<section class="daily-teaser">
  <div class="container">
    <div class="daily-card">
      <div class="daily-left">
        <div class="daily-badge">📅 Daily Challenge</div>
        <h2>Today's Brain Workout</h2>
        <p>Solve one aptitude + one coding problem daily to build momentum and earn bonus XP.</p>
        <a href="daily.php" class="btn btn-primary">Take Today's Challenge</a>
      </div>
      <div class="daily-right">
        <div class="daily-q-preview">
          <div class="dq-label">Sample Question</div>
          <div class="dq-text">A train travels 240 km in 3 hours, then 180 km in 2 hours. What is the average speed?</div>
          <div class="dq-options">
            <span class="dq-opt">A. 80 km/h</span><span class="dq-opt correct">B. 84 km/h</span>
            <span class="dq-opt">C. 90 km/h</span><span class="dq-opt">D. 72 km/h</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="leaderboard-preview">
  <div class="container">
    <div class="section-header">
      <div class="section-tag">Top Performers</div>
      <h2>This Week's <span class="accent">Leaders</span></h2>
    </div>
    <?php
    $top=[['username'=>'Alice','total_score'=>3420,'streak'=>14],['username'=>'BobCoder','total_score'=>3100,'streak'=>9],['username'=>'Priya_Dev','total_score'=>2870,'streak'=>7],['username'=>'NerdKing','total_score'=>2650,'streak'=>5],['username'=>'CodeWiz','total_score'=>2400,'streak'=>3]];
    try { require_once 'php/db.php'; if(isset($conn)){$res=$conn->query("SELECT username,total_score,streak FROM users ORDER BY total_score DESC LIMIT 5");if($res)$top=$res->fetch_all(MYSQLI_ASSOC);} } catch(Exception $e){}
    $medals=['🥇','🥈','🥉','4️⃣','5️⃣'];
    ?>
    <div class="lb-preview-table">
      <?php foreach($top as $i=>$u): ?>
        <div class="lb-row <?=$i===0?'lb-first':''?>">
          <span class="lb-rank"><?=$medals[$i]?></span>
          <span class="lb-avatar"><?=strtoupper(substr($u['username'],0,1))?></span>
          <span class="lb-name"><?=htmlspecialchars($u['username'])?></span>
          <span class="lb-streak">🔥 <?=$u['streak']?>d</span>
          <span class="lb-score"><?=number_format($u['total_score'])?> XP</span>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="center-btn"><a href="leaderboard.php" class="btn btn-outline">Full Leaderboard →</a></div>
  </div>
</section>

<section class="cta-banner">
  <div class="container">
    <div class="cta-inner">
      <h2>Ready to Start Your Journey?</h2>
      <p>Join thousands of students preparing for placements with AptCode.</p>
      <?php if(!$isLoggedIn): ?>
        <a href="register.php" class="btn btn-primary btn-lg">Create Free Account</a>
      <?php else: ?>
        <a href="daily.php" class="btn btn-primary btn-lg">Today's Challenge →</a>
      <?php endif; ?>
    </div>
  </div>
</section>

<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand"><div class="logo"><span class="logo-apt">Apt</span><span class="logo-code">Code</span></div><p>Your all-in-one placement preparation platform.</p></div>
      <div class="footer-links"><h4>Practice</h4><a href="aptitude.php">Aptitude</a><a href="coding.php">Coding</a><a href="games.php">Games</a><a href="daily.php">Daily Challenge</a></div>
      <div class="footer-links"><h4>Account</h4><a href="register.php">Register</a><a href="login.php">Login</a><a href="dashboard.php">Dashboard</a><a href="leaderboard.php">Leaderboard</a></div>
    </div>
    <div class="footer-bottom"><p>&copy; <?=date('Y')?> AptCode. Built for students, by students.</p></div>
  </div>
</footer>
<script src="js/main.js"></script>
</body>
</html>
