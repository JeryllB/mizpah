<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "spa_system";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed");
}
?>