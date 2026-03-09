<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $file = 'users.json';
        $current_data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        $current_data[$username] = [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        file_put_contents($file, json_encode($current_data));

        header("Location: login.php?status=success");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Signup</title></head>
<body>
    <h2>Create Account</h2>

    <?php foreach($errors as $err) echo "<p style='color:red;'>$err</p>"; ?>
    
    <form method="POST" action="signup.php">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
        <button type="submit">Sign Up</button>
    </form>
    
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>