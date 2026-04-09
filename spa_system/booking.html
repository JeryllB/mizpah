<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Appointment - Mizpah Wellness Spa</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
  <h2>Mizpah Wellness Spa</h2>
  <nav>
    <a href="index.html">Home</a>
    <a href="therapists.html">Therapists</a>
  </nav>
</header>

<div class="booking">

  <div class="booking-header">
    <h2>Book Your Appointment</h2>
    <p>Select your preferred service, therapist, and time</p>
    <p class="note">Bookings must be made at least 4 hours before the selected schedule.</p>
  </div>

  <div class="form-card">

    <form action="savebooking.php" method="POST">

    <div class="form-header">
      Appointment Details
    </div>

    <div class="form-grid">
      <div>
        <label>Your Name</label>
        <input type="text" name="name" placeholder="John Doe" required>
      </div>

      <div>
        <label>Email Address</label>
        <input type="email" name="email" placeholder="john@example.com" required>
      </div>
    </div>

    <label>Select Service</label>
    <select name="service" required>
      <option value="">Choose a service...</option>
      <option value="Swedish Massage - 60 min">Swedish Massage</option>
      <option value="Deep Tissue - 90 min">Deep Tissue</option>
      <option value="Hot Stone Therapy - 75 min">Hot Stone Therapy</option>
    </select>

    <label>Choose Your Therapist</label>
    <select name="therapist" id="therapist" required>
      <option value="">Select a therapist...</option>
      <option value="Anna Reyes">Anna Reyes</option>
      <option value="Mark Santos">Mark Santos</option>
      <option value="Lisa Cruz">Lisa Cruz</option>
    </select>

    <label>Select Room</label>
    <select name="room" required>
      <option value="">Choose a room...</option>
      <option value="Room 1 - Serenity">Room 1 - Serenity</option>
      <option value="Room 2 - Harmony">Room 2 - Harmony</option>
      <option value="Room 3 - Tranquility">Room 3 - Tranquility</option>
    </select>

    <label>Select Date</label>
    <div class="calendar-box">
      <!-- REAL CALENDAR INPUT -->
      <input type="date" name="date" id="date" required>
    </div>

    <label>Select Time</label>
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
      <span class="time-option" data-time="24:00">24:00</span>
    </div>

    <!-- SUMMARY -->
    <div class="summary-box">
      <h3>Booking Summary</h3>
      <p>Service: <span id="sum-service">-</span></p>
      <p>Date: <span id="sum-date">-</span></p>
      <p>Time: <span id="sum-time">-</span></p>
    </div>

    <!-- HIDDEN INPUTS -->
    <input type="hidden" name="date" id="final-date">
    <input type="hidden" name="time" id="final-time">

    <button type="submit" class="btn-primary full">Book Now</button> 

    </form>

  </div>

</div>

<script>

// SERVICE
const serviceSelect = document.querySelector("select[name='service']");
serviceSelect.addEventListener("change", () => {
  document.getElementById("sum-service").innerText = serviceSelect.value;
});

// DATE
const dateInput = document.getElementById("date");

dateInput.addEventListener("change", function () {
  document.getElementById("sum-date").innerText = this.value;
  document.getElementById("final-date").value = this.value;
});

// TIME
document.querySelectorAll(".time-option").forEach(time => {
  time.addEventListener("click", () => {

    document.querySelectorAll(".time-option").forEach(t => t.classList.remove("active"));
    time.classList.add("active");

    document.getElementById("sum-time").innerText = time.dataset.time;
    document.getElementById("final-time").value = time.dataset.time;

  });
});

// BLOCK BOOKED DATES
document.addEventListener("DOMContentLoaded", function () {

  fetch("get_all_booked_dates.php")
    .then(res => res.json())
    .then(disabledDates => {

      const dateInput = document.getElementById("date");

      dateInput.addEventListener("change", function () {

        if (disabledDates.includes(this.value)) {
          alert("This date is already booked!");
          this.value = "";
          document.getElementById("sum-date").innerText = "-";
          document.getElementById("final-date").value = "";
        }

      });

    });

});

</script>

</body>
</html>