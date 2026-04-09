<?php
session_start();
$conn = new mysqli("localhost:3307", "root", "", "spa_system");

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // 🔥 CLEAR SESSION FIRST
    session_unset();

    $_SESSION['role'] = $row['role'];
    $_SESSION['email'] = $row['email'];

    if ($row['role'] == "admin") {
        header("Location: admin.php");
        exit();
    } else {
        header("Location: booking.php");
        exit();
    }

} else {
    echo "Invalid login!";
}
?>