

<?php
$conn = new mysqli("localhost", "root", "", "alexs");

if ($conn->connect_error) {
    die("Connection failed");
}
?>