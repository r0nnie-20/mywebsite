<?php
$servername = "localhost";
$username = "root";  // Default XAMPP MySQL username
$password = "";      // Leave blank for default
$dbname = "medical_clinic_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
