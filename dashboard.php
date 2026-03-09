<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Welcome to your Dashboard, <?php echo $_SESSION['user_id']; ?>!</h1>
    <p>You have successfully logged in using a PHP Session.</p>
    
    <p><strong>Security Tip:</strong> Your password was verified using <code>password_verify()</code>.</p>
    
    <a href="logout.php">Logout</a>
</body>
</html>