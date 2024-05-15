<?php
	//VARIABLES
	$name = 'Brad';
	$age = 40;
	$has_kids = true;
	$cash_on_hands = 20.75;
	
	//CONSTANTS
	define('HOST', 'localhost');
	define('DB_NAME', 'dev_db');
	
	//ARRAYS
	$numbers = [1,44,55,22];
	$names = ['Brad', 'Angel'];
	
	//ASSOCIATIVE ARRAY
	$hex = [
	'red' => '#fff'	];
	
	$person = [
		'firs_name' => 'Brad',
		'last_name' => 'Traversy',
		'email' => '@gmgmsd'
	];
	
	$people = [
		[
		'firs_name' => 'Brad',
		'last_name' => 'Traversy',
		'email' => '@gmgmsd'
		],
		[
		'firs_name' => 'Brad2',
		'last_name' => 'Traversy',
		'email' => '@gmgmsd'
		],
		[
		'firs_name' => 'Brad3',
		'last_name' => 'Traversy',
		'email' => '@gmgmsd'
		],
	];
	
	//var_dump(json_encode($people)); turn to JSON object
	
	$t = date("H");
	
	if ($t < 12) {
		echo 'Good morning';
	} elseif ($t < 21) {
		echo 'Good afternoon';
		
	} else {
		echo 'Good evening';
	}
	
	$posts = ['First post'];
	//IF STATEMENT
	if (!empty($posts)) {
		echo $posts[0];
	} else {
		echo 'N posts';
	}
	//TERNARY OPERATOR
	echo !empty($posts) ? $posts[0] : 'No POSTS';
	$firstPost = !empty($posts) ? $posts[0] : 'No POSTS';
	
	$firstPost =  $posts[0] ?? null; //if not empty built in
	
	echo !empty($posts) ? $posts[0] : 'No POSTS';
	
	//SWITCH
	$favcolor = 'red';
	switch($favcolor) {
		case 'red':
			echo 'Your color is red';
			break;
		case 'blue':
			echo 'Your color is blue';
			break;
		case 'green':
			echo 'Your color is green';
			break;
		default:
			echo 'Your color is not red green or blue its somehting else';
			
			
	}
	//LOOPS
	
	//FOR LOOP
	for ($x = 0; $x <= 10; $x++) {
		echo $x . '<br>';
	}
	//WHILE LOOP
	$x = 1;
	while ($x <= 15) {
		echo $x . '<br>';
		$x = $x + 1;
	}
	// DO WHILE LOOP
	$x = 1;
	do {
		echo $x . '<br>';
		$x = $x + 1;
	} while ($x <= 5);
	//FOREACH LOOP
	
	$posts = ['first post', 'second post','third post'];
	
	for($x = 0; $x < count($posts); $x++)
	{
		echo $posts[$x];
	}
	
	foreach ($posts as $index => $post) {
		echo $index . ' - ' . $post;
	}
	//FOREACH ON ASSOCIATIVE ARRAY
	foreach ($person as $key => $value) {
		echo "$key - $value<br>";
	}
	//FUNCTIONS
	function registerUser($email) {
		echo $email . ' registered';
	}
	registerUser('Brad');
	
	function sum($n1 = 1, $n2 = 1) {
		return $n1 + $n2;
	}
	$numberr =  sum();
	echo $numberr;
	
	$subtract = function($n1, $n2) {
		return $n1 - $n2;
	};
	echo $subtract(10,4);
	
	//ARROW FUNTIONS
	$multiply = fn($n1, $n2) => $n1 * $n2;
	echo $multiply(9,9);
	
	//ARRAY FUNTIONS (BUILT IN FUNCTIONS)
	
	$fruits = ['apple', 'orange', 'Pear'];
	echo count($fruits); //ARRAY LENGTH
	var_dump(in_array('orange', $fruits)); //ARRAY CHECK IF ELEMENT IS IN OR NOT
	$fruits[] = 'grape'; //ADDING NEW ARRAY ELEMETNS
	array_push($fruits, 'blueberry', 'strawberry');
	array_unshift($fruits, 'mango'); //ADD TO BEGINNING
	print_r($fruits);
	//REMVOE FROM ARRAY
	array_pop($fruits); //REMVOE LAST
	array_shift($fruits); // REMVOE FIRST
	unset($fruits[2]); // REMOVE SPECIFIC ELEMENT
	print_r($fruits);
	
	//SPLIT INTO 2 (INTO ONE ARRAY CONTAINING 2 ARRAYS)
	$chunked_array = array_chunk($fruits, 2);
	print_r($chunked_array);
	
	//CONCAT ARRAYS
	$arr1 = [1,2,3];
	$arr2 = [4,5,6];
	
	$arr3 = array_merge($arr1, $arr2);
	$arr4 = [...$arr1, ...$arr2];
	echo '<br><br>';
	print_r($arr4);
	
	//COMBINE INTO ASSOCIATIVE ARRAY
	$a = ['green', 'red'];
	$b = ['avocado', 'apple'];
	
	$c = array_combine($a, $b); //first = keys, second = values
	print_r($c);
	
	$keys = array_keys($c);
	print_r($keys);
	
	//FLIP KEYS AND VALUES
	$flipped = array_flip($c);
	print_r($flipped);
	
	//RANGE
	$number_range = range(1,20);
	$new_numbers = array_map(function($number) {
		return "Number ${number}";
	}, $number_range);
	
	print_r($new_numbers);

	//FILTER ARRAYS
	$lessthan10 = array_filter($number_range, fn($number) => $number <= 10);
	echo '<br><br>';
	print_r($lessthan10);
	
	//ARRAY REDUCE, ADDS TOGETHER ALL ELEMENTS
	$sum = array_reduce($number_range, fn($carry, $number) => $carry + $number);
	var_dump($sum);
	
	//STRING FUNCTIONS
	$string = 'Hello world';
	echo strlen($string); // LENGTH
	echo strpos($string, 'o'); // FIRST POSITION OF GIVEN CHARACTER
	echo strrpos($string, 'o'); // LAST POSITION OF GIVEN CHARACTER
	echo strrev($string); // REVERSE A STRING
	echo strtolower($string); //ALL LOWERCASE
	echo strtoupper($string); //ALL UPPERCASE
	echo ucwords($string); // ONLY FIRST LETTER TO UPPERCASE
	echo str_replace('World', 'Everyone', $string); // REPLACE PART OF THE STRING
	echo substr($string, 0,5); //SUBSTRING
	echo substr($string, 5);
	if (str_starts_with($string, 'Hello')) {
		echo 'YES';
	};
	if (str_ends_with($string, 'ld')) {
		echo 'YES';
	};
	
	$string2 = '<h1>Hello</h1>';
	echo $string2;
	echo htmlspecialchars($string2);
	
	printf('%s likes to %s', 'Brad', 'code');  
	printf('1+1=%f',1+1);
	
	//SUPERGLOBALS
	
	//GET AND POST
	if (isset($_POST['submit'])) {
		
	echo $_POST['name'];
	echo $_POST['age'];
	}
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>My First Webpage</title>
  </head>

  <body>
	<?php  ?>
	<a href="<?php echo $_SERVER['PHP_SELF']; ?>?name=Brad&age=30">Click</a>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	<div>
		<label for="name">Name:</label>
		<input type="text" name="name">
	</div>
	<div>
		<label for="age">Age:</label>
		<input type="text" name="age">
	</div>
	<input type="submit" value="Submit" name="submit">
	</form>
  </body>
</html>
