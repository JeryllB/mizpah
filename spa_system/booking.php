<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "client") {
    header("Location: login.html");
    exit();
}

// SUCCESS MESSAGE
if (isset($_GET['success'])) {
    echo "<script>alert('✅ Booking Saved Successfully!');</script>";
}
?>

<?php include("booking.html"); ?>