<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

$total = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'];
$pending = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status='Pending'")->fetch_assoc()['total'];
$approved = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status='Approved'")->fetch_assoc()['total'];
$done = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status='Done'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

<style>
body {
  font-family: Poppins;
  background: #f5f2ee;
  margin: 0;
}

/* HEADER */
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 40px;
  background: white;
}

header h2 {
  margin: 0;
}

/* HEADER LINKS (NO BLUE, NO UNDERLINE) */
header a {
  text-decoration: none;
  color: #8b6b4a;
  margin-left: 15px;
  font-weight: 500;
}

header a:hover {
  color: #5a3e2b;
}

/* DASHBOARD */
.dashboard {
  display: flex;
  gap: 15px;
  padding: 20px 40px;
  flex-wrap: wrap;
}

.card {
  background: white;
  padding: 20px;
  border-radius: 12px;
  text-align: center;
  flex: 1;
  min-width: 150px;
}

.card h3 {
  margin: 0;
  color: #8b6b4a;
}

/* ACTIONS */
.actions {
  display: flex;
  justify-content: center;
  gap: 20px;
  padding: 40px;
  flex-wrap: wrap;
}

.btn {
  background: #8b6b4a;
  color: white;
  padding: 12px 20px;
  border-radius: 8px;
  text-decoration: none;
  transition: 0.3s;
}

.btn:hover {
  background: #5a3e2b;
}
</style>

</head>

<body>

<header>
  <h2>Mizpah Admin Dashboard</h2>
  <div>
    <a href="index.php">View Site</a>
    <a href="history_bookings.php">Booking History</a>
    <a href="logout.php">Logout</a>
  </div>
</header>

<!-- DASHBOARD -->
<div class="dashboard">

  <div class="card">
    <h3><?= $total ?></h3>
    <p>Total Bookings</p>
  </div>

  <div class="card">
    <h3><?= $pending ?></h3>
    <p>Pending</p>
  </div>

  <div class="card">
    <h3><?= $approved ?></h3>
    <p>Approved</p>
  </div>

  <div class="card">
    <h3><?= $done ?></h3>
    <p>Done</p>
  </div>

</div>

<!-- ACTION BUTTONS -->
<div class="actions">

  <a class="btn" href="view_bookings.php">Manage Bookings</a>
  <a class="btn" href="manage_therapists.php">Manage Therapists</a>
  <a class="btn" href="manage_services.php">Manage Services</a>

</div>

</body>
</html>