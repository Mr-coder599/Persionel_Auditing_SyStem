<?php
session_start();
include '../db/db_connection.php';

// Check if the lecturer is logged in
if (!isset($_SESSION['lecturer_id'])) {
    header("Location: lecturer_login.php");
    exit();
}

$lecturer_id = $_SESSION['lecturer_id'];

// Fetch attendance records for this lecturer
$stmt = $conn->prepare("SELECT * FROM attendance WHERE lecturer_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $lecturer_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle attendance form submission (mark attendance for today)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status']; // Present or Absent
    $remarks = $_POST['remarks']; // Any remarks
    $date = date('Y-m-d'); // Use today's date

    // Insert attendance record into the database
    $stmt = $conn->prepare("INSERT INTO attendance (lecturer_id, date, status, remarks) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $lecturer_id, $date, $status, $remarks);
    $stmt->execute();
    header("Location: attendance.php"); // Refresh page after submitting
    exit();
}
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
        <!-- Attendance Form for Today -->
        <h3>Mark Attendance for Today (<?= date('Y-m-d') ?>)</h3>
        <form action="" method="POST">
            <div class="mb-3"><label for="status" class="form-label">Status</label><select name="status" id="status" class="form-select" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select></div>
            <div class="mb-3"><label for="remarks" class="form-label">Remarks</label><textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Enter any remarks (optional)"></textarea></div><button type="submit" class="btn btn-primary">Submit Attendance</button>
        </form>
        <hr>
        <!-- < !-- Attendance Records for the Lecturer -->
        <h3>Your Attendance Records</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody><?php while ($row = $result->fetch_assoc()): ?><tr>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= htmlspecialchars($row['remarks']) ?></td>
                    </tr><?php endwhile; ?></tbody>
        </table>
    </div>
</body>

</html>