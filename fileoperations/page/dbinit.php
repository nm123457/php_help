<?php
// Define the path to the SQLite database file
$dbFilePath = '../tmp/database.db';

try {
    // Check if the database file already exists
    $dbExists = file_exists($dbFilePath);

    // Create (open) the SQLite database
    $db = new PDO('sqlite:' . $dbFilePath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!$dbExists) {
        // Create the 'users' table
        $db->exec("CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL,
            password TEXT NOT NULL,
            role TEXT NOT NULL
        )");

        // Create the 'uploads' table
        $db->exec("CREATE TABLE uploads (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            uploader TEXT NOT NULL,
            uploaded_filename TEXT NOT NULL,
            uploaded_filetype TEXT NOT NULL,
            filesize INTEGER NOT NULL,
            uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        echo "Database and tables created successfully.";
    } else {
        echo "Database already exists.";
    }
} catch (PDOException $e) {
    echo "An error occurred while creating the database: " . $e->getMessage();
}
?>
