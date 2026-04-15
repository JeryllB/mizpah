<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "spa_system", 3307);

$services = $conn->query("SELECT * FROM services ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Services</title>
<link rel="stylesheet" href="style.css">

<style>
body {
  font-family: Poppins;
  background: #f5f2ee;
}

.container {
  padding: 40px;
}

.card {
  background: white;
  padding: 20px;
  border-radius: 12px;
  margin-bottom: 20px;
}

button {
  background: #8b6b4a;
  color: white;
  padding: 6px 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
</style>

</head>

<body>

<div class="container">

<h2>🛠 Manage Services</h2>

<!-- ADD -->
<form method="POST" action="add_service.php" enctype="multipart/form-data">
  <input type="text" name="name" placeholder="Service Name" required>
  <input type="text" name="duration" placeholder="Duration" required>
  <input type="text" name="price" placeholder="Price" required>
  <input type="file" name="image" required>
  <br><br>
  <input type="text" name="description" placeholder="Description" style="width:300px;" required>
  <br><br>
  <button>Add Service</button>
</form>

<hr>

<!-- LIST -->
<table width="100%" border="1" cellpadding="10">
<tr>
<th>Name</th>
<th>Duration</th>
<th>Price</th>
<th>Action</th>
</tr>

<?php while($s = $services->fetch_assoc()): ?>
<tr>

<td><?= $s['name'] ?></td>
<td><?= $s['duration'] ?></td>
<td><?= $s['price'] ?></td>

<td>
<a href="edit_service.php?id=<?= $s['id'] ?>">
<button>Edit</button>
</a>

<form method="POST" action="delete_service.php" style="display:inline;">
<input type="hidden" name="id" value="<?= $s['id'] ?>">
<button>Delete</button>
</form>
</td>

</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>