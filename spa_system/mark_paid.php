<?php
$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

$id = $_POST['id'];

$conn->query("
  UPDATE bookings 
  SET payment_status='Paid' 
  WHERE id='$id'
");

header("Location: view_bookings.php");