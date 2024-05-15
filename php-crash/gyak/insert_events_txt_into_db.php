<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "due";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Open the events.txt file
$file = fopen("events.txt", "r");

if ($file) {
    while (($line = fgets($file)) !== false) {
        // Split the line by semicolon
        $parts = explode(";", trim($line));
        
        if (count($parts) === 4) {
            $event_name = $conn->real_escape_string($parts[0]);
            $event_date = $conn->real_escape_string($parts[1]);
            $location = $conn->real_escape_string($parts[2]);
            $duration = intval($parts[3]);

            // Insert the data into the database
            $sql = "INSERT INTO events (event_name, event_date, location, duration) 
                    VALUES ('$event_name', '$event_date', '$location', $duration)";
            
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
            }
        } else {
            echo "Invalid line format: $line<br>";
        }
    }
    fclose($file);
} else {
    echo "Unable to open the file.";
}

// Close the database connection
$conn->close();
?>
