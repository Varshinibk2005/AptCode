<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
require_once 'php/db.php';

$problems = [];
if ($conn) {
    $res = $conn->query("SELECT * FROM coding_problems ORDER BY FIELD(difficulty,'easy','medium','hard'), id");
    if ($res) $problems = $res->fetch_all(MYSQLI_ASSOC);
}
if (empty($problems)) {
    $problems = [
        ['id'=>1,'title'=>'Two Sum','difficulty'=>'easy','topic'=>'Arrays','description'=>'Given an array of integers nums and an integer target, return indices of the two numbers that add up to target.','examples'=>"Input: nums=[2,7,11,15], target=9\nOutput: [0,1]",'constraints'=>"2 <= nums.length <= 10^4\nOnly one valid answer",'hint'=>'Use a hash map to store complement of each number.','points'=>20],
        ['id'=>2,'title'=>'Reverse String','difficulty'=>'easy','topic'=>'Strings','description'=>'Write a function that reverses a character array in-place with O(1) extra memory.','examples'=>"Input: [\"h\",\"e\",\"l\",\"l\",\"o\"]\nOutput: [\"o\",\"l\",\"l\",\"e\",\"h\"]",'constraints'=>'1 <= s.length <= 10^5','hint'=>'Use two pointers from both ends.','points'=>10],
        ['id'=>3,'title'=>'Valid Parentheses','difficulty'=>'easy','topic'=>'Stack','description'=>'Given string s containing (, ), {, }, [ and ], determine if it is valid.','examples'=>"Input: \"()[]{}\"\nOutput: true\n\nInput: \"(]\"\nOutput: false",'constraints'=>'1 <= s.length <= 10^4','hint'=>'Use a stack. Push opening brackets, pop and match on closing.','points'=>20],
        ['id'=>4,'title'=>'Maximum Subarray','difficulty'=>'medium','topic'=>'Dynamic Programming','description'=>'Given integer array nums, find the subarray with largest sum and return its sum.','examples'=>"Input: [-2,1,-3,4,-1,2,1,-5,4]\nOutput: 6\nExplanation: [4,-1,2,1] has sum 6",'constraints'=>"1 <= nums.length <= 10^5\n-10^4 <= nums[i] <= 10^4",'hint'=>"Kadane's Algorithm: track current sum and max sum.",'points'=>30],
        ['id'=>5,'title'=>'Binary Search','difficulty'=>'easy','topic'=>'Searching','description'=>'Given sorted array nums and integer target, return its index or -1 if not found.','examples'=>"Input: [-1,0,3,5,9,12], target=9\nOutput: 4",'constraints'=>'1 <= nums.length <= 10^4\nnums is sorted ascending','hint'=>'Maintain lo and hi pointers, check the mid element.','points'=>20],
        ['id'=>6,'title'=>'Climbing Stairs','difficulty'=>'easy','topic'=>'Dynamic Programming','description'=>'You can climb 1 or 2 steps at a time. How many distinct ways to reach n steps?','examples'=>"Input: n=3\nOutput: 3\nExplanation: (1+1+1), (1+2), (2+1)",'constraints'=>'1 <= n <= 45','hint'=>'Think Fibonacci. dp[i] = dp[i-1] + dp[i-2].','points'=>20],
        ['id'=>7,'title'=>'Merge Two Sorted Lists','difficulty'=>'medium','topic'=>'Linked Lists','description'=>'Merge two sorted linked lists and return the head of the merged sorted list.','examples'=>"Input: [1,2,4] and [1,3,4]\nOutput: [1,1,2,3,4,4]",'constraints'=>'0 <= n <= 50 nodes each\nValues in [-100, 100]','hint'=>'Use a dummy head node and compare iteratively.','points'=>30],
        ['id'=>8,'title'=>'Number of Islands','difficulty'=>'medium','topic'=>'Graph/BFS/DFS','description'=>"Given m×n grid of '1's (land) and '0's (water), return the number of islands.",'examples'=>"Input: [[\"1\",\"1\",\"0\"],[\"0\",\"1\",\"0\"],[\"0\",\"0\",\"1\"]]\nOutput: 2",'constraints'=>'m, n >= 1\ngrid[i][j] is 0 or 1','hint'=>'Use DFS/BFS to flood-fill each island.','points'=>35],
        ['id'=>9,'title'=>'Longest Palindromic Substring','difficulty'=>'medium','topic'=>'Strings','description'=>'Given string s, return the longest palindromic substring.','examples'=>"Input: \"babad\"\nOutput: \"bab\"",'constraints'=>"1 <= s.length <= 1000\nDigits and English letters only",'hint'=>'Expand around center for each character.','points'=>35],
        ['id'=>10,'title'=>'LRU Cache','difficulty'=>'hard','topic'=>'Design','description'=>'Design a data structure implementing LRU cache with get and put in O(1) time.','examples'=>"LRUCache(2)\nput(1,1) put(2,2)\nget(1) → 1\nput(3,3) // evicts 2",'constraints'=>'1 <= capacity <= 3000','hint'=>'Doubly linked list + hashmap.','points'=>50],
    ];
}

