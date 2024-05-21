<?php
// Path to the events.txt file
$file_path = 'events.txt';

// Open the file
$file = fopen($file_path, 'r');
if (!$file) {
    die('Could not open the file.');
}

// Create (or open) the SQLite3 database
$db = new SQLite3('events.db');

// Create the events table
$db->exec('CREATE TABLE IF NOT EXISTS events (
    id INTEGER PRIMARY KEY,
    name TEXT,
    date TEXT,
    location TEXT,
    duration INTEGER
)');

// Prepare the insert statement
$insert = $db->prepare('INSERT INTO events (name, date, location, duration) VALUES (:name, :date, :location, :duration)');

// Read and process each line of the file
while (($line = fgets($file)) !== false) {
    // Split the line by semicolons
    $parts = explode(';', $line);
	
	if (count($parts) < 4) {
        // Skip this line if it doesn't have the expected number of parts
        continue;
    }

    // Trim whitespace from each part
    $name = trim($parts[0]);
    $date = trim($parts[1]);
    $location = trim($parts[2]);
    $duration = (int)trim($parts[3]);

    // Bind the values to the insert statement
    $insert->bindValue(':name', $name, SQLITE3_TEXT);
    $insert->bindValue(':date', $date, SQLITE3_TEXT);
    $insert->bindValue(':location', $location, SQLITE3_TEXT);
    $insert->bindValue(':duration', $duration, SQLITE3_INTEGER);

    // Execute the insert statement
    $insert->execute();
}

// Close the file and database connection
fclose($file);
$db->close();

echo "Events have been successfully imported into the database.";
?>
