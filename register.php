
<?php
include 'connection.php';

$msg = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->prepare(
        "SELECT name FROM users WHERE name = ?"
    );
    $check->bind_param("s", $username);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        $msg = "Username already exists!";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO users (name, email, password)
             VALUES (?, NULL, ?)"
        );

        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $msg = "Registration failed!";
        }

        $stmt->close();
    }

    $check->close();
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

    <?php if (!empty($msg)): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <input type="text" name="username"
           placeholder="Username" required>

    <input type="password" name="password"
           placeholder="Password" required>

    <button type="submit" name="register">Register</button>

    <a href="login.php">Already have an account? Login here</a>
</form>

</body>
</html>
