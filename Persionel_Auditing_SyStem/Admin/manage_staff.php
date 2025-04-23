<?php
// Include database connection
include '../db/db_connection.php';

// Fetch all lecturer records
$sql = "SELECT * FROM lecturers"; // Assuming the table name is 'lecturers'
$result = $conn->query($sql);

// Check for any records
if ($result->num_rows > 0) {
    $lecturers = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $lecturers = [];
}

// Handle Delete functionality
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM lecturers WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        header('Location: manage_staff.php'); // Reload the page after deletion
        exit();
    } else {
        echo "Error deleting record!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff Records - Personnel Auditing System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css"> <!-- Your custom styles if any -->
    <style>
        /* Add custom styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
        }

        .container {
            max-width: 1200px;
        }

        .table {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            text-align: center;
        }

        .btn {
            border-radius: 5px;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .page-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #495057;
        }

        .table th {
            background-color: #007bff;
            color: #fff;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .no-records {
            text-align: center;
            font-size: 1.2rem;
            color: #6c757d;
            padding: 1rem;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 0.5rem 1rem;
        }

        .card-body {
            padding: 1rem;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2 class="page-title">Manage Staff Records</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($lecturers) > 0): ?>
                            <?php foreach ($lecturers as $lecturer): ?>
                                <tr>
                                    <td><?= $lecturer['id']; ?></td>
                                    <td><?= htmlspecialchars($lecturer['name']); ?></td>
                                    <td><?= htmlspecialchars($lecturer['email']); ?></td>
                                    <td><?= htmlspecialchars($lecturer['phone']); ?></td>
                                    <td><?= htmlspecialchars($lecturer['department']); ?></td>
                                    <td>
                                        <a href="edit_lecturer.php?id=<?= $lecturer['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?delete_id=<?= $lecturer['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this lecturer?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="no-records">
                                <td colspan="6">No records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>