<?php
session_start();
include '../db/db_connection.php';

// Check if the lecturer is logged in
if (!isset($_SESSION['lecturer_id'])) {
    header("Location: lecturer_login.php");
    exit();
}

$lecturer_id = $_SESSION['lecturer_id'];

// Default query to fetch all attendance records for the lecturer
$query = "SELECT * FROM attendance WHERE lecturer_id = ? ORDER BY date DESC";

// Handle date filter
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Date or date range filter logic
    if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $query = "SELECT * FROM attendance WHERE lecturer_id = ? AND date BETWEEN ? AND ? ORDER BY date DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $lecturer_id, $start_date, $end_date);
    } elseif (!empty($_POST['specific_date'])) {
        $specific_date = $_POST['specific_date'];
        $query = "SELECT * FROM attendance WHERE lecturer_id = ? AND date = ? ORDER BY date DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $lecturer_id, $specific_date);
    } else {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $lecturer_id);
    }
} else {
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $lecturer_id);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Lecturer Attendance</h1>

        <!-- Attendance Filter Form -->
        <h3>Filter Attendance</h3>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="specific_date" class="form-label">Specific Date</label>
                <input type="date" id="specific_date" name="specific_date" class="form-control">
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control">
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Filter Attendance</button>
        </form>

        <hr>

        <!-- Attendance Records -->
        <h3>Your Attendance Records</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= htmlspecialchars($row['remarks']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>