<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feladat létrehozás</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <form action="create_task.php" method="post" enctype="multipart/form-data">
        <label for="task_name">Feladat neve:</label>
        <input type="text" id="task_name" name="task_name" required><br><br>
        
        <label for="due_date">Befejezendő ekkorra:</label>
        <input type="datetime-local" id="due_date" name="due_date" required><br><br>
        
        <label for="file">Csatolt fájl:</label>
        <input type="file" id="file" name="file" required><br><br>
        
        <button type="submit">Létrehozás</button>
    </form>
</body>
</html>