// Get solved problems for logged-in user
$solved = [];
if ($isLoggedIn && $conn) {
    $uid = (int)$_SESSION['user_id'];
    $res2 = $conn->query("SELECT DISTINCT problem_id FROM user_progress WHERE user_id=$uid AND type='coding' AND status='solved'");
    if ($res2) while($r=$res2->fetch_assoc()) $solved[] = $r['problem_id'];
}

$diffColors = ['easy'=>'var(--c-green)','medium'=>'var(--c-yellow)','hard'=>'var(--c-red)'];
$diffXP = ['easy'=>'10-20 XP','medium'=>'30-35 XP','hard'=>'50 XP'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coding Challenges – AptCode</title>
  <link rel="stylesheet" href="css/main.css">
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar" id="navbar">
  <div class="nav-inner">
    <a class="logo" href="index.php"><span class="logo-apt">Apt</span><span class="logo-code">Code</span></a>
    <ul class="nav-links">
      <li><a href="aptitude.php">Aptitude</a></li>
      <li><a href="coding.php" class="active">Coding</a></li>
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
    <h1>💻 Coding Challenges</h1>
    <p>Practice DSA problems, algorithms, and more. Select a problem to see the description and write your solution.</p>
  </div>
</section>

<section class="page-content">
  <div class="container">
    <!-- Problem list or problem detail view -->
    <div id="problem-list-view">
      <div class="filter-bar">
        <button class="filter-btn active" data-diff="">All</button>
        <button class="filter-btn diff-easy" data-diff="easy">🟢 Easy</button>
        <button class="filter-btn diff-medium" data-diff="medium">🟡 Medium</button>
        <button class="filter-btn diff-hard" data-diff="hard">🔴 Hard</button>
      </div>
      <div class="coding-grid">
        <?php foreach($problems as $i=>$p): $isSolved = in_array($p['id'], $solved); ?>
        <div class="coding-card <?= $isSolved?'solved':'' ?>" style="cursor:pointer" onclick="showProblem(<?= $p['id'] ?>)">
          <span class="cc-num"><?= str_pad($i+1,2,'0',STR_PAD_LEFT) ?></span>
          <div class="cc-info">
            <div class="cc-title"><?= htmlspecialchars($p['title']) ?> <?= $isSolved?'<span style="color:var(--c-green);font-size:0.8rem">✓ Solved</span>':'' ?></div>
            <div class="cc-tags"><span class="cc-tag"><?= htmlspecialchars($p['topic']) ?></span></div>
          </div>
          <span style="font-size:0.82rem;font-weight:700;color:<?= $diffColors[$p['difficulty']] ?>"><?= ucfirst($p['difficulty']) ?></span>
          <span class="cc-xp">+<?= $p['points'] ?> XP</span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Problem detail -->
    <div id="problem-detail-view" style="display:none">
      <button class="btn btn-ghost" onclick="showList()" style="margin-bottom:20px">← Back to Problems</button>
      <div class="problem-layout">
        <div class="problem-desc" id="problem-desc-panel">
          <!-- Filled dynamically -->
        </div>
        <div>
          <div class="code-editor-wrapper">
            <div class="editor-header">
              <select class="editor-lang-select" id="lang-select">
                <option value="python">Python</option>
                <option value="javascript">JavaScript</option>
                <option value="java">Java</option>
                <option value="cpp">C++</option>
                <option value="c">C</option>
              </select>
              <span style="flex:1"></span>
              <button class="btn btn-sm btn-primary" onclick="runCode()">▶ Run</button>
              <button class="btn btn-sm btn-outline" onclick="submitCode()" style="margin-left:8px">Submit ✓</button>
            </div>
            <textarea class="code-input" id="code-area" placeholder="// Write your solution here...
// Note: This is a practice editor. Describe your approach,
// write pseudocode or actual code in your chosen language.
// Click Submit to mark as solved and earn XP!
"></textarea>
            <div class="code-output" id="code-output">
              <span style="color:var(--text-3)">// Output will appear here after Run</span>
            </div>
          </div>
          <div style="margin-top:12px;display:flex;gap:10px">
            <button class="btn btn-sm btn-ghost" onclick="showHint()">💡 Hint</button>
            <button class="btn btn-sm btn-ghost" onclick="resetCode()">🔄 Reset</button>
          </div>
          <div id="hint-box" style="display:none;margin-top:12px;background:var(--c-yellow-dim);border:1px solid var(--c-yellow);border-radius:var(--radius-sm);padding:14px;font-size:0.88rem;color:var(--c-yellow)"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="notification-area"></div>
<script src="js/main.js"></script>
<script>
var isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
var problems = <?= json_encode($problems) ?>;
var currentProblem = null;

// Filter
document.querySelectorAll('.filter-btn').forEach(function(btn){
  btn.addEventListener('click', function(){
    document.querySelectorAll('.filter-btn').forEach(function(b){b.classList.remove('active');});
    this.classList.add('active');
    var diff = this.dataset.diff;
    document.querySelectorAll('.coding-card').forEach(function(c){
      c.style.display = (!diff || c.querySelector('[style*="color"]') && c.innerHTML.includes(diff.charAt(0).toUpperCase()+diff.slice(1))) ? '' : 'none';
    });
  });
});

function showProblem(id) {
  currentProblem = problems.find(function(p){ return p.id == id; });
  if (!currentProblem) return;
  document.getElementById('problem-list-view').style.display = 'none';
  document.getElementById('problem-detail-view').style.display = 'block';
  
  var diffColor = {'easy':'var(--c-green)','medium':'var(--c-yellow)','hard':'var(--c-red)'}[currentProblem.difficulty];
  var desc = document.getElementById('problem-desc-panel');
  desc.innerHTML = '<div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">' +
    '<h2>' + escHtml(currentProblem.title) + '</h2>' +
    '<span style="padding:3px 12px;border-radius:100px;font-size:0.78rem;font-weight:700;background:' + diffColor + '22;color:' + diffColor + '">' + ucfirst(currentProblem.difficulty) + '</span>' +
    '<span style="font-family:var(--font-mono);font-size:0.8rem;color:var(--c-yellow)">+' + currentProblem.points + ' XP</span>' +
    '</div>' +
    '<p style="margin-bottom:16px">' + escHtml(currentProblem.description) + '</p>' +
    '<div class="problem-example"><strong>Examples:</strong>\n' + escHtml(currentProblem.examples || '') + '</div>' +
    '<div style="margin-top:12px"><div style="font-size:0.8rem;font-family:var(--font-mono);color:var(--accent);margin-bottom:6px">CONSTRAINTS:</div>' +
    '<pre style="font-family:var(--font-mono);font-size:0.82rem;color:var(--text-2);white-space:pre-wrap">' + escHtml(currentProblem.constraints || '') + '</pre>' +
    '</div>';
  
  document.getElementById('code-area').value = getTemplate(currentProblem.title, document.getElementById('lang-select').value);
  document.getElementById('code-output').innerHTML = '<span style="color:var(--text-3)">// Output will appear here after Run</span>';
  document.getElementById('hint-box').style.display = 'none';
}

function showList() {
  document.getElementById('problem-list-view').style.display = 'block';
  document.getElementById('problem-detail-view').style.display = 'none';
}

function getTemplate(title, lang) {
  var templates = {
    python: '# ' + title + '\n# Write your solution below\n\ndef solution():\n    pass\n\n# Test your solution\nprint(solution())\n',
    javascript: '// ' + title + '\n// Write your solution below\n\nfunction solution() {\n    // Your code here\n}\n\nconsole.log(solution());\n',
    java: '// ' + title + '\npublic class Solution {\n    public static void main(String[] args) {\n        // Your code here\n    }\n}\n',
    cpp: '// ' + title + '\n#include <iostream>\nusing namespace std;\n\nint main() {\n    // Your code here\n    return 0;\n}\n',
    c: '// ' + title + '\n#include <stdio.h>\n\nint main() {\n    // Your code here\n    return 0;\n}\n'
  };
  return templates[lang] || templates.python;
}

document.getElementById('lang-select').addEventListener('change', function() {
  if (currentProblem) {
    document.getElementById('code-area').value = getTemplate(currentProblem.title, this.value);
  }
});

function runCode() {
  var code = document.getElementById('code-area').value.trim();
  var out = document.getElementById('code-output');
  if (!code) { out.innerHTML = '<span class="output-fail">No code to run.</span>'; return; }
  out.innerHTML = '<span class="output-info">⚡ Running... (This is a practice environment — code is not executed server-side.)\n✅ Simulated: Code structure looks good!\n\n💡 Tip: Test your logic mentally using the examples provided.</span>';
}

function submitCode() {
  var code = document.getElementById('code-area').value.trim();
  if (code.length < 20) { showNotif('Write some code before submitting!', 'error'); return; }
  
  var out = document.getElementById('code-output');
  out.innerHTML = '<span class="output-pass">✅ Submitted! Your solution has been recorded.\n🏆 +' + currentProblem.points + ' XP earned!\n\nNote: In a full environment, your code would run against test cases.</span>';
  
  showNotif('🎉 Problem solved! +' + currentProblem.points + ' XP', 'success');
  
  if (isLoggedIn) {
    var fd = new FormData();
    fd.append('type','coding');
    fd.append('question_id', currentProblem.id);
    fd.append('status','solved');
    fd.append('score', currentProblem.points);
    fd.append('action','Solved: ' + currentProblem.title);
    fd.append('icon','💻');
    fetch('php/save_score.php', {method:'POST',body:fd}).catch(function(){});
  }
}

function showHint() {
  var hintBox = document.getElementById('hint-box');
  if (currentProblem && currentProblem.hint) {
    hintBox.style.display = 'block';
    hintBox.innerHTML = '💡 <strong>Hint:</strong> ' + escHtml(currentProblem.hint);
  }
}

function resetCode() {
  if (currentProblem) document.getElementById('code-area').value = getTemplate(currentProblem.title, document.getElementById('lang-select').value);
  document.getElementById('hint-box').style.display = 'none';
}

function escHtml(str) { return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
function ucfirst(str) { return str.charAt(0).toUpperCase() + str.slice(1); }
</script>
</body>
</html>
