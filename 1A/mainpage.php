<?php
// MySQL database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "due2";

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch events from the database
$sql = "SELECT id, name, date, location FROM events";
$result = $conn->query($sql);
$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Registration Form</title>
</head>
<body>
    <h1>Register for an Event</h1>
    <form action="handle_registration.php" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="event">Event:</label><br>
        <select id="event" name="event" required>
            <option value="">Select an event</option>
            <?php foreach ($events as $event): ?>
                <option value="<?php echo $event['id']; ?>">
                    <?php echo htmlspecialchars($event['name'] . ' - ' . $event['date'] . ' - ' . $event['location']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>
        
        <input type="submit" value="Register">
    </form>
</body>
</html>
