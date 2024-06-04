<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles.css">
    <title>Főoldal</title>
</head>
<body>
	<div class="main-container">
		<h2>Üdv, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
		<?php if ($_SESSION['role'] === 'user'): ?>
		<form action="task_page.php" method="post">
			<button type="submit">Feladatok</button>
		</form>
		<?php endif; ?>
		<?php if ($_SESSION['role'] === 'admin'): ?>
		<form action="admin_task_page.php" method="post">
			<button type="submit">Admin funkciók</button>
		</form>
		<?php endif; ?>
		<form action="copydb.php" method="post">
			<button type="submit">Adatbázis letöltése</button>
		</form>
		
		<br><br>
		<form action="logout.php" method="post">
			<button type="submit">Kijelentkezés</button>
		</form>
	</div>
</body>
</html>
