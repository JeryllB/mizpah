<?php
session_start();

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

$user_id = $_SESSION['user_id'];

$result = $conn->query("
SELECT * FROM bookings 
WHERE user_id='$user_id'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Bookings</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

<style>
body {
  font-family: Poppins;
  background: #f5f2ee;
  margin: 0;
}

header {
  display: flex;
  justify-content: space-between;
  padding: 20px 40px;
  background: white;
}

header a {
  text-decoration: none;
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

/* STATUS */
.pending { color: orange; font-weight: bold; }
.approved { color: blue; font-weight: bold; }
.done { color: green; font-weight: bold; }
</style>

</head>

<body>

<header>
  <h2>My Bookings</h2>
  <div>
    <a href="booking.php">Book Again</a>
    <a href="logout.php">Logout</a>
  </div>
</header>

<div class="container">

<table>
<tr>
<th>Service</th>
<th>Therapist</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Payment</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>

<td><?= $row['service'] ?></td>
<td><?= $row['therapist'] ?></td>
<td><?= $row['date'] ?></td>
<td><?= $row['time'] ?></td>

<td>
<?php if($row['status']=="Pending"): ?>
<span class="pending">Waiting Approval</span>

<?php elseif($row['status']=="Approved"): ?>
<span class="approved">Confirmed</span>

<?php else: ?>
<span class="done">Completed</span>
<?php endif; ?>
</td>

<td>
<?= $row['payment_status'] ?? 'Unpaid' ?>
</td>

</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>