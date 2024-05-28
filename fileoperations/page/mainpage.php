<?php
session_start();
include 'logger.php'; // Include the logger
if (!isset($_SESSION['username'])) {
    header('Location: login_page.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <form action="file_upload_page.php" method="post">
        <button type="submit">Fájl feltöltés</button>
    </form>
	<form action="item_list.php" method="post">
        <button type="submit">Tárgyak listája</button>
    </form>
	<form action="download_db.php" method="post">
        <button type="submit">Adatbázis letöltése</button>
    </form>
    <br><br>
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
