<?php
// Include the database connection file
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM users WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Store user information in session variables
            $_SESSION['patient_id'] = $row['patient_id'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'staff') {
                header("Location: staff_dashboard.php");
            } else {
                header("Location: patient_dashboard.php");
            }
        } else {
            echo "<div class='error-message'>Invalid password.</div>";
        }
    } else {
        echo "<div class='error-message'>No user found with that patient ID.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Belizario Medical Clinic</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your existing CSS file -->
</head>
<body>

    <div class="login-container">
        <div class="login-form">
            <h2>Login to Your Account</h2>
            <form action="login.php" method="POST">
                <label for="patient_id">Patient ID:</label>
                <input type="text" name="patient_id" id="patient_id" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <button type="submit" class="btn">Login</button>
            </form>

            <p>Don't have an account?</p>
            <!-- Register Button -->
            <a href="register.php" class="btn register-btn">Register</a>
        </div>
    </div>

</body>

<style>
    /* Main Theme Variables */
    :root {
        --primary-color: #5580ec;
        --secondary-color: #f15048;
        --text-color: #ffffff;
        --bg-gradient-start: rgba(44, 62, 80, 0.7);
        --bg-gradient-end: rgba(0, 0, 0, 0.7);
        --font-family: 'Arial', Helvetica, sans-serif;
    }

    /* Body Background and Font */
    body {
        margin: 0;
        padding: 0;
        font-family: var(--font-family);
        background: linear-gradient(var(--bg-gradient-start), var(--bg-gradient-end)), url('images/bg.png') no-repeat center center/cover;
        color: var(--text-color);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Login Form Container */
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .login-form {
        background-color: rgba(255, 255, 255, 0.1); /* Slight transparency */
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        width: 350px;
        text-align: center;
    }

    /* Form Elements */
    .login-form h2 {
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    .login-form label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
        font-size: 14px;
        color: var(--text-color);
    }

    .login-form input {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: none;
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.9);
    }

    /* Button Styling */
    .btn {
        background-color: var(--secondary-color);
        color: var(--text-color);
        padding: 10px;
        width: 100%;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
        display: block;
        margin-top: 10px;
    }

    .btn:hover {
        background-color: var(--primary-color);
    }

    /* Register Button */
    .register-btn {
        background-color: transparent;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        margin-top: 15px;
    }

    .register-btn:hover {
        background-color: var(--primary-color);
        color: var(--text-color);
    }

    /* Error Message Styling */
    .error-message {
        color: var(--secondary-color);
        background-color: rgba(255, 255, 255, 0.9);
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .login-form {
            width: 90%;
        }
    }
</style>

</html>
