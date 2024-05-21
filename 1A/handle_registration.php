<?php

function checkForDuplicates($conn, $table, $name, $email) {
	$check_sql = "SELECT * FROM {$table} WHERE name = '{$name}' AND email = '{$email}'";
$result = $conn->query($check_sql);
$row = $result->fetch_assoc();
if ($result->num_rows != 0) {
			echo 'This user has already registered for this event';
			
		} else {
			insertUser($conn, $table, $name, $email);
		}
}

function insertUser($conn, $table, $name, $email) {
	// Insert the registration into the database
			$sql = "INSERT INTO {$table} (name, email) VALUES ('$name', '$email')";
			if ($conn->query($sql) === TRUE) {
				echo "Registration successful!";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
}
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

// Retrieve and sanitize form data
$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$event_id = (int)$_POST['event'];
$table = "event" . $event_id;

/*switch ($event_id) {
	case 1:
		$table = "event1";
		break;
	case 2:
		$table = "";
		break;
	case 3:
		$table = "";
		break;
	case 4:
		$table = "";
		break;
	case 5:
		$table = "";
		break;
	case 6:
		$table = "";
		break;
	case 7:
		$table = "";
		break;
	case 8:
		$table = "";
		break;
	case 9:
		$table = "";
		break;
	case 10:
		$table = "";
		break;
	default:
		break;
}*/

$check_sql = "SELECT * FROM {$table}";
$result = $conn->query($check_sql);
$row = $result->fetch_assoc();
if ($result->num_rows >= 20) {
			echo 'Event is full, no more registration slots available';
			
		} else {
			checkForDuplicates($conn, $table, $name, $email);
		}

$conn->close();
?>
