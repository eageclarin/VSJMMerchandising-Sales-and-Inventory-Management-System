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
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Supplier Information</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
	<link rel="stylesheet" href="supplier.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
	

<body>
<a href="../../index.php"><button> home </button></a>
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
	

<div class="text-center">
	<!-- Button HTML (to Trigger Modal) -->
	<button type="button" class="trigger-btn" data-toggle="modal" data-target="#myModal">Update</button>
	<button type="button" onclick="location.href='./suppliers.php'">Back</button>
		
</div>

<!-- Modal HTML -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">&#xE5CD;</i>
				</div>				
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