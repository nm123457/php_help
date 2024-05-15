<?php
	function inverse($x) {
		if (!$x) {
			throw new Exception('Division by zero');
		}
		
		return 1/$x;
	}
	
	
	try {
		
	echo inverse(5);
	echo inverse(0);
	}
	catch (Exception $e) {
		echo 'Caught excpetion', $e->getMessage(), '';
	} finally {
		echo 'First finally';
	}
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>My First Webpage</title>
  </head>

  <body>
	
  </body>
</html>
