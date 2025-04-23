<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Get the file path from the URL query parameter
$file_path = isset($_GET['file']) ? $_GET['file'] : '';

// Set the base directory for file storage (adjust this as needed)
$base_directory = $_SERVER['DOCUMENT_ROOT'] . '/uploads';

// Ensure the file path is not empty and check if the file exists
if ($file_path && file_exists($base_directory . $file_path)) {
    // Get the file name from the path
    $file_name = basename($file_path);

    // Set headers to force the download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header('Content-Length: ' . filesize($base_directory . $file_path));

    // Clear output buffer and send the file
    ob_clean();
    flush();
    readfile($base_directory . $file_path);
    exit();
} else {
    // Handle the error if the file does not exist or invalid path
    echo "File not found.";
}
