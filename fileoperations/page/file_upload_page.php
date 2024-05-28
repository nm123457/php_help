<?php
session_start();
include 'logger.php'; // Include the logger

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload Page</title>
</head>
<body>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div style="color: red;"><?= $_SESSION['error_message'] ?></div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <form action="file_upload.php" method="post" enctype="multipart/form-data">
        <label for="item_name">Item Name:</label>
        <input type="text" id="item_name" name="item_name" required><br><br>
        
        <label for="auction_start">Auction Start:</label>
        <input type="datetime-local" id="auction_start" name="auction_start" required><br><br>
        
        <label for="auction_end">Auction End:</label>
        <input type="datetime-local" id="auction_end" name="auction_end" required><br><br>
        
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required><br><br>
        
        <label for="used_item">Used Item?:</label>
        <input type="checkbox" id="used_item" name="used_item"><br><br>
        
        <label for="file">Attach File:</label>
        <input type="file" id="file" name="file" required><br><br>
        
        <button type="submit">Submit</button>
    </form>
</body>
</html>
