<?php
session_start();

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

$id = $_POST['id'];

$conn->query("UPDATE bookings SET status='Paid' WHERE id=$id");

header("Location: view_bookings.php");
exit();