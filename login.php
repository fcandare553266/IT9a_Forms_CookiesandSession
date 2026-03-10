<?php
session_start();
$remembered_user = isset($_COOKIE['user_login']) ? $_COOKIE['user_login'] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $file = 'users.json';

    if (file_exists($file)) {
        $users = json_decode(file_get_contents($file), true);

        if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
            
            // --- REQUIREMENT LOGIC ---
            // 1. Store Name and Email in Session
            $_SESSION['name'] = $users[$username]['name'];
            $_SESSION['email'] = $users[$username]['email'];
            $_SESSION['logged_in'] = true;

            // 2. Save name in a cookie
            setcookie("user_login", $users[$username]['name'], time() + 3600, "/");

            // 3. Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials!";
        }
    } else {
        $error = "No users found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <h2>Login Page</h2>
    <?php if(isset($_GET['status'])) echo "<p style='color:green;'>Registration Successful!</p>"; ?>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>