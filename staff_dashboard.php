<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your existing CSS file -->
</head>
<body>

    <!-- Sidebar for Navigation -->
    <div class="sidebar">
        <h3>Dashboard</h3>
        <ul>
            <li><a href="view_appointments.php">View Patient Appointments</a></li>
            <li><a href="manage_slots.php">Manage Available Slots</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Welcome, Staff <?php echo $_SESSION['username']; ?>!</h2>
        <p>Use the sidebar to navigate through your dashboard.</p>
    </div>
    
    <!-- Right Sidebar for Logout -->
    <div class="right-sidebar">
        <a href="logout.php" class="btn-logout">Logout</a>
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

    body {
        margin: 0;
        padding: 0;
        font-family: var(--font-family);
        background-color: #f4f4f4;
        display: flex;
        height: 100vh;
    }

    /* Sidebar Navigation */
    .sidebar {
        width: 250px;
        background-color: var(--primary-color);
        padding: 20px;
        position: fixed;
        height: 100%;
        transition: width 0.3s ease;
    }

    .sidebar h3 {
        color: var(--text-color);
        margin-bottom: 20px;
        font-size: 20px;
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar ul li {
        margin-bottom: 15px;
    }

    .sidebar ul li a {
        color: var(--text-color);
        text-decoration: none;
        font-size: 16px;
        padding: 10px;
        display: block;
        transition: background-color 0.3s ease;
    }

    .sidebar ul li a:hover {
        background-color: var(--secondary-color);
        border-radius: 5px;
    }

    /* Main Content */
    .main-content {
        margin-left: 270px; /* Width of the sidebar + padding */
        padding: 40px;
        flex-grow: 1;
    }

    .main-content h2 {
        color: var(--primary-color);
    }

    /* Right Sidebar for Logout */
    .right-sidebar {
        position: fixed;
        right: 0;
        top: 0;
        padding: 20px;
    }

    .btn-logout {
        background-color: var(--secondary-color);
        color: var(--text-color);
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .btn-logout:hover {
        background-color: var(--primary-color);
    }

    /* Collapsible Sidebar (Optional) */
    .sidebar.collapsed {
        width: 60px;
    }

    .sidebar.collapsed ul li a {
        font-size: 14px;
        text-align: center;
    }

    .sidebar.collapsed ul li a:hover {
        background-color: var(--secondary-color);
    }

    /* Media Queries for Responsive Design */
    @media (max-width: 768px) {
        .main-content {
            margin-left: 60px;
        }
        .sidebar {
            width: 60px;
        }
        .right-sidebar {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    }
</style>

</html>
