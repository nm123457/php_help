<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opinion Form</title>
</head>
<body>
    <?php
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize input
        $username = substr(trim($_POST['username']), 0, 30);
        $email = substr(trim($_POST['email']), 0, 30);
        $opinion = substr(trim($_POST['opinion']), 0, 255);
        $datetime = date('Y-m-d H:i:s');

        // Set up the SQLite database
        $db = new SQLite3('opinions.db');

        // Create opinions table if it doesn't exist
        $db->exec("CREATE TABLE IF NOT EXISTS opinions (
            id INTEGER PRIMARY KEY,
            username TEXT,
            email TEXT,
            opinion TEXT,
            datetime TEXT
        )");

        // Create badwords table if it doesn't exist
        $db->exec("CREATE TABLE IF NOT EXISTS badwords (
            id INTEGER PRIMARY KEY,
            word TEXT
        )");

        // Fetch all bad words from the badwords table
        $result = $db->query('SELECT word FROM badwords');
        $badwords = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $badwords[] = $row['word'];
        }

        // Check if the opinion contains any bad words
        $containsBadWord = false;
        foreach ($badwords as $badword) {
            if (stripos($opinion, $badword) !== false) {
                $containsBadWord = true;
                break;
            }
        }

        if ($containsBadWord) {
            echo "<p style='color: red;'>Your opinion contains inappropriate language. Please modify your input.</p>";
        } else {
            // Prepare and execute the insert statement
            $stmt = $db->prepare('INSERT INTO opinions (username, email, opinion, datetime) VALUES (:username, :email, :opinion, :datetime)');
            $stmt->bindValue(':username', $username, SQLITE3_TEXT);
            $stmt->bindValue(':email', $email, SQLITE3_TEXT);
            $stmt->bindValue(':opinion', $opinion, SQLITE3_TEXT);
            $stmt->bindValue(':datetime', $datetime, SQLITE3_TEXT);
            $stmt->execute();

            echo "<p>Opinion submitted successfully!</p>";
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username (max 30 characters):</label><br>
        <input type="text" id="username" name="username" maxlength="30" required><br><br>

        <label for="email">Email (max 30 characters):</label><br>
        <input type="email" id="email" name="email" maxlength="30" required><br><br>

        <label for="opinion">Opinion (max 255 characters):</label><br>
        <textarea id="opinion" name="opinion" maxlength="255" required></textarea><br><br>

        <input type="submit" value="Submit">
    </form>

    <p><a href="comments.php">View Submitted Comments</a></p>
</body>
</html>
