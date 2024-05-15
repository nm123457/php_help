<?php 
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

	include_once 'database.php';
	
	if (isset($_SESSION['username'])) {
		
// Check if the 'id' parameter is set in the URL
	if(isset($_GET['id'])) {
    // Retrieve the value of the 'id' parameter
		$id = $_GET['id'];

		// Query to retrieve data from the database based on the 'id' parameter
		$sql = "SELECT * FROM items WHERE item_id = $id";

		// Execute the query
		$result = DatabaseFunc::dbConnect()->query($sql);

		if ($result->num_rows > 0) {
			// Fetch the row from the result set
			$row = $result->fetch_assoc();

			// Display the data
			echo "<h1>Item Details</h1>";
			echo "<p>ID: " . $row['item_id'] . "</p>";
			echo "<p>Name: " . $row['item_name'] . "</p>";
			// Add more fields as needed
			
			$start_datetime = strtotime($row['auction_start']);
			$current_datetime = time();
			$elapsed_time_minutes = ($current_datetime - $start_datetime) / 60;

		// Calculate new price based on decrements
		$new_price = $row['price'] - ($row['price_inc'] * floor($elapsed_time_minutes / $row['time_inc']));
		//ERROR: IF TIME IS GREATER IT DISPLAYS HIGHER PRICE, MAKE SURE IT CANT DISPLAY HIGHER PRICE THAN WHAT WAS GIVEN
		// Check if new price is above minimum price
		if ($new_price < $row['min_price']) {
			// Mark auction as expired
			$price = $row['min_price'];
		} else {
			// Update price in database
			$price = $new_price;
			
		}
			echo "<p>Current price: " . $price . "</p>";
			
			echo '<a href="download.php?file=' . urlencode($row['item_id']) . '.txt' . '">Download File</a>';
            
			
		} else {
			// No record found for the given id
			echo "No record found for ID: $id";
		}
	} else {
		// 'id' parameter not provided in the URL
		echo "No ID parameter provided in the URL";
	}
	} else {
		echo "<h1>Kérem jelentkezzen be az oldal megtekintéséhez.</h1>";
		echo '<a href="index.html">Bejelentkezés</a>';
	}
?>