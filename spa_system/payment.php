<?php
$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get latest booking
$sql = "SELECT * FROM bookings ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$booking = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment - Mizpah Wellness Spa</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<style>
.payment-container {
  display: flex;
  gap: 30px;
  padding: 50px;
  max-width: 1100px;
  margin: auto;
}

.payment-left {
  flex: 2;
  background: white;
  padding: 30px;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.payment-right {
  flex: 1;
  background: white;
  padding: 25px;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.section-title {
  background: linear-gradient(to right, #8b6b4a, #c2a27a);
  color: white;
  padding: 12px;
  border-radius: 10px;
  margin-bottom: 20px;
}

.option-box {
  border: 1px solid #ddd;
  border-radius: 15px;
  padding: 15px;
  margin-bottom: 15px;
}

.complete-btn {
  margin-top: 20px;
  width: 100%;
  padding: 14px;
  border: none;
  border-radius: 12px;
  background: linear-gradient(to right, #8b6b4a, #c2a27a);
  color: white;
  font-size: 16px;
  cursor: pointer;
}
</style>

</head>

<body>

<header>
  <h2>Mizpah Wellness Spa</h2>
  <nav>
    <a href="booking.html">← Back to Booking</a>
  </nav>
</header>

<div class="payment-container">

  <!-- LEFT -->
  <div class="payment-left">

    <div class="section-title">Payment Options</div>

    <div class="option-box">
      <label>
        <input type="radio" name="payment" value="gcash" checked>
        GCash Payment
      </label>
    </div>

    <div class="option-box">
      <label>
        <input type="radio" name="payment" value="spa">
        Pay at Spa
      </label>
    </div>

    <button class="complete-btn" onclick="completePayment()">
      Complete Payment
    </button>

  </div>

  <!-- RIGHT -->
  <div class="payment-right">

    <div class="section-title">Booking Summary</div>

    <p><strong>Service:</strong> <?php echo $booking['service']; ?></p>
    <p><strong>Therapist:</strong> <?php echo $booking['therapist']; ?></p>
    <p><strong>Room:</strong> <?php echo $booking['room']; ?></p>
    <p><strong>Date:</strong> <?php echo $booking['date']; ?></p>
    <p><strong>Time:</strong> <?php echo $booking['time']; ?></p>

    <p><strong>Status:</strong> Pending Payment</p>

  </div>

</div>

<script>
function completePayment() {
  window.location.href = "process_payment.php";
}
</script>

</body>
</html>