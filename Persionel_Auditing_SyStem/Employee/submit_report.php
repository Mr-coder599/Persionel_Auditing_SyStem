<?php
session_start();
include '../db/db_connection.php';

if (!isset($_SESSION['lecturer_id'])) {
    header("Location: lecturer_login.php");
    exit();
}

$lecturer_id = $_SESSION['lecturer_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $target_dir = "uploads/";

    // Ensure the uploads directory exists and is writable
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
    }

    if (!is_writable($target_dir)) {
        $error = "Upload directory is not writable. Please check permissions.";
    }

    $file_name = basename($_FILES["file"]["name"]);
    $file_name = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_name); // Sanitize file name
    $target_file = $target_dir . uniqid() . "_" . $file_name;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO reports (lecturer_id, title, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $lecturer_id, $title, $target_file);
        $stmt->execute();
        $success = "Report submitted successfully!";
    } else {
        $error = "Failed to upload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Submit Report</h1>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Report Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Upload File</label>
                <input type="file" id="file" name="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="" class="btn btn-primary"><a href="./lecturer_dashboard.php" style="color: white; text-decoration:none;">Back</a></button>
        </form>
    </div>
</body>

</html>