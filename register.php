<?php
if (file_exists('connection.php')) {
    include 'connection.php';
}

$msg = "";
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    
    $msg = $stmt->execute() ? "Registered successfully!" : "Registration failed!";
    
    if ($stmt->execute()) {
    header("Location: login.php");
    exit();
} else {
    echo "Registration failed!";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<form method="POST">
    <h2>Register</h2>
    <?php if (!empty($msg)) echo "<p class='msg'>$msg</p>"; ?>
    
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="register">Register</button>
    
    <a href="login.php">Go to Login</a>
</form>

</body>
</html>