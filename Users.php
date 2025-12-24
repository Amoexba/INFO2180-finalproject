<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// This only allow admins to view
if ($_SESSION['role'] !== 'admin') {
    echo "Access denied. Only admins can view this page.";
    exit();
}

$conn = new mysqli("localhost", "root", "", "dolphin_crm");

if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
}  
$sql = "SELECT firstname, lastname, email, role, created_at FROM users"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dolphin CRM </title>
  <link rel="stylesheet" href="layout.css">
</head>
<body>
  <?php include 'sidebar.php'; ?>

  <div class="main-content">
    <h1>Users</h1>
    <table>
      <thead>
        <tr>
          <th>Full Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Created</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo ucfirst($row['role']); ?></td>
            <td><?php echo $row['created_at']; ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>

