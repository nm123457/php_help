<?php 
include_once 'database.php';

Class Item {
	public $name;
	public $price;
	public $auction_start;
	public $price_dec;
	public $time_dec;
	public $min_price;
	
	public static function getItemsFromDB() {
		$sqlQuery = 'SELECT * FROM items';
		$results = DatabaseFunc::dbConnect()->query($sqlQuery);
		if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                echo "Name: " . $row['item_name'] . ", Price: " . $row['price'] . "<a href='/php-crash/gyak/itempage.php?id=" . $row['item_id'] . "'>Link</a><br>";
            }
        } else {
            echo "No items found.";
        }
	}
}
?>