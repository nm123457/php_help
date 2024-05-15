<?php

	include_once 'database.php';
	include 'item.php';
	
	
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['username'])) {
		echo "<h1>Összes Licit</h1>";
		Item::getItemsFromDB();
		echo '<br><a href="mainpage.php">Vissza a főoldalra</a>';	
	} else {
		echo "<h1>Kérem jelentkezzen be az oldal megtekintéséhez.</h1>";
		echo '<a href="index.html">Bejelentkezés</a>';
	}
?>