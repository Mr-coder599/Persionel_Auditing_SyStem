<?php
session_start();
include '../db/db_connection.php';

// Check if lecturer is logged in
if (!isset($_SESSION['lecturer_id'])) {
    header("Location: lecturer_login.php");
    exit();
}

$lecturer_id = $_SESSION['lecturer_id'];

// Fetch performance logs for the logged-in lecturer
$sql = "SELECT * FROM performance_logs WHERE lecturer_id = ? ORDER BY timestamp DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $lecturer_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Logs - Lecturer Dashboard</title>
    <!-- Link to Bootstrap CSS for enhanced styling -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Custom styles -->
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.5rem;
        }

        .card-body {
            background-color: white;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .btn {
            font-size: 1rem;
            border-radius: 5px;
        }

        .alert {
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header for the Page -->
        <div class="card">
            <div class="card-header text-center">
                <h1>Performance Logs</h1>
            </div>
            <div class="card-body">
                <?php if ($result->num_rows > 0): ?>
                    <!-- Performance Logs Table -->
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['action']) ?></td>
                                    <td><?= $row['timestamp'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <!-- No Logs Message -->
                    <div class="alert alert-warning" role="alert">
                        No performance logs found.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>