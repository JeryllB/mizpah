<?php
$conn = new mysqli("localhost","root","","spa_system",3307);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = "client";

    $conn->query("INSERT INTO users (name,email,password,role)
    VALUES ('$name','$email','$password','$role')");

    echo "<script>
        alert('Registered Successfully!');
        window.location.href='login.html';
    </script>";
}
?>