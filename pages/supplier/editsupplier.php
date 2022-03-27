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
	$result = mysqli_query($conn,"SELECT * FROM supplier");
?>

<!DOCTYPE html>
<html>
<body>
<?php
		if(count($_POST)>0){
			mysqli_query($conn, "UPDATE supplier set supplier_ID=' " . $_POST['supplier_ID'] . " ', supplier_Name=' " . $_POST['supplier_Name'] . " ', supplier_ContactPerson=' " . $_POST['supplier_ContactPerson'] . " ', 
			supplier_ContactNum=' " . $_POST['supplier_ContactNum'] . " ', supplier_Address=' " . $_POST['supplier_Address'] . " ' 
			WHERE supplier_ID = ' " . $_POST['supplier_ID'] . " ' ");
			$message = "Record Editted Successfully";
			header("Location: ./suppliers.php");
		}
		$result = mysqli_query($conn, "SELECT * FROM supplier WHERE supplier_ID=' " . $_GET['supplier_ID'] . "'");
		$row = mysqli_fetch_array($result);
?>

<form action="./editsupplier.php" method="post">
	<?php if(isset($message)) { echo $message; } ?>
	<p> Supplier ID
	<input type="text" name="supplier_ID" value="<?php echo $row['supplier_ID']; ?>">
	</p>
	
	<p> Supplier Name
	<input type="text" name="supplier_Name" value="<?php echo $row['supplier_Name']; ?>">
	</p>
	
	<p> Supplier Contact Person
	<input type="text" name="supplier_ContactPerson" value="<?php echo $row['supplier_ContactPerson']; ?>">
	</p>
	
	<p> Supplier Contact Number
	<input type="text" name="supplier_ContactNum" value="<?php echo $row['supplier_ContactNum']; ?>">
	</p>
	
	<p> Supplier Address
	<input type="text" name="supplier_Address" value="<?php echo $row['supplier_Address']; ?>">
	</p>
	
	
	<input type="submit" name="edit" value= "Submit" class="button">
	<button type="button" onclick="location.href='./suppliers.php'">Back</button>
</form>

</body>
</html>