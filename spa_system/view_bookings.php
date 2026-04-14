<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

// DASHBOARD STATS
$totalBookings = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'];
$pending = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status='Pending'")->fetch_assoc()['total'];
$approved = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status='Approved'")->fetch_assoc()['total'];
$done = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status='Done'")->fetch_assoc()['total'];

// SEARCH
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
<title>Admin Dashboard</title>
<link rel="stylesheet" href="style.css">

<style>
body {
  font-family: Poppins;
  background: #f5f2ee;
}

/* HEADER */
header {
  display: flex;
  justify-content: space-between;
  padding: 20px 40px;
  background: white;
}

/* DASHBOARD */
.dashboard {
  display: flex;
  gap: 20px;
  padding: 20px 40px;
}

.card {
  flex: 1;
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  text-align: center;
}

.card h3 {
  color: #8b6b4a;
}

/* BUTTON INSIDE CARD */
.card button {
  margin-top: 10px;
  background: #8b6b4a;
  color: white;
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
}

th, td {
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
.delete-btn { background: red; color: white; }

/* STATUS COLORS */
.status-pending { color: orange; font-weight: bold; }
.status-approved { color: blue; font-weight: bold; }
.status-done { color: gray; font-weight: bold; }

/* SEARCH */
.search-box {
  margin-bottom: 15px;
}
</style>

</head>

<body>

<header>
  <h2>Mizpah Admin Dashboard</h2>
  <div>
    <a href="index.html">View Site</a> |
    <a href="logout.php">Logout</a>
  </div>
</header>

<!-- DASHBOARD CARDS -->
<div class="dashboard">

  <div class="card">
    <h3><?= $totalBookings ?></h3>
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

  <!-- ✅ NEW CARD -->
  <div class="card">
    <h3>👩‍⚕️</h3>
    <p>Therapists</p>
    <a href="manage_therapists.php">
      <button>Manage</button>
    </a>
  </div>

</div>

<!-- BOOKINGS -->
<div class="container">

<h2>Manage Bookings</h2>

<form method="GET" class="search-box">
  <input type="text" name="search" placeholder="Search name..." value="<?= $search ?>">
  
  <select name="status">
    <option value="">All</option>
    <option value="Pending" <?= ($status=="Pending")?"selected":"" ?>>Pending</option>
    <option value="Approved" <?= ($status=="Approved")?"selected":"" ?>>Approved</option>
    <option value="Done" <?= ($status=="Done")?"selected":"" ?>>Done</option>
  </select>

  <button>Search</button>
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
<th>Action</th>
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
<?php if($row['status']=="Pending"): ?>
<span class="status-pending">Pending</span>
<?php elseif($row['status']=="Approved"): ?>
<span class="status-approved">Approved</span>
<?php elseif($row['status']=="Done"): ?>
<span class="status-done">Done</span>
<?php endif; ?>
</td>

<td>

<?php if($row['status']=="Pending"): ?>
<form method="POST" action="approve_booking.php" style="display:inline;">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<button class="approve-btn">Approve</button>
</form>
<?php endif; ?>

<?php if($row['status']=="Approved"): ?>
<form method="POST" action="done_booking.php" style="display:inline;">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<button class="done-btn">Done</button>
</form>
<?php endif; ?>

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
</html>