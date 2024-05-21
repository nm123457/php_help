<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Comments</title>
    <style>
        .comment-container {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .navigation {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        a {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    $db = new SQLite3('opinions.db');

    // Get the total number of comments
    $totalCommentsResult = $db->query('SELECT COUNT(*) as count FROM opinions');
    $totalComments = $totalCommentsResult->fetchArray(SQLITE3_ASSOC)['count'];

    // Determine the current comment index
    $currentIndex = isset($_GET['index']) ? intval($_GET['index']) : 0;
    if ($currentIndex < 0) {
        $currentIndex = 0;
    } elseif ($currentIndex >= $totalComments) {
        $currentIndex = $totalComments - 1;
    }

    // Fetch the current comment
    $result = $db->query("SELECT * FROM opinions LIMIT 1 OFFSET $currentIndex");
    $comment = $result->fetchArray(SQLITE3_ASSOC);

    if ($comment) {
        echo "<div class='comment-container'>";
        echo "<p><strong>Username:</strong> " . htmlspecialchars($comment['username']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($comment['email']) . "</p>";
        echo "<p><strong>Opinion:</strong> " . htmlspecialchars($comment['opinion']) . "</p>";
        echo "<p><strong>Submitted on:</strong> " . htmlspecialchars($comment['datetime']) . "</p>";
        echo "</div>";
    } else {
        echo "<p>No comments available.</p>";
    }
    ?>
    <div class="navigation">
		
        <?php if ($currentIndex > 0): ?>
            <a href="comments.php?index=<?php echo $currentIndex - 1; ?>">Previous Comment</a>
        <?php endif; ?>
        <?php if ($currentIndex < $totalComments - 1): ?>
            <a href="comments.php?index=<?php echo $currentIndex + 1; ?>">Next Comment</a>
        <?php endif; ?>
    </div>
	<a href="mainpage.php">Submit opinion</a>
</body>
</html>
