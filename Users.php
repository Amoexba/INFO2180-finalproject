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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] === 'admin') { 
  $firstname = $_POST['firstname']; 
  $lastname = $_POST['lastname']; 
  $email = $_POST['email']; 
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
  $role = $_POST['role']; 
  
  $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())"); 
  $stmt->bind_param("sssss", $firstname, $lastname, $email, $password, $role); 
  $stmt->execute(); $stmt->close();
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
    <div class="header-row">
      <h1>Users</h1>
      <?php if ($_SESSION['role'] === 'admin'): ?>
      <button id="addUserBtn" class="add-user-btn">+ Add User</button>
      <?php endif; ?>
    </div>
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
  <div class="form-wrapper"> 
    <div id="addUserForm" class="form-panel"> 
      <h2>New User</h2> 
      <form action="users.php" method="POST"> 
        <label for="firstname">First Name:</label> 
        <input type="text" id="firstname" name="firstname" required> 
        
        <label for="lastname">Last Name:</label> 
        <input type="text" id="lastname" name="lastname" required> 
        
        <label for="email">Email:</label> 
        <input type="email" id="email" name="email" required> 
        
        <label for="password">Password:</label> 
        <input type="password" id="password" name="password" required> 
        
        <label for="role">Role:</label> 
        <select id="role" name="role" required> 
          <option value="admin">Admin</option> 
          <option value="member">Member</option> 
        </select> 
        
        <button type="submit" class="submit-btn">Save</button> 
      </form> 
    </div> 
  </div> 
</div>
<script>
  const formPanel = document.getElementById("addUserForm");
  const btn = document.getElementById("addUserBtn");

  btn.onclick = () => {
    formPanel.style.display = 
      formPanel.style.display === "block" ? "none" : "block";
  };
</script>


