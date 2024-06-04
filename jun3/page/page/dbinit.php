<?php
$dbFilePath = '../../tmp/v2_database.db';

try {
    $dbExists = file_exists($dbFilePath);

    $db = new PDO('sqlite:' . $dbFilePath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!$dbExists) {
        $db->exec("CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL,
            password TEXT NOT NULL,
			email TEXT,
            role TEXT NOT NULL
        )");

        $db->exec("CREATE TABLE tasks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            task_name TEXT,
            created_by TEXT,
            due_date DATETIME,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            attached_file_name TEXT
        )");

        echo "Database and tables created successfully.";
    } else {
        echo "Database already exists.";
    }
} catch (PDOException $e) {
    echo "An error occurred while creating the database: " . $e->getMessage();
}
?>
