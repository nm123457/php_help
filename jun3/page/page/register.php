<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'] === null ? null : $_POST['email'];
    $password = $_POST['password'];

    try {
        $dbPath = '../../tmp/v2_database.db';

        if (!file_exists($dbPath)) {
            throw new Exception("Database file not found: $dbPath");
        }

        $pdo = new PDO('sqlite:' . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "Felhasználónév foglalt";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare('INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)');
            $stmt->execute([
                'username' => $username,
                'password' => $hashed_password,
                'email' => $email,
                'role' => 'user'
            ]);

            echo "Regisztráció sikeres! <a href='index.php'>Bejelentkezés</a>.";
        }
    } catch (PDOException $e) {
        echo "PDO Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "General Error: " . $e->getMessage();
    }
} else {
    header("Location: register_page.php");
    exit;
}
?>
