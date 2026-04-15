<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

/* =========================
   FETCH BOOKINGS (FIXED)
   - EXCLUDE DONE
========================= */
$result = $conn->query("
SELECT * FROM bookings 
WHERE status != 'Done'
ORDER BY id DESC
");

/* =========================
   STATS
========================= */
$total = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'];
$pending = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status='Pending'")->fetch_assoc()['total'];
$approved = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status='Approved'")->fetch_assoc()['total'];
$done = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status='Done'")->fetch_assoc()['total'];

/* =========================
   PAYMENT STATS (SAFE)
========================= */
$paid = 0;
$unpaid = 0;

$check = $conn->query("SHOW COLUMNS FROM bookings LIKE 'payment_status'");
if ($check && $check->num_rows > 0) {

    $paid = $conn->query("
        SELECT COUNT(*) as total 
        FROM bookings 
        WHERE payment_status='Paid'
    ")->fetch_assoc()['total'];

    $unpaid = $conn->query("
        SELECT COUNT(*) as total 
        FROM bookings 
        WHERE payment_status='Unpaid'
    ")->fetch_assoc()['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Bookings</title>

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
  flex: 1;
  min-width: 150px;
  background: white;
  padding: 20px;
  border-radius: 12px;
  text-align: center;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.card h3 {
  margin: 0;
  color: #8b6b4a;
}

/* TABLE */
.container {
  padding: 20px 40px;
}

table {
  width: 100%;
  background: white;
  border-collapse: collapse;
}

th {
  background: #8b6b4a;
  color: white;
  padding: 10px;
}

td {
  padding: 10px;
  text-align: center;
}

tr:nth-child(even) {
  background: #f3e9dc;
}

/* BUTTONS */
button {
  padding: 6px 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.approve-btn { background: green; color: white; }
.done-btn { background: blue; color: white; }
.pay-btn { background: #1f8b4c; color: white; }
.delete-btn { background: red; color: white; }

/* STATUS */
.status-pending { color: orange; font-weight: bold; }
.status-approved { color: blue; font-weight: bold; }
.status-done { color: gray; font-weight: bold; }
</style>

</head>

<body>

<header>
  <h2>Manage Bookings</h2>
  <div>
    <a href="admin.php">Back to Dashboard</a>
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

  <div class="card">
    <h3><?= $paid ?></h3>
    <p>Paid</p>
  </div>

  <div class="card">
    <h3><?= $unpaid ?></h3>
    <p>Unpaid</p>
  </div>

</div>

<!-- TABLE -->
<div class="container">

<table>
<tr>
<th>Name</th>
<th>Service</th>
<th>Therapist</th>
<th>Room</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Payment</th>
<th>Amount</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>

<td><?= $row['name'] ?></td>
<td><?= $row['service'] ?></td>
<td><?= $row['therapist'] ?></td>
<td><?= $row['room'] ?></td>
<td><?= $row['date'] ?></td>
<td><?= $row['time'] ?></td>

<td>
<?php if($row['status']=="Pending"): ?>
<span class="status-pending">Pending</span>
<?php elseif($row['status']=="Approved"): ?>
<span class="status-approved">Approved</span>
<?php else: ?>
<span class="status-done">Done</span>
<?php endif; ?>
</td>

<td><?= $row['payment_status'] ?? 'Unpaid' ?></td>
<td>₱<?= number_format($row['amount'] ?? 0,2) ?></td>

<td>

<?php if($row['status']=="Pending"): ?>
<form method="POST" action="approve_booking.php" style="display:inline;">
  <input type="hidden" name="id" value="<?= $row['id'] ?>">
  <button type="submit" class="approve-btn">Approve</button>
</form>
<?php endif; ?>

<?php if($row['status']!="Done"): ?>
<form method="POST" action="done_booking.php" style="display:inline;">
  <input type="hidden" name="id" value="<?= $row['id'] ?>">
  <button type="submit" class="done-btn">Done</button>
</form>
<?php endif; ?>

<?php if(($row['payment_status'] ?? 'Unpaid') != "Paid"): ?>
<form method="POST" action="mark_paid.php" style="display:inline;">
  <input type="hidden" name="id" value="<?= $row['id'] ?>">
  <button type="submit" class="pay-btn">Mark Paid</button>
</form>
<?php endif; ?>

<form method="POST" action="delete_booking.php" style="display:inline;">
  <input type="hidden" name="id" value="<?= $row['id'] ?>">
  <button type="submit" class="delete-btn">Delete</button>
</form>

</td>

</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>