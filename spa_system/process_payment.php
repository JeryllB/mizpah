<?php

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// latest booking
$sql = "SELECT id FROM bookings ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $id = $row['id'];

    $update = "UPDATE bookings SET status='Paid' WHERE id=$id";

    if ($conn->query($update) === TRUE) {
        echo "✅ Payment Successful! Booking Confirmed.";
    } else {
        echo "❌ Error updating payment.";
    }

} else {
    echo "No booking found.";
}

$conn->close();
?>