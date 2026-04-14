<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "client") {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost","root","","spa_system",3307);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Appointment - Mizpah Wellness Spa</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<style>

/* BODY BACKGROUND (spa feel balik) */
body{
  margin:0;
  font-family:Poppins;
  background:#f5f2ee;
}

/* HEADER SPA STYLE */
header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:15px 40px;
  background:white;
  box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

header h2{
  color:#8b6b4a;
  font-family:"Playfair Display";
}

/* MAIN CONTAINER */
.booking{
  display:flex;
  justify-content:center;
  padding:40px 20px;
}

/* CARD */
.form-card{
  width:100%;
  max-width:600px;
  background:white;
  padding:30px;
  border-radius:15px;
  box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

/* LABELS */
label{
  display:block;
  margin-top:15px;
  font-weight:500;
  color:#333;
}

/* INPUTS */
input, select{
  width:100%;
  padding:10px;
  margin-top:5px;
  border:1px solid #ddd;
  border-radius:8px;
}

/* TIME SLOTS */
.time-option {
  padding:8px 12px;
  margin:5px;
  display:inline-block;
  border-radius:8px;
  background:#eee;
  cursor:pointer;
  transition:0.2s;
}

/* AVAILABLE */
.time-option.available {
  background:#d4edda;
  color:#155724;
}

/* DISABLED */
.time-option.disabled {
  background:#ccc;
  color:#666;
  pointer-events:none;
  opacity:0.6;
}

/* ACTIVE */
.time-option.active {
  background:#8b6b4a;
  color:white;
}

/* STATUS */
.status-text{
  margin-top:10px;
  font-size:14px;
}

/* BUTTON */
button{
  width:100%;
  margin-top:20px;
  padding:12px;
  background:#8b6b4a;
  color:white;
  border:none;
  border-radius:8px;
  cursor:pointer;
  font-size:16px;
}

button:hover{
  background:#6f5339;
}

</style>

</head>

<body>

<header>
  <h2>Mizpah Wellness Spa</h2>
  <nav>
    <a href="index.html">Home</a>
    <a href="therapists.php">Therapists</a>
  </nav>
</header>

<div class="booking">

  <div class="form-card">

<form action="savebooking.php" method="POST">

<label>Name</label>
<input type="text" name="name" required>

<label>Email</label>
<input type="email" name="email" required>

<label>Service</label>
<select name="service" required>
<option value="">Choose...</option>
<option value="Swedish Massage - 60 min">Swedish Massage</option>
<option value="Deep Tissue - 90 min">Deep Tissue</option>
<option value="Hot Stone Therapy - 75 min">Hot Stone Therapy</option>
</select>

<label>Therapist</label>
<select name="therapist" id="therapist" required>
<option value="">Select therapist</option>

<?php
$res = $conn->query("SELECT name FROM therapists");
while($t = $res->fetch_assoc()){
  echo "<option value='".$t['name']."'>".$t['name']."</option>";
}
?>

</select>

<label>Room</label>
<select name="room" required>
<option value="">Choose...</option>
<option value="Room 1 - Serenity">Room 1</option>
<option value="Room 2 - Harmony">Room 2</option>
<option value="Room 3 - Tranquility">Room 3</option>
</select>

<label>Date</label>
<input type="date" id="date" name="date" required>

<label>Time</label>
<div class="time-slots">
  <span class="time-option" data-time="15:00">15:00</span>
  <span class="time-option" data-time="16:00">16:00</span>
  <span class="time-option" data-time="17:00">17:00</span>
  <span class="time-option" data-time="18:00">18:00</span>
  <span class="time-option" data-time="19:00">19:00</span>
  <span class="time-option" data-time="20:00">20:00</span>
  <span class="time-option" data-time="21:00">21:00</span>
  <span class="time-option" data-time="22:00">22:00</span>
  <span class="time-option" data-time="23:00">23:00</span>
</div>

<div class="status-text" id="statusText"></div>

<input type="hidden" name="time" id="final-time">

<button type="submit">Book Now</button>

</form>

  </div>
</div>

<script>

const date = document.getElementById("date");
const therapist = document.getElementById("therapist");
const timeOptions = document.querySelectorAll(".time-option");
const statusText = document.getElementById("statusText");

function loadSlots() {

  if (!date.value || !therapist.value) return;

  fetch(`get_booked_slots.php?date=${date.value}&therapist=${therapist.value}`)
    .then(res => res.json())
    .then(booked => {

      let available = 0;

      timeOptions.forEach(t => {

        t.classList.remove("disabled", "active", "available");

        if (booked.includes(t.dataset.time)) {
          t.classList.add("disabled");
          t.innerText = t.dataset.time + " (Booked)";
        } else {
          t.classList.add("available");
          t.innerText = t.dataset.time;
          available++;
        }

      });

      statusText.innerText =
        available === 0
          ? "❌ Fully booked"
          : "✔ Available slots: " + available;

    });

}

date.addEventListener("change", loadSlots);
therapist.addEventListener("change", loadSlots);

timeOptions.forEach(t => {
  t.addEventListener("click", () => {

    if (t.classList.contains("disabled")) return;

    timeOptions.forEach(x => x.classList.remove("active"));
    t.classList.add("active");

    document.getElementById("final-time").value = t.dataset.time;

  });
});

</script>

</body>
</html>