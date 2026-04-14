<?php
$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

$date = $_GET['date'];
$therapist = $_GET['therapist'];

$sql = "SELECT time FROM bookings 
        WHERE date='$date' 
        AND therapist='$therapist'
        AND status != 'Done'"; // 🔥 KEY PART

$result = $conn->query($sql);

$booked = [];

while($row = $result->fetch_assoc()){
    $booked[] = $row['time'];
}

echo json_encode($booked);
?>