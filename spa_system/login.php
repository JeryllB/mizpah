<?php
session_start();

$conn = new mysqli("localhost","root","","spa_system",3307);

$email = $_POST['email'];
$password = $_POST['password'];

$result = $conn->query("SELECT * FROM users WHERE email='$email'");

if ($result->num_rows == 0) {
    echo "Invalid login";
    exit();
}

$user = $result->fetch_assoc();

if (password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == "admin") {
        header("Location: admin.php");
    } else {
        header("Location: booking.php");
    }

    exit();

} else {
    echo "Invalid login";
}
?>