<?php 
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
	include_once 'database.php';
	
	$disallowed_words = ['badword1', 'badword2', 'badword3'];

	// Function to check for disallowed words in the item name
	function containsDisallowedWords($string, $disallowed_words) {
		foreach ($disallowed_words as $word) {
			if (stripos($string, $word) !== false) {
				return true;
			}
		}
		return false;
	}
	
	function handleFileUpload($itemID) {
		$allowed_ext = array('png', 'jpg', 'jpeg', 'gif', 'txt');
		
		if (!empty($_FILES['file_upload']['name'])) {
			$file_name = $_FILES['file_upload']['name'];
			$file_size = $_FILES['file_upload']['size'];
			$file_tmp = $_FILES['file_upload']['tmp_name'];
			
			//get extension_loaded
			$file_ext = explode('.', $file_name);
			$file_ext = strtolower(end($file_ext));
			$new_file_name = $itemID . '.' . $file_ext;
			$target_dir = "uploads/${new_file_name}";
			
			// validate extension
			if (in_array($file_ext, $allowed_ext)) {
				if ($file_size <= 1000000) {
					move_uploaded_file($file_tmp, $target_dir);
					$message = '<p style="color: green;">File successfully uploaded</p>';
					echo $message;
		
				} else {
					$message = '<p style="color: red;">File is too large</p>';
					echo $message;
				}
			} else {
				$message = '<p style="color: red;">Invalid file type</p>';
				echo $message;
			}
		} else {
			$message = '<p style="color: red;">Please choose a file</p>';
			echo $message;
		}
	}
	
	if(isset($_POST['submit_new_auction'])) {
		$item_name = $_POST['item_name'];
		
		if (containsDisallowedWords($item_name, $disallowed_words)) {
        echo '<p style="color: red;">The item name contains disallowed words. Please choose a different name.</p>';
    } else {
		$sqlQuery = "INSERT INTO items (item_name, price, price_inc, auction_start, time_inc, min_price) 
		VALUES ('{$_POST['item_name']}', {$_POST['starting_price']}, {$_POST['price_dec']}, '{$_POST['auction_start']}', {$_POST['time_dec']},
		{$_POST['min_price']})";
		try {
			
			$result = DatabaseFunc::dbConnect()->query($sqlQuery);
			
			if ($result === true) {
				//INCORRECT QUERY, IF EVERYTHING MATCHES WILL GIVE WRONG ID
				$sqlQuery2 = "SELECT item_id FROM items WHERE item_name = '{$_POST['item_name']}' AND auction_start = '{$_POST['auction_start']}'";
				$id_result = DatabaseFunc::dbConnect()->query($sqlQuery2);
				$row = $id_result->fetch_assoc();
				echo "Row inserted successfully. Last ID: " . $row['item_id'];
				handleFileUpload($row['item_id']);
			} else {
				echo "Error: " . DatabaseFunc::dbConnect()->error;
			}
		} catch (Exception $e) {
			echo "Hiba exception: " . $e->getMessage();
		} finally {
			
		}
	}
	}
?>