<?php
session_start();
if (isset($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login – AptCode</title>
  <link rel="stylesheet" href="css/main.css">
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar">
  <div class="nav-inner">
    <a class="logo" href="index.php"><span class="logo-apt">Apt</span><span class="logo-code">Code</span></a>
    <div class="nav-auth" style="margin-left:auto">
      <a href="register.php" class="btn btn-primary">Create Account</a>
    </div>
  </div>
</nav>

<div class="auth-page">
  <div class="auth-card">
    <div class="auth-logo"><span class="logo-apt">Apt</span><span class="logo-code">Code</span></div>
    <h1 class="auth-title">Welcome Back</h1>
    <p class="auth-sub">Login to continue your learning journey.</p>

    <?php if ($error): ?>
      <div class="form-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="php/login.php" method="POST" id="login-form">
      <div class="form-group">
        <label class="form-label" for="identifier">Username or Email</label>
        <input class="form-input" type="text" id="identifier" name="identifier" placeholder="username or email" required autocomplete="username">
      </div>
      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input class="form-input" type="password" id="password" name="password" placeholder="Your password" required autocomplete="current-password">
      </div>
      <button type="submit" class="btn btn-primary btn-lg btn-block" id="login-btn">
        Login
      </button>
    </form>

    <div class="auth-alt">Don't have an account? <a href="register.php">Sign up free</a></div>

    <div style="margin-top:20px; padding:14px; background:var(--bg-0); border:1px solid var(--border); border-radius:var(--radius-sm); font-size:0.82rem; color:var(--text-2);">
      <strong style="color:var(--accent);">Demo Mode:</strong> If MySQL is not set up, registration/login will auto-redirect to dashboard with demo data.
    </div>
  </div>
</div>

<script>
document.getElementById('login-form').addEventListener('submit', function() {
  var btn = document.getElementById('login-btn');
  btn.innerHTML = '<span class="spinner"></span> Logging in...';
  btn.disabled = true;
});
</script>
</body>
</html>
