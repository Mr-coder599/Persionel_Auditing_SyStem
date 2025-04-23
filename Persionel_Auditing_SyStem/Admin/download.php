<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include '../db/db_connection.php'; // Include your database connection file

// Get the file ID from the URL
$file_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($file_id > 0) {
    // Prepare a statement to fetch the file from the database
    $sql = "SELECT file_name, file_data FROM reports WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $stmt->bind_result($file_name, $file_data);
    $stmt->fetch();
    $stmt->close();

    if ($file_data) {
        // Set headers for file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($file_data));

        // Output the file data
        echo $file_data;
        exit();
    } else {
        echo "File not found in the database.";
    }
} else {
    echo "Invalid file ID.";
}
