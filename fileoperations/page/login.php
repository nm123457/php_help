<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $dbPath = dirname(__DIR__) . '/tmp/database.db';
        if (!file_exists($dbPath)) {
            throw new Exception("Database file not found: $dbPath");
        }

        $pdo = new PDO('sqlite:' . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('SELECT id, password FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
			include 'logger.php'; // Include the logger
            header('Location: mainpage.php');
            exit;
        } else {
            echo "Invalid username or password.";
        }
    } catch (PDOException $e) {
        echo "PDO Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "General Error: " . $e->getMessage();
    }
} else {
    header('Location: login_page.php');
    exit;
}
?>
