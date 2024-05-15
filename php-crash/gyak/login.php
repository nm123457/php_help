<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
		$password = $_POST['password'];
		
		$dbServer = "localhost";
		$dbName = "due";
		$dbUser = "root";
		$dbPass = "";
		
		
		$conn = new mysqli($dbServer, $dbUser, $dbPass, $dbName);
		
		
		if ($conn->connect_error) {
			die("Kapcsolat nem jött létre" . $conn->connect_error);
		}
		
		try {/*
		
		$query = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
		
		$result = $conn->query($query);
		
		if ($result->num_rows == 1) {
			//success
			$_SESSION['username'] = $username;
			header('Location: mainpage.php');
		} else {
			//failure
			echo 'Incorrect login 2';
		}*/
		$query = "SELECT * FROM login WHERE username = '$username';";
		$result = $conn->query($query);
		$row = $result->fetch_assoc();
		if ($result->num_rows == 1) {
			if (password_verify($password, $row['password'])){
				echo "Passwords match";
			} else {echo "Passwords DONT match";}
			//success
			/*$_SESSION['username'] = $username;
			header('Location: mainpage.php');*/
		} else {
			//failure
			echo 'Incorrect login 2';
		}
		
		} catch (Exception $e) {
			echo "Kivétel dobva: " . $e->getMessage();
		} finally {}
		
	}
?>