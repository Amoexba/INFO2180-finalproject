<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$firstname = $_SESSION['firstname']; 
$lastname = $_SESSION['lastname'];
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Dolphin CRM</title> 
    <link rel="stylesheet" href="layout.css"> 
</head> 
<body> 
    <?php include 'sidebar.php'; ?> 
    <div class="main-content"> 
        <h1>Logout</h1> 
        <p>Hello <?php echo $firstname . " " . $lastname; ?>, do you want to log out?</p> 
        <form action="confirmed-logout.php" method="POST"> 
            <button type="submit" class="logout-btn">Logout</button> 
        </form> 
    </div> 
</body> 
</html>
