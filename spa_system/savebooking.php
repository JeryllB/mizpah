<?php

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $service = $_POST['service'];
    $therapist = $_POST['therapist'];
    $room = $_POST['room'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // conflict check
    $checkSql = "SELECT * FROM bookings 
                 WHERE date = '$date' 
                 AND time = '$time' 
                 AND (therapist = '$therapist' OR room = '$room')";

    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {

        echo "❌ Conflict detected! Therapist or Room already booked at this time.";

    } else {

        $sql = "INSERT INTO bookings 
        (name, email, service, therapist, room, date, time, status)
        VALUES 
        ('$name', '$email', '$service', '$therapist', '$room', '$date', '$time', 'Pending')";

        if ($conn->query($sql) === TRUE) {

            // ✅ FINAL REDIRECT (NO ALERT)
            header("Location: payment.php");
            exit();

        } else {
            echo "❌ Error: " . $conn->error;
        }

    }

} else {
    echo "❌ NOT POST METHOD";
}

$conn->close();
?>