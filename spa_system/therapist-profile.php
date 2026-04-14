<?php
$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM therapists WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile</title>
</head>

<body>

<h2><?= $row['name'] ?></h2>
<img src="uploads/<?= $row['image'] ?>" width="200">
<p>Specialty: <?= $row['specialty'] ?></p>
<p>Rating: <?= str_repeat("⭐",$row['rating']) ?></p>

<a href="booking.html">Book Now</a>

</body>
</html>