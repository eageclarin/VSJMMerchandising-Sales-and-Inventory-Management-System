<?php
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "VSJM";
	$conn=mysqli_connect($server, $user, $pass, "$db");
	
	if(!$conn){
		die('Could not connect MYSql:' .mysql_error());
	}
?>

<?php
	$result = mysqli_query($conn,"SELECT * FROM inventory");
?>


<!DOCTYPE html>
<html>
<body>
<?php
		if(count($_POST)>0){
			mysqli_query($conn, "UPDATE inventory set item_ID=' " . $_POST['item_ID'] . " ', item_Name=' " . $_POST['item_Name'] . " ', item_unit=' " . $_POST['item_unit'] . " ', 
			item_Brand=' " . $_POST['item_Brand'] . " ', item_RetailPrice=' " . $_POST['item_RetailPrice'] . " ', Item_markup=' " . $_POST['Item_markup'] . " ', 
			item_Stock=' " . $_POST['item_Stock'] . " ', item_category=' " . $_POST['item_category'] . " ',
			WHERE item_ID = ' " . $_POST['item_ID'] . " ' ");
			$message = "Record Editted Successfully";
			header("Location: inventory.php");
		}
		$result = mysqli_query($conn, "SELECT * FROM inventory WHERE item_ID=' " . $_GET['item_ID'] . "'");
		$row = mysqli_fetch_array($result);
?>

<form action="./editinventory.php" method="post">
	<?php if(isset($message)) { echo $message; } ?>
	<p> Item ID
	<input type="text" name="item_ID" value="<?php echo $row['item_ID']; ?>" required>
	</p>
	
	<p> Item Name
	<input type="text" name="item_Name" value="<?php echo $row['item_Name']; ?>" required> 
	</p>
	
	<p> Item Unit
	<input type="text" name="item_unit" value="<?php echo $row['item_unit']; ?>" required>
	</p>
	
	<p> Item Brand
	<input type="text" name="item_Brand" value="<?php echo $row['item_Brand']; ?>"required>
	</p>
	
	<p> Item Retail Price
	<input type="text" name="item_RetailPrice" value="<?php echo $row['item_RetailPrice']; ?>"required>
	</p>
	
	<p> Item Markup
	<input type="text" name="Item_markup" value="<?php echo $row['Item_markup']; ?>"required>
	</p>
	
	<p> Item Stock
	<input type="text" name="item_Stock" value="<?php echo $row['item_Stock']; ?>"required>
	</p>
	
	<p> Item Category
	<input type="text" name="item_category" value="<?php echo $row['item_category']; ?>"required>
	</p>
	
	
	<input type="submit" name="edit" value= "Submit" class="button">
	<button type="button" onclick="location.href='inventory.php'">Back</button>
</form>

</body>
</html>