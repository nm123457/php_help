<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Define the path to the SQLite database
        $dbPath = dirname(__DIR__) . '/tmp/database.db';

        // Check if the database file exists
        if (!file_exists($dbPath)) {
            throw new Exception("Database file not found: $dbPath");
        }

        // Create a new PDO instance to connect to the SQLite database
        $pdo = new PDO('sqlite:' . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the username already exists
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "Username already taken. Please choose another one.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)');
            $stmt->execute([
                'username' => $username,
                'password' => $hashed_password,
                'role' => 'user'
            ]);

            echo "Registration successful! You can now <a href='index.php'>login</a>.";
        }
    } catch (PDOException $e) {
        echo "PDO Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "General Error: " . $e->getMessage();
    }
} else {
    // If the request method is not POST, redirect to the registration page
    header("Location: register_page.php");
    exit;
}
?>
