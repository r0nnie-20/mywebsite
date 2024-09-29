<?php
// Include the database connection file
include 'db_connect.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Insert or update data into the available_slots table
    $sql = "INSERT INTO available_slots (day_of_week, start_time, end_time) 
            VALUES ('$day_of_week', '$start_time', '$end_time')";

    if ($conn->query($sql) === TRUE) {
        echo "New slot added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

// Fetch available slots to display in the table
$result = $conn->query("SELECT * FROM available_slots");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Available Slots</title>
    <link rel="stylesheet" href="styles.css"> <!-- Your CSS file -->
</head>
<body>

    <h2>Manage Available Days and Time Slots</h2>

    <!-- Form to Add or Edit Slots -->
    <form action="manage_slots.php" method="POST">
        <label for="day_of_week">Day of Week:</label>
        <select name="day_of_week" id="day_of_week" required>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
            <option value="Sunday">Sunday</option>
        </select>

        <label for="start_time">Start Time:</label>
        <input type="time" name="start_time" id="start_time" required>

        <label for="end_time">End Time:</label>
        <input type="time" name="end_time" id="end_time" required>

        <button type="submit">Add Slot</button>
    </form>

    <h3>Available Days and Time Slots</h3>

    <!-- Table to View Available Slots -->
    <table border="1">
        <tr>
            <th>Day of Week</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Actions</th>
        </tr>

        <?php
        // Loop through and display the available slots
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['day_of_week'] . "</td>";
                echo "<td>" . $row['start_time'] . "</td>";
                echo "<td>" . $row['end_time'] . "</td>";
                echo "<td><a href='edit_slot.php?id=" . $row['id'] . "'>Edit</a> | 
                          <a href='delete_slot.php?id=" . $row['id'] . "'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No available slots</td></tr>";
        }

        $conn->close();
        ?>

    </table>

</body>
</html>
