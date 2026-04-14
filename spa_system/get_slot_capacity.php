<?php
$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

$date = $_GET['date'];
$time = $_GET['time'];

// total bookings for this slot
$sql = "SELECT COUNT(*) as total FROM bookings 
        WHERE date='$date' 
        AND time='$time'";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

$total = $row['total'];

// SPA CAPACITY (EDIT MO TO BASED SA BUSINESS)
$MAX_CAPACITY = 8;

echo json_encode([
    "available" => ($total < $MAX_CAPACITY),
    "remaining" => $MAX_CAPACITY - $total
]);
?>