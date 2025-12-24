<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dolphin CRM</title>
  <link rel="stylesheet" href="layout.css">
</head>
<body>
  <header class="login-header">
    <div class="brand">
      <img src="images/dolphin.png" alt="Dolphin CRM Logo" class="logo">
      <h1>Dolphin CRM</h1>
    </div>
  </header>

  <div class="login-container">
    <div class="login-box">
      <h2>Login</h2>
      <form action="authenticate.php" method="POST">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit"> Login</button>
      </form>
    </div>

    <footer class="login-footer">
      <p>Copyright © 2025 Dolphin CRM</p>
    </footer>
  </div>
</body>
</html>
