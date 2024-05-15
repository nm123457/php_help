<?php 

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>My First Webpage</title>
  </head>

  <body>
  
  <?php echo "test123";
	echo "<br>";
	echo password_hash("test123", PASSWORD_DEFAULT);
	
	$input = "test123";
	$hashedPwdInDB = password_hash("test123", PASSWORD_DEFAULT);
	
	
	echo "<br>" . password_verify($input, $hashedPwdInDB);
	
	?>
	<form action="login.php" method="POST">
	<div>
		<label for="username">Name:</label>
		<input type="text" name="username">
	</div>
	<div>
		<label for="password">Password:</label>
		<input type="password" name="password">
	</div>
	<input type="submit" value="Bejelentkezés" name="submit">
	</form>
  </body>
</html>