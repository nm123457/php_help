<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: mainpage.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="styles.css">
    <title>Bejelentkezés</title>
</head>
<body>
    <h2>Bejelentkezés</h2>
	<div class="login-container">
		<div class="login-box">
			<form action="login.php" method="post">
				<label for="username">Felhasználónév:</label>
				<input type="text" id="username" name="username" required>
				<br>
				<label for="password">Jelszó:</label>
				<input type="password" id="password" name="password" required>
				<br>
				<button type="submit">Bejelentkezés</button>
			</form>
			<a href="register_page.php">Regisztráció</a>
		</div>
	</div>
    
</body>
</html>
