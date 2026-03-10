<?php
session_start();

// --- REQUIREMENT CONSTRAINT ---
// User CANNOT access if form not submitted or session data missing
if (!isset($_SESSION['name']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<body>
    <h1>Welcome to your Dashboard, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
    
    <p><strong>Session Data:</strong> Your email is <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    
    <p><strong>Cookie Data:</strong> 
        <?php echo isset($_COOKIE['user_login']) ? "Cookie found for user: " . $_COOKIE['user_login'] : "No cookie found."; ?>
    </p>

    <p style="color:blue;">Security Check: Access Granted (Session Active).</p>
    
    <a href="logout.php">Logout</a>
</body>
</html>