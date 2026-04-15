<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

/* =========================
   FETCH DONE BOOKINGS ONLY
========================= */
$result = $conn->query("
SELECT * FROM bookings 
WHERE status='Done'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Booking History</title>

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
  font-weight: 500;
  margin-left: 15px;
}

header a:hover {
  color: #5a3e2b;
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
.status-done {
  color: gray;
  font-weight: bold;
}
</style>

</head>

<body>

<header>
  <h2>Booking History (Done Services)</h2>
  <div>
    <a href="view_bookings.php">← Back</a>
    <a href="admin.php">Dashboard</a>
    <a href="logout.php">Logout</a>
  </div>
</header>

<div class="container">

<table>
<tr>
<th>Name</th>
<th>Service</th>
<th>Therapist</th>
<th>Date</th>
<th>Time</th>
<th>Amount</th>
<th>Status</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['name'] ?></td>
<td><?= $row['service'] ?></td>
<td><?= $row['therapist'] ?></td>
<td><?= $row['date'] ?></td>
<td><?= $row['time'] ?></td>
<td>₱<?= number_format($row['amount'] ?? 0,2) ?></td>
<td class="status-done">Done</td>
</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>