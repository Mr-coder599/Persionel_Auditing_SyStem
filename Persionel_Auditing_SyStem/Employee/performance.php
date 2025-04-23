<?php
session_start();
include '../db/db_connection.php';

// Check if lecturer is logged in
if (!isset($_SESSION['lecturer_id'])) {
    header("Location: lecturer_login.php");
    exit();
}

$lecturer_id = $_SESSION['lecturer_id'];

// Fetch overall lecturer performance data (can be adjusted based on your needs)
$sql = "SELECT COUNT(*) AS report_count FROM reports WHERE lecturer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $lecturer_id);
$stmt->execute();
$stmt->bind_result($report_count);
$stmt->fetch();
$stmt->close();  // Close the statement after fetching the result

// Fetch the total number of actions logged
$sql_logs = "SELECT COUNT(*) AS log_count FROM performance_logs WHERE lecturer_id = ?";
$stmt_logs = $conn->prepare($sql_logs);
$stmt_logs->bind_param("i", $lecturer_id);
$stmt_logs->execute();
$stmt_logs->bind_result($log_count);
$stmt_logs->fetch();
$stmt_logs->close();  // Close the statement after fetching the result
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Performance Overview</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .card-header {
            background-color: #28a745;
            color: white;
            font-size: 1.5rem;
        }

        .card-body {
            background-color: white;
        }

        .card {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Lecturer Performance Overview -->
        <div class="card">
            <div class="card-header text-center">
                <h1>Lecturer Performance Overview</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Reports Submitted -->
                    <div class="col-md-6">
                        <div class="card bg-light mb-3">
                            <div class="card-header">Reports Submitted</div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $report_count ?> reports submitted</h5>
                                <p class="card-text">Keep up the good work! Continue submitting more reports for better performance.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Logs -->
                    <div class="col-md-6">
                        <div class="card bg-light mb-3">
                            <div class="card-header">Performance Logs</div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $log_count ?> actions logged</h5>
                                <p class="card-text">Your activities are being logged to track performance improvements and actions.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="performance_logs.php" class="btn btn-primary">View Detailed Logs</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>