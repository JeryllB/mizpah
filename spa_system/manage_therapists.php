<?php
$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $rating = $_POST['rating'];

    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);

    $conn->query("INSERT INTO therapists (name,specialty,image,rating)
                  VALUES ('$name','$specialty','$image','$rating')");
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM therapists WHERE id=$id");
}

$result = $conn->query("SELECT * FROM therapists");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Therapists</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

<style>

body{
  margin:0;
  font-family:Poppins;
  background:#f5f2ee;
}

/* HEADER */
header{
  background:white;
  padding:15px 40px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

header a{
  margin-left:15px;
  text-decoration:none;
  color:#8b6b4a;
  font-weight:500;
}

/* CONTAINER */
.container{
  max-width:1100px;
  margin:30px auto;
  padding:0 20px;
}

/* GRID LAYOUT */
.grid{
  display:grid;
  grid-template-columns:1fr 2fr;
  gap:20px;
}

/* CARD */
.card{
  background:white;
  padding:20px;
  border-radius:12px;
  box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

/* FORM */
input{
  width:100%;
  padding:10px;
  margin-bottom:10px;
  border:1px solid #ddd;
  border-radius:8px;
}

button{
  width:100%;
  padding:10px;
  border:none;
  background:#8b6b4a;
  color:white;
  border-radius:8px;
  cursor:pointer;
}

button:hover{
  background:#6f543a;
}

/* TABLE */
table{
  width:100%;
  border-collapse:collapse;
}

th{
  background:#8b6b4a;
  color:white;
  padding:10px;
}

td{
  text-align:center;
  padding:10px;
}

tr:nth-child(even){
  background:#f3e9dc;
}

/* IMAGE */
img{
  width:60px;
  height:60px;
  object-fit:cover;
  border-radius:8px;
}

/* DELETE */
.delete-btn{
  background:red;
  padding:5px 8px;
  border:none;
  color:white;
  border-radius:5px;
  cursor:pointer;
}

</style>

</head>

<body>

<header>
  <h3>Manage Therapists</h3>
  <div>
    <a href="view_bookings.php">Dashboard</a>
    <a href="logout.php">Logout</a>
  </div>
</header>

<div class="container">

<div class="grid">

<!-- LEFT: FORM -->
<div class="card">
  <h3 style="color:#8b6b4a;">Add Therapist</h3>

  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="specialty" placeholder="Specialty" required>
    <input type="number" name="rating" placeholder="Rating (1-5)" min="1" max="5" required>
    <input type="file" name="image" required>
    <button name="add">Add Therapist</button>
  </form>
</div>

<!-- RIGHT: TABLE -->
<div class="card">
  <h3 style="color:#8b6b4a;">Therapist List</h3>

  <table>
    <tr>
      <th>Image</th>
      <th>Name</th>
      <th>Specialty</th>
      <th>Rating</th>
      <th>Action</th>
    </tr>

    <?php while($row=$result->fetch_assoc()): ?>
    <tr>
      <td><img src="uploads/<?= $row['image'] ?>"></td>
      <td><?= $row['name'] ?></td>
      <td><?= $row['specialty'] ?></td>
      <td><?= str_repeat("⭐",$row['rating']) ?></td>
      <td>
        <a href="?delete=<?= $row['id'] ?>">
          <button class="delete-btn">X</button>
        </a>
      </td>
    </tr>
    <?php endwhile; ?>

  </table>

</div>

</div>

</div>

</body>
</html>