<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

// SEARCH + FILTER
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

$sql = "SELECT * FROM bookings WHERE 1";

if ($search) {
    $sql .= " AND name LIKE '%$search%'";
}

if ($status) {
    $sql .= " AND status='$status'";
}

$sql .= " ORDER BY id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Bookings</title>
<link rel="stylesheet" href="style.css">

<style>
.container {
  max-width: 1100px;
  margin: 40px auto;
}

.search-box {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}

input, select {
  padding: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
}

button {
  padding: 8px 12px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.search-btn {
  background: #8b6b4a;
  color: white;
}

.delete-btn {
  background: red;
  color: white;
}

.approve-btn {
  background: green;
  color: white;
}

table {
  width: 100%;
  border-collapse: collapse;
  background: white;
}

th {
  background: #8b6b4a;
  color: white;
}

th, td {
  padding: 10px;
  text-align: center;
}

tr:nth-child(even) {
  background: #f3e9dc;
}

.status-paid { color: green; font-weight: bold; }
.status-pending { color: orange; font-weight: bold; }
</style>

</head>

<body>

<header>
  <h2>Manage Bookings</h2>
  <nav>
    <a href="admin.php">Dashboard</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<div class="container">

<h2>Bookings</h2>

<form method="GET" class="search-box">
  <input type="text" name="search" placeholder="Search name..." value="<?= $search ?>">
  
  <select name="status">
    <option value="">All</option>
    <option value="Paid" <?= ($status=="Paid")?"selected":"" ?>>Paid</option>
    <option value="Pending" <?= ($status=="Pending")?"selected":"" ?>>Pending</option>
  </select>

  <button class="search-btn">Search</button>
</form>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Service</th>
<th>Therapist</th>
<th>Room</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Actions</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['name'] ?></td>
<td><?= $row['service'] ?></td>
<td><?= $row['therapist'] ?></td>
<td><?= $row['room'] ?></td>
<td><?= $row['date'] ?></td>
<td><?= $row['time'] ?></td>

<td>
<?php if($row['status']=="Paid"): ?>
<span class="status-paid">Paid</span>
<?php else: ?>
<span class="status-pending">Pending</span>
<?php endif; ?>
</td>

<td>

<!-- APPROVE -->
<form method="POST" action="approve_booking.php" style="display:inline;">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<button class="approve-btn">Approve</button>
</form>

<!-- DELETE -->
<form method="POST" action="delete_booking.php" style="display:inline;">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<button class="delete-btn">Delete</button>
</form>

</td>

</tr>
<?php endwhile; ?>

</table>

</div>

</body>