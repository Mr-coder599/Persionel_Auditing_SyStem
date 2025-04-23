<?php
session_start();
include '../db/db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Get the current page number from the URL (default to 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;  // Number of reports per page
$offset = ($page - 1) * $limit;

// Initialize filter variables
$lecturer_id_filter = isset($_GET['lecturer_id']) ? $_GET['lecturer_id'] : '';
$title_filter = isset($_GET['title']) ? $_GET['title'] : '';
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

// Create the base query for reports
// $sql = "SELECT * FROM reports WHERE 1";
$sql = "SELECT reports.*, lecturers.name AS lecturer_name, lecturers.department As lecturer_dept
        FROM reports
        LEFT JOIN lecturers ON reports.lecturer_id = lecturers.id
        WHERE 1";
// Apply filters if provided
// if ($lecturer_id_filter != '') {
//     $sql .= " AND lecturer_id LIKE ?";
// }
// if ($title_filter != '') {
//     $sql .= " AND title LIKE ?";
// }
// if ($from_date != '' && $to_date != '') {
//     $sql .= " AND timestamp BETWEEN ? AND ?";
// }
if ($lecturer_id_filter != '') {
    $sql .= " AND reports.lecturer_id LIKE ?";
}
if ($title_filter != '') {
    $sql .= " AND reports.title LIKE ?";
}
if ($from_date != '' && $to_date != '') {
    $sql .= " AND reports.submitted_at BETWEEN ? AND ?";
}

// Add order by and limit for pagination
$sql .= " ORDER BY submitted_at DESC LIMIT ?, ?";

// Prepare the query and bind parameters
$stmt = $conn->prepare($sql);
if ($lecturer_id_filter != '' && $title_filter != '' && $from_date != '' && $to_date != '') {
    $stmt->bind_param("ssssii", "%$lecturer_id_filter%", "%$title_filter%", $from_date, $to_date, $offset, $limit);
} elseif ($lecturer_id_filter != '' && $title_filter != '') {
    $stmt->bind_param("ssii", "%$lecturer_id_filter%", "%$title_filter%", $offset, $limit);
} elseif ($lecturer_id_filter != '') {
    $stmt->bind_param("sii", "%$lecturer_id_filter%", $offset, $limit);
} else {
    $stmt->bind_param("ii", $offset, $limit);
}

$stmt->execute();
$result = $stmt->get_result();

// Get total number of records (for pagination)
// $count_sql = "SELECT COUNT(*) AS total FROM reports WHERE 1";
$count_sql = "SELECT COUNT(*) AS total
              FROM reports
              LEFT JOIN lecturers ON reports.lecturer_id = lecturers.id
              WHERE 1";

if ($lecturer_id_filter != '') {
    $count_sql .= " AND lecturer_id LIKE ?";
}
if ($title_filter != '') {
    $count_sql .= " AND title LIKE ?";
}
if ($from_date != '' && $to_date != '') {
    $count_sql .= " AND timestamp BETWEEN ? AND ?";
}
$count_stmt = $conn->prepare($count_sql);
if ($lecturer_id_filter != '' && $title_filter != '' && $from_date != '' && $to_date != '') {
    $count_stmt->bind_param("ssss", "%$lecturer_id_filter%", "%$title_filter%", $from_date, $to_date);
} elseif ($lecturer_id_filter != '' && $title_filter != '') {
    $count_stmt->bind_param("ss", "%$lecturer_id_filter%", "%$title_filter%");
} elseif ($lecturer_id_filter != '') {
    $count_stmt->bind_param("s", "%$lecturer_id_filter%");
} else {
    $count_stmt->execute();
}

$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Delete report if requested
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Get file path for deletion
    $sql_file = "SELECT file_path FROM reports WHERE id = ?";
    $stmt_file = $conn->prepare($sql_file);
    $stmt_file->bind_param("i", $delete_id);
    $stmt_file->execute();
    $stmt_file->bind_result($file_path);
    $stmt_file->fetch();
    $stmt_file->close();

    // Delete the file from the server
    if (file_exists($file_path)) {
        unlink($file_path);  // Remove the file from the server
    }

    // Delete the report record from the database
    $sql_delete = "DELETE FROM reports WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);
    $stmt_delete->execute();
    $stmt_delete->close();

    // Redirect to avoid resubmitting the delete action
    header("Location: audit_report.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Report - Admin Dashboard</title>
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
            background-color: #007bff;
            color: white;
            font-size: 1.5rem;
        }

        .card-body {
            background-color: white;
        }

        .card {
            margin-bottom: 30px;
        }

        .btn {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h1>Audit Report - Admin Dashboard</h1>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form action="audit_report.php" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="lecturer_id" class="form-control" placeholder="Lecturer ID" value="<?= htmlspecialchars($lecturer_id_filter) ?>">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="title" class="form-control" placeholder="Report Title" value="<?= htmlspecialchars($title_filter) ?>">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="from_date" class="form-control" value="<?= htmlspecialchars($from_date) ?>">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="to_date" class="form-control" value="<?= htmlspecialchars($to_date) ?>">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                <br>

                <!-- Reports Table -->
                <?php if ($result->num_rows > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Lecture ID</th>
                                <th>Lecturer Name</th>
                                <th>Department</th>
                                <th>Title</th>
                                <th>Submitted On</th>
                                <th>Actions</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['lecturer_id'] ?></td>
                                    <td><?= htmlspecialchars($row['lecturer_name']) ?></td>
                                    <td><?= htmlspecialchars($row['lecturer_dept']) ?></td>
                                    <td><?= htmlspecialchars($row['title']) ?></td>
                                    <td><?= $row['submitted_at'] ?></td>
                                    <td>
                                        <!-- <a href="
                                        " class="btn btn-success btn-sm" download>Download</a> -->
                                        <!-- <a href="download_report.php?file=" class="btn btn-success btn-sm">Download</a> -->
                                        <a href="download_report.php?file=<?= urlencode($row['file_path']) ?>" class="btn btn-success btn-sm">Download</a>


                                        <a href="?delete_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this report?')">Delete</a>
                                        <a href="./admin_dashboard.php" class=" btn btn-success btn-sm">Back</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No audit reports found.</p>
                <?php endif; ?>

                <!-- Pagination -->
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>&lecturer_id=<?= $lecturer_id_filter ?>&title=<?= $title_filter ?>&from_date=<?= $from_date ?>&to_date=<?= $to_date ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>