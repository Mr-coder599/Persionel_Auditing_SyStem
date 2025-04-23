<?php
session_start();

/* Check if Admin is Logged In */
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

/* Fetch Dashboard Data (Example Queries) */
include '../db/db_connection.php';

// Example: Total Users
$result = $conn->query("SELECT COUNT(*) AS total_users FROM lecturers");
$total_users = $result->fetch_assoc()['total_users'];

// Example: Total Audits
$result = $conn->query("SELECT COUNT(*) AS total_audits FROM reports");
$total_audits = $result->fetch_assoc()['total_audits'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Personnel Auditing System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: #007bff;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            padding-top: 20px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 15px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #0056b3;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            background-color: #f8f9fa;
            padding: 15px;
        }

        .navbar .nav-item .nav-link {
            color: #333;
        }

        .navbar .nav-item .nav-link:hover {
            color: #007bff;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center mb-4">Admin Panel</h3>
        <a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="./view_attandance.php"><i class="fas fa-users"></i> Manage Attandance</a>
        <a href="manage_staff.php"><i class="fas fa-users"></i> Manage Staff</a>
        <a href="audit_report.php"><i class="fas fa-file-alt"></i> Audit Reports</a>
        <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
        <a href="./admin_login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Admin Dashboard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-user"></i> Welcome, Admin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Dashboard Overview -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Staff</h5>
                            <p class="card-text display-6"><?= $total_users; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Audits</h5>
                            <p class="card-text display-6"><?= $total_audits; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Pending Actions</h5>
                            <p class="card-text display-6">12</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Sections -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Activities</h5>
                            <p class="card-text">Here you can add logs, recent actions, or updates for the admin.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>