<?php

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$date = $_GET['date'];
$therapist = $_GET['therapist'];

$sql = "SELECT time FROM bookings 
        WHERE date='$date' 
        AND therapist='$therapist'";

$result = $conn->query($sql);

$bookedTimes = [];

while($row = $result->fetch_assoc()) {
    $bookedTimes[] = $row['time'];
}

echo json_encode($bookedTimes);

$conn->close();
?>