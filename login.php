<?php
if (file_exists('connection.php')) {
    include 'connection.php';
}

$msg = "";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $msg = password_verify($_POST['password'], $user['password'])
            ? "Login successful!"
            : "Wrong password!";
    } else {
        $msg = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<form method="POST">
    <h2>Login</h2>
    <?php if (!empty($msg)) echo "<p class='msg'>$msg</p>"; ?>
    
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
    
    <a href="register.php">Create an Account</a>
</form>

</body>
</html>