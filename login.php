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
            
            $_SESSION['user_id'] = $username;
            $_SESSION['logged_in'] = true;

            if (isset($_POST['remember'])) {
                setcookie("user_login", $username, time() + 3600, "/");
            } else {
                setcookie("user_login", "", time() - 3600, "/");
            }

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "No users registered yet.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <h2>Login</h2>
    
    <?php if(isset($_GET['status'])) echo "<p style='color:green;'>Registration Successful!</p>"; ?>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" value="<?php echo $remembered_user; ?>" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        
        <label>
            <input type="checkbox" name="remember" <?php echo $remembered_user ? "checked" : ""; ?>> Remember Me
        </label><br>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>