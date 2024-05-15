<?php
	class User {
		public $name;
		public $email;
		public $password;
		
		public function __construct($name, $email, $password) {
			$this->name = $name;
			$this->email = $email;
			$this->password = $password;
		}
		
		function set_name($name) {
			$this->name = $name;
		}
		
		function get_name($name) {
			return $this->name;
		}
	}
	
	class Employee extends User {
		public function __construct($name, $email, $password, $title) {
			parent::__construct($name, $email, $password);
			$this->title = $title;
		}
		
		public function get_title() {
			return $this->title;
		}
	}
	
	$employee1 = new Employee('Sara', 'asd@gmail.com', 'abc123', 'Manager');
	
	echo $employee1->name;
	echo $employee1->email;
	echo $employee1->password;
	echo $employee1->get_title();
	
	
	$user3 = new User('John', 'asd@gmail.com', 'abc123');
	
	
	echo $user3->name;
	echo $user3->email;
	echo $user3->password;
	
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
