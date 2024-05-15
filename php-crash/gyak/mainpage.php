<?php
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['username'])) {
		echo "<h1>Üdv az oldalon, " . $_SESSION['username'] . "!</h1>";
		echo '<br><a href="auction.php">Aukció indítása</a>';
		echo '<br><a href="bidding.php">Licitálás</a>';
		echo '<br><a href="logout.php">Logout</a>';	
	} else {
		echo "<h1>Kérem jelentkezzen be az oldal megtekintéséhez.</h1>";
		echo '<a href="index.html">Bejelentkezés</a>';
	}
?>