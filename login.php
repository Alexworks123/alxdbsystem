
<?php
include 'connection.php';

$msg = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT password FROM users WHERE name = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            header("Location: index.php");
            exit();
        } else {
            $msg = "Wrong password!";
        }
    } else {
        $msg = "User not found!";
    }

    $stmt->close();
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

    <?php if (!empty($msg)): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <input type="text" name="username"
           placeholder="Username" required>

    <input type="password" name="password"
           placeholder="Password" required>

    <button type="submit" name="login">Login</button>

    <a href="register.php">
        Don't have an account? Register here
    </a>
</form>

</body>
</html>
