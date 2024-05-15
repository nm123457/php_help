<?php

	session_start();
	//GET AND POST
	if (isset($_POST['submit'])) {
		
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
	$password =  $_POST['password'];
	
	if ($username == 'john' && $password == 'abc123') {
		$_SESSION['username'] = $username;
		header('Location: /php-crash/extras/dashboard.php');
		
	} else {
		echo 'Incorrect login';
	}
	
	}
	
	//COOKIES
	setcookie('name', 'Brad', time() + 86400 * 30);
	if(isset($_COOKIE['name'])) {
		echo $_COOKIE['name'];
	}
	setcookie('name', '', time() - 86400 * 30);
	//SESSIONS
	
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>My First Webpage</title>
  </head>

  <body>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
	<div>
		<label for="username">Name:</label>
		<input type="text" name="username">
	</div>
	<div>
		<label for="password">Age:</label>
		<input type="text" name="password">
	</div>
	<input type="submit" value="Submit" name="submit">
	</form>
  </body>
</html>
