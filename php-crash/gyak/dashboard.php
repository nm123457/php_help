<?php 
	session_start();
	
	if (isset($_SESSION['username'])) {
		echo "<h1>Üdv az oldalon, " . $_SESSION['username'] . "!</h1>";
		echo '<a href="logout.php">Logout</a>';	
	} else {
		echo "<h1>Kérem jelentkezzen be az oldal megtekintéséhez.</h1>";
		echo '<a href="/php-crash/02_output.php">Bejelentkezés</a>';
	}
?>