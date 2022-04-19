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
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Edit Supplier Information</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<?php
	// Redirects back to main if GET and POST variables are not set
	if(!isset($_POST['item_ID']) && !isset($_GET['item_ID'])){
		header("Location: ./items.php");
		exit;
	}
?>
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
	
	<form action="./edititems.php" method="post">
	<input type="hidden" name="item_ID" value=<?php echo $_GET['item_ID']; ?>>
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
		
		<button type="button" class="trigger-btn" data-toggle="modal" data-target="#myModal">Update</button>
		<button class="button" type="button" onclick="location.href='./items.php'">Cancel</button>

	
		<!-- Modal HTML -->
		<div id="myModal" class="modal fade">
		<div class="modal-dialog modal-confirm">
			<div class="modal-content">
				<div class="modal-header">			
					<h4 class="modal-title">Are you sure?</h4>	
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<p>Do you really want to update these records? </p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
					<input type="submit" class="btn btn-danger" name="edit" value= "Update" type="submit">
					
				</div>
				</form>	
			</div>
		</div>
	</div>     
		

</body>
</html>