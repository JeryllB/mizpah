<?php
session_start();

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    die("❌ Not logged in");
}

$user_id = $_SESSION['user_id'];

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
                 WHERE date='$date' 
                 AND time='$time' 
                 AND (therapist='$therapist' OR room='$room')";

    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {

        echo "❌ Slot already booked";
        exit();

    } else {

        // INSERT FIXED (IMPORTANT)
        $sql = "INSERT INTO bookings 
        (user_id, name, email, service, therapist, room, date, time, status)
        VALUES 
        ('$user_id', '$name', '$email', '$service', '$therapist', '$room', '$date', '$time', 'Pending')";

        if ($conn->query($sql) === TRUE) {

            echo "<script>
                alert('Booking Successful!');
                window.location.href='payment.php';
            </script>";
            exit();

        } else {
            echo "❌ Error: " . $conn->error;
        }
    }

} else {
    echo "❌ Invalid request";
}
?>