<?php
$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

$result = $conn->query("SELECT * FROM bookings ORDER BY id DESC LIMIT 1");
$booking = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment - Mizpah Wellness Spa</title>

<link rel="stylesheet" href="style.css">

<style>
.payment-container {
  display: flex;
  gap: 30px;
  padding: 50px;
  max-width: 1100px;
  margin: auto;
}

.payment-left, .payment-right {
  background: white;
  padding: 25px;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.payment-left { flex: 2; }
.payment-right { flex: 1; }

.section-title {
  background: #8b6b4a;
  color: white;
  padding: 10px;
  border-radius: 10px;
  margin-bottom: 15px;
}

.option-box {
  border: 1px solid #ddd;
  padding: 15px;
  border-radius: 10px;
  margin-bottom: 10px;
}

.complete-btn {
  width: 100%;
  padding: 12px;
  background: #8b6b4a;
  color: white;
  border: none;
  border-radius: 10px;
  cursor: pointer;
}
</style>
</head>

<body>

<header>
  <h2>Mizpah Wellness Spa</h2>
</header>

<div class="payment-container">

<div class="payment-left">
  <div class="section-title">Payment Options</div>

  <div class="option-box">
    <input type="radio" name="payment" value="gcash" checked> GCash
  </div>

  <div class="option-box">
    <input type="radio" name="payment" value="spa"> Pay at Spa
  </div>

  <button class="complete-btn" onclick="completePayment()">Complete Payment</button>
</div>

<div class="payment-right">
  <div class="section-title">Booking Summary</div>

  <p><b>Name:</b> <?= $booking['name'] ?></p>
  <p><b>Service:</b> <?= $booking['service'] ?></p>
  <p><b>Therapist:</b> <?= $booking['therapist'] ?></p>
  <p><b>Room:</b> <?= $booking['room'] ?></p>
  <p><b>Date:</b> <?= $booking['date'] ?></p>
  <p><b>Time:</b> <?= $booking['time'] ?></p>

  <p><b>Status:</b> Pending Payment</p>
</div>

</div>

<script>
function completePayment() {

  const selected = document.querySelector('input[name="payment"]:checked').value;

  if (selected === "gcash") {
    alert("Redirecting to GCash...");
    window.location.href = "process_payment.php?method=gcash";
  } else {
    window.location.href = "process_payment.php?method=spa";
  }

}
</script>

</body>
</html>