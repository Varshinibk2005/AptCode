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
  <title>Register – AptCode</title>
  <link rel="stylesheet" href="css/main.css">
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar">
  <div class="nav-inner">
    <a class="logo" href="index.php"><span class="logo-apt">Apt</span><span class="logo-code">Code</span></a>
    <div class="nav-auth" style="margin-left:auto">
      <a href="login.php" class="btn btn-ghost">Already have an account? Login</a>
    </div>
  </div>
</nav>

<div class="auth-page">
  <div class="auth-card">
    <div class="auth-logo"><span class="logo-apt">Apt</span><span class="logo-code">Code</span></div>
    <h1 class="auth-title">Create Account</h1>
    <p class="auth-sub">Join the platform and start your placement prep journey.</p>

    <?php if ($error): ?>
      <div class="form-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="php/register.php" method="POST" id="register-form">
      <div class="form-group">
        <label class="form-label" for="username">Username</label>
        <input class="form-input" type="text" id="username" name="username" placeholder="e.g. coder_dev99" required minlength="3" maxlength="30" pattern="[a-zA-Z0-9_]+" autocomplete="username">
        <div class="form-hint">Letters, numbers, underscores only.</div>
      </div>
      <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <input class="form-input" type="email" id="email" name="email" placeholder="you@example.com" required autocomplete="email">
      </div>
      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input class="form-input" type="password" id="password" name="password" placeholder="Min 6 characters" required minlength="6" autocomplete="new-password">
      </div>
      <div class="form-group">
        <label class="form-label" for="confirm_password">Confirm Password</label>
        <input class="form-input" type="password" id="confirm_password" name="confirm_password" placeholder="Repeat your password" required autocomplete="new-password">
      </div>
      <button type="submit" class="btn btn-primary btn-lg btn-block" id="reg-btn">
        Create Account
      </button>
    </form>

    <div class="auth-alt">Already have an account? <a href="login.php">Login here</a></div>
  </div>
</div>

<script>
document.getElementById('register-form').addEventListener('submit', function(e) {
  var p = document.getElementById('password').value;
  var c = document.getElementById('confirm_password').value;
  if (p !== c) {
    e.preventDefault();
    alert('Passwords do not match!');
    return;
  }
  var btn = document.getElementById('reg-btn');
  btn.innerHTML = '<span class="spinner"></span> Creating account...';
  btn.disabled = true;
});
</script>
</body>
</html>
