<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'patient') {
    header("Location: login.php");
    exit();
}

echo "<h2>Welcome, " . $_SESSION['username'] . "!</h2>";
echo "<a href='view_appointments.php'>View Appointments</a>";
echo "<a href='make_appointment.php'>Make Appointment</a>";
?>
