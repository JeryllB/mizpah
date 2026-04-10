<?php

$status = $_GET['status'];
$receipt = $_GET['receipt'];

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);
$result = $conn->query("SELECT * FROM bookings ORDER BY id DESC LIMIT 1");
$booking = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking Confirmation - Mizpah Wellness Spa</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<style>
body {
  background: #f8f5f1;
  font-family: 'Poppins', sans-serif;
}

.container {
  max-width: 700px;
  margin: 60px auto;
  background: white;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 15px 40px rgba(0,0,0,0.1);
  text-align: center;
}

.title {
  font-family: 'Playfair Display', serif;
  font-size: 28px;
  margin-bottom: 10px;
}

.status {
  font-size: 20px;
  margin-bottom: 20px;
  font-weight: 500;
}

.success {
  color: green;
}

.pending {
  color: #c58b3a;
}

.details {
  text-align: left;
  margin-top: 20px;
  line-height: 1.8;
}

.details p {
  border-bottom: 1px solid #eee;
  padding: 8px 0;
}

.receipt-box {
  margin-top: 25px;
  padding: 15px;
  background: #f3e9dc;
  border-radius: 12px;
  font-weight: bold;
  letter-spacing: 1px;
}

.btn-home {
  margin-top: 25px;
  display: inline-block;
  padding: 12px 25px;
  border-radius: 10px;
  background: linear-gradient(to right, #8b6b4a, #c2a27a);
  color: white;
  text-decoration: none;
}
</style>

</head>

<body>

<div class="container">

  <div class="title">Mizpah Wellness Spa</div>

  <?php if($status == "Paid"): ?>
    <div class="status success">✅ Payment Successful!</div>
  <?php else: ?>
    <div class="status pending">🕒 Booking Confirmed (Pay at Spa)</div>
  <?php endif; ?>

  <div class="details">
    <p><strong>Name:</strong> <?= $booking['name'] ?></p>
    <p><strong>Service:</strong> <?= $booking['service'] ?></p>
    <p><strong>Therapist:</strong> <?= $booking['therapist'] ?></p>
    <p><strong>Room:</strong> <?= $booking['room'] ?></p>
    <p><strong>Date:</strong> <?= $booking['date'] ?></p>
    <p><strong>Time:</strong> <?= $booking['time'] ?></p>
  </div>

  <div class="receipt-box">
    Receipt #: <?= $receipt ?>
  </div>

  <a href="index.html" class="btn-home">Back to Home</a>

</div>

</body>
</html>