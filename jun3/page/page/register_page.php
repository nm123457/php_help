<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="styles.css">
    <title>Regisztráció</title>
</head>
<body>
    <h2>Regisztráció</h2>
	<div class="login-container">
	<div class="login-box">
    <form action="register.php" method="post">
        <label for="username">Felhasználónév:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="email">Email (nem kötelező):</label>
        <input type="text" id="email" name="email">
        <br>
        <label for="password">Jelszó:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Regisztráció</button>
    </form>
	<a href="index.php">Bejelentkezés</a>
	</div>
	</div>
</body>
</html>
