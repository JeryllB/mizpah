<?php

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

$method = $_GET['method'];

$result = $conn->query("SELECT * FROM bookings ORDER BY id DESC LIMIT 1");
$booking = $result->fetch_assoc();

$status = "Pending";

if ($method == "gcash") {
    $status = "Paid";
    $conn->query("UPDATE bookings SET status='Paid' WHERE id=" . $booking['id']);
}

// receipt number
$receipt = "SPA-" . rand(100000,999999);

header("Location: confirmation.php?status=$status&receipt=$receipt");
exit();