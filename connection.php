

<?php
$conn = new mysqli("localhost", "root", "", "alxdbsystem");

if ($conn->connect_error) {
    die("Connection failed");
}
?>