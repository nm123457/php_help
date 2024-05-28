<?php
session_start();
include 'logger.php'; // Include the logger

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_page.php");
    exit();
}

try {
    // Connect to the SQLite database
    $dbFilePath = '../tmp/database.db';
    $db = new PDO('sqlite:' . $dbFilePath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve all data from the uploads table
    $stmt = $db->query("SELECT id, uploaded_filename, uploaded_filetype, filesize, uploaded_at FROM uploads");
    $uploads = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}

function format_datetime($datetime) {
    $date = new DateTime($datetime);
    return $date->format('d-m-Y H:i:s');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of Items</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>List of Items</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>File Name</th>
            <th>File Type</th>
            <th>File Size</th>
            <th>Uploaded At</th>
            <th>Download</th>
        </tr>
        <?php foreach ($uploads as $upload): ?>
            <tr>
                <td><?= $upload['id'] ?></td>
                <td><?= htmlspecialchars($upload['uploaded_filename']) ?></td>
                <td><?= strtoupper(htmlspecialchars($upload['uploaded_filetype'])) ?></td>
                <td><?= round($upload['filesize'] / 1024, 2) . ' MB' ?></td>
                <td><?= format_datetime($upload['uploaded_at']) ?></td>
                <td><a href="download.php?file=<?= urlencode($upload['uploaded_filename']) ?>">Download</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
