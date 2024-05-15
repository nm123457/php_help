<?php
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once 'database.php';



if (isset($_SESSION['username'])) {
		?>
		
		<form action="auction_submit.php" method="POST" enctype="multipart/form-data">
		<div>
			<label for="item_name">Tárgy neve:</label>
			<input type="text" name="item_name">
		</div>
		<div>
			<label for="starting_price">Kezdő ár:</label>
			<input type="text" name="starting_price">
		</div>
		<div>
			<label for="auction_start">Aukció kezdete:</label>
			<input type="datetime-local" name="auction_start">
		</div>
		<div>
			<label for="price_dec">Ár csökkenés:</label>
			<input type="text" name="price_dec">
		</div>
		<div>
			<label for="time_dec">Idő csökkenés percben megadva:</label>
			<input type="text" name="time_dec">
		</div>
		<div>
			<label for="min_price">Ár alsó határ:</label>
			<input type="text" name="min_price">
		</div>
		<div>
			<label for="file_upload">Fájl csatolás:</label>
			<input type="file" name="file_upload">
		</div>
		<input type="submit" value="Létrehozás" name="submit_new_auction">
		</form>
		
		<?php
	} else {
		echo "<h1>Kérem jelentkezzen be az oldal megtekintéséhez.</h1>";
		echo '<a href="index.html">Bejelentkezés</a>';
	}
?>

