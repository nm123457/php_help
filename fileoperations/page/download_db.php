<?php
session_start();
include 'logger.php'; // Include the logger

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_page.php");
    exit();
}

// Path to the database file
$dbFilePath = '../tmp/database.db';

// Check if the database file exists
if (file_exists($dbFilePath)) {
    // Log the download activity
    log_user_activity("Database downloaded by " . $_SESSION['username']);

    // Send the file to the browser for download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($dbFilePath));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($dbFilePath));
    readfile($dbFilePath);
    exit;
} else {
    // Log the error if the file does not exist
    log_user_activity("Database file not found by " . $_SESSION['username']);
    http_response_code(404);
    die('Database file not found.');
}
?>
