<?php
$conn = new mysqli("localhost", "root", "", "spa_system", 3307);
$result = $conn->query("SELECT * FROM therapists");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Therapists - Mizpah Wellness Spa</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<style>

body{
  margin:0;
  font-family:Poppins;
  background:#f5f2ee;
}

/* HEADER */
header{
  display:flex;
  justify-content:space-between;
  padding:15px 40px;
  background:white;
  box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* TITLE SECTION */
.page-title{
  text-align:center;
  padding:40px 20px 10px;
}

.page-title h2{
  font-family:"Playfair Display";
  color:#8b6b4a;
  font-size:32px;
}

/* GRID */
.container{
  max-width:1100px;
  margin:auto;
  padding:20px;
}

.grid{
  display:grid;
  grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));
  gap:20px;
}

/* CARD */
.card{
  background:white;
  border-radius:15px;
  overflow:hidden;
  box-shadow:0 5px 15px rgba(0,0,0,0.08);
  transition:0.3s;
}

.card:hover{
  transform:translateY(-5px);
}

.card img{
  width:100%;
  height:250px;
  object-fit:cover;
}

.card-body{
  padding:15px;
  text-align:center;
}

.card-body h3{
  margin:10px 0 5px;
  color:#333;
}

.rating{
  color:gold;
  margin:5px 0;
}

.specialty{
  font-size:14px;
  color:#666;
}

.badge{
  display:inline-block;
  margin-top:8px;
  padding:5px 10px;
  background:#8b6b4a;
  color:white;
  font-size:12px;
  border-radius:20px;
}

</style>

</head>

<body>

<header>
  <h2>Mizpah Wellness Spa</h2>
  <nav>
    <a href="index.html">Home</a>
  </nav>
</header>

<div class="page-title">
  <h2>Our Expert Therapists</h2>
  <p>Choose your perfect wellness partner</p>
</div>

<div class="container">

<div class="grid">

<?php while($row = $result->fetch_assoc()): ?>

<div class="card">

  <img src="uploads/<?= $row['image'] ?>">

  <div class="card-body">

    <h3><?= $row['name'] ?></h3>

    <div class="rating">
      <?= str_repeat("⭐", $row['rating']) ?>
    </div>

    <div class="specialty">
      <?= $row['specialty'] ?>
    </div>

    <div class="badge">
      Available Therapist
    </div>

  </div>

</div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>