<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$dbFilePath = '../../tmp/v2_database.db';

if (file_exists($dbFilePath)) {

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
    http_response_code(404);
    die('Database file not found.');
}
?>
