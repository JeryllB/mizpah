<?php
$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

$id = $_POST['id'];

$sql = "UPDATE bookings 
        SET status='Approved' 
        WHERE id='$id'";

$conn->query($sql);

header("Location: view_bookings.php");
?>