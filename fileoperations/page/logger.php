<?php
function log_user_activity($activity) {
    $logDir = '../tmp/logs/';
    $logFile = $logDir . 'user_activity.txt';

    // Ensure the logs directory exists
    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }

    // Get the current timestamp
    $timestamp = date('Y-m-d H:i:s');

    // Get the username if logged in
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

    // Format the log entry
    $logEntry = "[$timestamp] [$username] $activity" . PHP_EOL;

    // Write the log entry to the file
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

// Log the current page access
log_user_activity("Page accessed: " . $_SERVER['REQUEST_URI']);
?>
