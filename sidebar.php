<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dolphin CRM</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="sidebar">
    <h2>Dolphin CRM</h2>
    <ul>
      <li><a href="home.php">Home</a></li>
      <li><a href="new-contact.php">New Contact</a></li>
      <li><a href="users.php">Users</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</body>
</html>

