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

    // CHECK CONFLICT (IMPORTANT)
    $check = $conn->prepare("
        SELECT id FROM bookings 
        WHERE date=? 
        AND time=? 
        AND therapist=?
    ");

    $check->bind_param("sss", $date, $time, $therapist);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
            alert('❌ Slot already taken!');
            window.location.href='booking.php';
        </script>";
        exit();
    }

    // INSERT BOOKING
    $insert = $conn->prepare("
        INSERT INTO bookings 
        (user_id, name, email, service, therapist, room, date, time, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')
    ");

    $insert->bind_param(
        "isssssss",
        $user_id,
        $name,
        $email,
        $service,
        $therapist,
        $room,
        $date,
        $time
    );

    if ($insert->execute()) {
        echo "<script>
            alert('✅ Booking Successful!');
            window.location.href='payment.php';
        </script>";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>