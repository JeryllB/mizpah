<?php

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "STEP 1 OK<br>";

// Check POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    echo "STEP 2 DB CONNECTED<br>";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $service = $_POST['service'];
    $therapist = $_POST['therapist'];
    $room = $_POST['room'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    echo "STEP 3 POST DETECTED<br>";

    // 🔥 STEP 4: CHECK AVAILABILITY
    $checkSql = "SELECT * FROM bookings 
                 WHERE therapist='$therapist' 
                 AND date='$date' 
                 AND time='$time'";

    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        // ❌ may conflict
        echo "❌ This slot is already booked!";
    } else {

        // ✅ insert booking
        $sql = "INSERT INTO bookings 
        (name, email, service, therapist, room, date, time)
        VALUES 
        ('$name', '$email', '$service', '$therapist', '$room', '$date', '$time')";

        if ($conn->query($sql) === TRUE) {
            echo "✅ Booking Saved Successfully!";
        } else {
            echo "❌ Error: " . $conn->error;
        }
    }

} else {
    echo "❌ NOT POST METHOD";
}

$conn->close();
?>