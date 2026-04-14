<?php
$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

$id = $_POST['id'];

// set as DONE
$sql = "UPDATE bookings 
        SET status='Done', finished_at=NOW() 
        WHERE id='$id'";

if ($conn->query($sql)) {
    header("Location: view_bookings.php");
} else {
    echo "Error: " . $conn->error;
}
?>