<?php
$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

$id = $_POST['id'];

/* mark as done */
$conn->query("UPDATE bookings SET status='Done' WHERE id='$id'");

header("Location: view_bookings.php");
?>