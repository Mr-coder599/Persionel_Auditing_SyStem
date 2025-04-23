<?php
// Include database connection
include '../db/db_connection.php';

if (isset($_GET['id'])) {
    $lecturer_id = $_GET['id'];

    // Fetch lecturer details
    $sql = "SELECT * FROM lecturers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $lecturer = $result->fetch_assoc();
    } else {
        echo "Lecturer not found!";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update lecturer record
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];

    $update_sql = "UPDATE lecturers SET name = ?, email = ?, phone = ?, department = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $department, $lecturer_id);

    if ($stmt->execute()) {
        header('Location: manage_staff.php'); // Redirect to manage staff page
        exit();
    } else {
        echo "Error updating record!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lecturer Record - Personnel Auditing System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        /* Custom Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
        }

        .container {
            max-width: 800px;
            padding-top: 50px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 500;
            color: #495057;
        }

        .btn-back {
            background-color: #6c757d;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Edit Lecturer Record
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($lecturer['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($lecturer['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($lecturer['phone']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <select id="department" name="department" class="form-select" required>
                            <option value="Computer Science" <?= ($lecturer['department'] == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                            <option value="Information Technology" <?= ($lecturer['department'] == 'Information Technology') ? 'selected' : ''; ?>>Information Technology</option>
                            <option value="Mathematics" <?= ($lecturer['department'] == 'Mathematics') ? 'selected' : ''; ?>>Mathematics</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Record</button>
                    <a href="manage_staff.php" class="btn btn-back ms-2">Back to Staff List</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>