<?php
// MySQL database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "due2";

// Path to the events.txt file
$file_path = 'events.txt';

// Open the file
$file = fopen($file_path, 'r');
if (!$file) {
    die('Could not open the file.');
}

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the events table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    date VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    duration INT NOT NULL
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Prepare the insert statement
$stmt = $conn->prepare("INSERT INTO events (name, date, location, duration) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $name, $date, $location, $duration);

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

    // Execute the insert statement
    $stmt->execute();
}

// Close the file and database connection
fclose($file);
$stmt->close();
$conn->close();

echo "Events have been successfully imported into the database.";
?>
