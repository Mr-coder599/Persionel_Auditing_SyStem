<?php
session_start();

// Check if the lecturer is logged in
if (!isset($_SESSION['lecturer_id'])) {
    header("Location: lecturer_login.php");
    exit();
}

// Fetch lecturer name from session
$lecturer_name = $_SESSION['lecturer_name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Dashboard - Personnel Auditing System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            position: fixed;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
        }

        .sidebar .header {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
            border-bottom: 1px solid #34495e;
        }

        .sidebar ul li a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 1.1rem;
            display: block;
        }

        .sidebar ul li a:hover {
            background-color: #34495e;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .top-bar {
            background-color: #2980b9;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar .logout {
            color: white;
            text-decoration: none;
        }

        .top-bar .logout:hover {
            text-decoration: underline;
        }

        .card {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-title {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="header">Staff Dashboard</div>
        <ul>
            <li><a href="./attendance.php">Attendance</a></li>
            <li><a href="#">View Attendance</a></li>
            <li><a href="./submit_report.php">Submit Reports</a></li>
            <li><a href="./performance.php">Performance Logs</a></li>
            <li><a href="#">Update Profile</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="top-bar">
            <span>Welcome, <?= htmlspecialchars($lecturer_name) ?></span>
            <a href="./lecturer_login.php" class="logout">Logout</a>
        </div>

        <h1>Personnel Auditing Overview</h1>
        <p>Track your activities, attendance, and submit reports in this dashboard.</p>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Attendance</h5>
                        <p class="card-text">Monitor your attendance records and ensure accuracy.</p>
                        <a href="./filter_attendance.php" class="btn btn-primary">View Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Submit Reports</h5>
                        <p class="card-text">Upload work-related documents or updates for auditing.</p>
                        <a href="./submit_report.php" class="btn btn-primary">Submit Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Performance Logs</h5>
                        <p class="card-text">View detailed logs of your performance and feedback.</p>
                        <a href="./performance_log.php" class="btn btn-primary">View Logs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>