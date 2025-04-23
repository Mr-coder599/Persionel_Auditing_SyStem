<?php
session_start();
include '../db/db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all attendance records for all lecturers
$query = "SELECT a.*, l.name AS lecturer_name FROM attendance a JOIN lecturers l ON a.lecturer_id = l.id ORDER BY a.date DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Handle updating attendance
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $attendance_id = $_POST['attendance_id'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    // Update attendance record
    $update_query = "UPDATE attendance SET status = ?, remarks = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssi", $status, $remarks, $attendance_id);
    $update_stmt->execute();
    header("Location: admin_attendance.php"); // Refresh page after update
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Attendance</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Admin - Manage Lecturer Attendance</h1>

        <!-- Attendance Records for Admin -->
        <h3>All Attendance Records</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Lecturer Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['lecturer_name']) ?></td>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= htmlspecialchars($row['remarks']) ?></td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal<?= $row['id'] ?>">Update</button>
                        </td>
                    </tr>

                    <!-- Update Modal -->
                    <div class="modal fade" id="updateModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel">Update Attendance</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="attendance_id" value="<?= $row['id'] ?>">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="Present" <?= $row['status'] == 'Present' ? 'selected' : '' ?>>Present</option>
                                                <option value="Absent" <?= $row['status'] == 'Absent' ? 'selected' : '' ?>>Absent</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="remarks" class="form-label">Remarks</label>
                                            <textarea name="remarks" class="form-control"><?= htmlspecialchars($row['remarks']) ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="update" class="btn btn-primary">Update Attendance</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>