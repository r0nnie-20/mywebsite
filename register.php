<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include 'db_connect.php';

$show_popup = false; // Default no popup
$patient_id = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted and retrieve the generated patient_id
    if (isset($_POST['name']) && isset($_POST['password']) && isset($_POST['patient_id'])) {
        $patient_id = $_POST['patient_id']; // Retrieve the generated patient ID
        $name = $_POST['name'];
        $password = $_POST['password']; // Visible password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password for security
        $age = $_POST['age'];
        $birthdate = $_POST['birthdate'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $role = 'patient'; // Set role to 'patient' by default

        // Insert patient data into the database with the generated patient ID
        $sql = "INSERT INTO users (patient_id, name, password, role, age, birthdate, address, phone) 
                VALUES ('$patient_id', '$name', '$hashed_password', '$role', '$age', '$birthdate', '$address', '$phone')";

        if ($conn->query($sql) === TRUE) {
            // Trigger the popup to show after successful registration
            $show_popup = true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Form submission failed. Please fill in all required fields.";
    }
} else {
    // If the form is not submitted, generate a new patient ID for display in the form
    $patient_id = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT); // Generate 6-digit ID
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <style>
        /* Main Theme Variables */
        :root {
            --primary-color: #5580ec;
            --secondary-color: #f15048;
            --text-color: #ffffff;
            --font-family: 'Arial', Helvetica, sans-serif;
        }

        body {
            font-family: var(--font-family);
            background-color: #f4f4f4;
            padding: 50px;
        }

        /* Form Styling */
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: var(--primary-color);
            padding: 20px;
            border-radius: 10px;
            color: var(--text-color);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        form label {
            display: block;
            margin-bottom: 10px;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
        }

        form button {
            padding: 10px 20px;
            background-color: var(--secondary-color);
            color: var(--text-color);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: var(--primary-color);
        }

        /* Popup Styling */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup-content {
            background-color: var(--primary-color);
            color: var(--text-color);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            width: 400px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .popup-content h3 {
            margin-bottom: 20px;
        }

        .popup-content p {
            margin-bottom: 10px;
        }

        .popup-content button {
            background-color: var(--secondary-color);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .popup-content button:hover {
            background-color: var(--primary-color);
        }
    </style>
</head>
<body>

    <h2>Patient Registration</h2>
    <form action="register.php" method="POST">
        <!-- Display the generated patient ID (read-only) -->
        <label for="patient_id">Patient ID:</label>
        <input type="text" name="patient_id" id="patient_id" value="<?php echo $patient_id; ?>" readonly>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="password">Password (visible):</label>
        <input type="text" name="password" id="password" required> <!-- Visible password field -->

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required>

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate" id="birthdate" required>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required>

        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" id="phone" required>

        <button type="submit">Register</button>
    </form>

    <?php
    // If the registration is successful, show the popup
    if ($show_popup) {
        echo "
        <div class='popup-overlay'>
            <div class='popup-content'>
                <h3>Registration Successful!</h3>
                <p><strong>Patient ID:</strong> $patient_id</p>
                <p><strong>Password:</strong> $password</p>
                <p>Please save your patient ID and password for future login.</p>
                <button onclick='redirectToLogin()'>Close</button>
            </div>
        </div>
        <script>
            function redirectToLogin() {
                document.querySelector('.popup-overlay').style.display = 'none';
                window.location.href = 'login.php'; // Redirect to login.php
            }
        </script>
        ";
    }
    ?>

</body>
</html>
