<?php
session_start();

$conn = new mysqli("127.0.0.1", "root", "", "spa_system", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // check user in database
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        // store session
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];

        // redirect based on role
        if ($row['role'] == "admin") {
            header("Location: admin.html");
            exit();
        } else {
            header("Location: booking.html");
            exit();
        }

    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>

<style>
body {
  font-family: Arial;
  background: #f5f2ee;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.box {
  background: white;
  padding: 30px;
  border-radius: 10px;
  width: 300px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

input {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
}

button {
  width: 100%;
  padding: 10px;
  background: black;
  color: white;
  border: none;
  cursor: pointer;
}

.error {
  color: red;
}
</style>

</head>

<body>

<div class="box">

<h2>Login</h2>

<?php if ($error != "") { echo "<p class='error'>$error</p>"; } ?>

<form method="POST">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
</form>

</div>

</body>
</html>