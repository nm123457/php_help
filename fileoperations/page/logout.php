<?php
session_start();
include 'logger.php'; // Include the logger
session_unset();
session_destroy();
header('Location: login_page.php');
exit;
?>
