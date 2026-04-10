<?php

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all DISTINCT booked dates
$sql = "SELECT DISTINCT date FROM bookings";
$result = $conn->query($sql);

$dates = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $dates[] = $row['date'];
    }
}

// Return as JSON
echo json_encode($dates);

$conn->close();
?>