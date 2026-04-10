<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

// STATS
$total = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'];
$paid = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status='Paid'")->fetch_assoc()['total'];
$pending = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status='Pending'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="style.css">

<style>
.stats {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 30px;
}

.card {
  background: white;
  padding: 20px;
  border-radius: 15px;
  width: 200px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.card h3 {
  margin: 0;
}

.card p {
  font-size: 24px;
  color: #8b6b4a;
}
</style>

</head>

<body>

<header>
  <h2>Admin Dashboard</h2>
  <nav>
    <a href="index.html">Home</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<div style="text-align:center; padding:40px;">
  <h1>Welcome Admin </h1>

  <div class="stats">
    <div class="card">
      <h3>Total Bookings</h3>
      <p><?= $total ?></p>
    </div>

    <div class="card">
      <h3>Paid</h3>
      <p><?= $paid ?></p>
    </div>

    <div class="card">
      <h3>Pending</h3>
      <p><?= $pending ?></p>
    </div>
  </div>

  <br><br>

  <a href="view_bookings.php">
    <button class="btn-primary">Manage Bookings</button>
  </a>

</div>

</body>
</html>