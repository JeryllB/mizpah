<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
  <h2>Admin Dashboard</h2>
  <nav>
    <a href="index.html">Home</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<div style="padding:40px; text-align:center;">
  <h1>Welcome Admin 👑</h1>
  <p>Here you can manage bookings</p>

  <h3>Sample Controls</h3>
  <button class="btn-primary">View All Bookings</button>
  <button class="btn-outline">Manage Therapists</button>
</div>

</body>
</html>