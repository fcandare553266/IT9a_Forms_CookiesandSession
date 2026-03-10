<?php
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $name = trim($_POST['name']); // Added for the Dashboard requirement
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($name) || empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $file = 'users.json';
        $users = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
        
        $users[$username] = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        file_put_contents($file, json_encode($users));
        header("Location: login.php?status=success");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Sign Up</h2>
    <?php foreach($errors as $err) echo "<p style='color:red;'>$err</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>
    <p><a href="login.php">Login here</a></p>
</body>
</html>