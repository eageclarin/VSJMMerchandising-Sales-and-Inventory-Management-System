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
	$result = mysqli_query($conn,"SELECT * FROM item");
?>

<!DOCTYPE html>
<html>
<head>
   
    
</head>
<body>

<?php
		if(count($_POST)>0){
			mysqli_query($conn, "UPDATE item set item_ID=' " . $_POST['item_ID'] . " ', item_Name=' " . $_POST['item_Name'] . " ', item_unit=' " . $_POST['item_unit'] . " ', item_Brand=' " . $_POST['item_Brand'] . " '
			WHERE item_ID = ' " . $_POST['item_ID'] . " ' ");
			$message = "Record Edited Successfully";
			header("Location: ./items.php");
		}
		$result = mysqli_query($conn, "SELECT * FROM item WHERE item_ID=' " . $_GET['item_ID'] . "'");
		$row = mysqli_fetch_array($result);
?>

<div class="container">
	
	<form action="./edititems.php" method="post">
		<?php if(isset($message)) { echo $message; } ?>
		<div class="user-details">

			<p> Item Name
			<input type="text" name="item_Name" value="<?php echo $row['item_Name']; ?>" required> 
			</p>
			
			<p> Item Unit
			<input type="text" name="item_unit" value="<?php echo $row['item_unit']; ?>" required>
			</p>
			
			<p> Item Brand
			<input type="text" name="item_Brand" value="<?php echo $row['item_Brand']; ?>"required>
			</p>	
		</div>

		<input class="button" type="submit" name="edit" value= "Submit" class="button">
		<button class="button" type="button" onclick="location.href='./items.php'">Cancel</button>
		
			
			
	</form>
</div>


</body>
</html>