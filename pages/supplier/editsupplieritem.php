<html>
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
		
		<?php
			include_once '../../env/conn.php';
		?>
	
	</head>
	<body>

		<?php

			if(isset($_GET['item_ID'])){
					$item_ID=$_GET['item_ID'];
			}
			if(isset($_GET['supplier_ID'])){
				$supplier_ID=$_GET['supplier_ID'];
			}
			else if(isset($_POST['supplier_ID'])){
				$supplier_ID=$_POST['supplier_ID'];
			}

			if(count($_POST)>0){
				mysqli_query($conn, "UPDATE item set item_ID=' " . $_POST['item_ID'] . " ', item_Name=' " . $_POST['item_Name'] . " ', item_unit=' " . $_POST['item_unit'] . " ', 
				item_Brand=' " . $_POST['item_Brand'] . " '
				WHERE item_ID = ' " . $_POST['item_ID'] . " ' ");
				$message = "Record Edited Successfully";

				mysqli_query($conn,"UPDATE supplier_item set supplierItem_CostPrice='".$_POST['supplierItem_CostPrice']."' WHERE supplier_ID ='".$supplier_ID."' and item_ID ='".$_POST['item_ID']."'");


				header("Location: ./suppliertable.php?supplier_ID=".$supplier_ID);
				exit();
			}

			$result = mysqli_query($conn, "SELECT * from item inner join supplier_item on item.item_ID=supplier_item.item_ID where supplier_ID = ".$supplier_ID." and item.item_ID=".$item_ID."") or die( mysqli_error($conn));
			$orig=mysqli_fetch_array($result);
		?>

			<h3>Edit Item</h3>

			<form action = "./editsupplieritem.php" method="post" id="myForm">
				
				<input type="hidden" name="item_ID" value="<?php echo $item_ID; ?>">

				<p> Name
				<input type="text" name="item_Name" value="<?php echo $orig['item_Name']; ?>">
				</p>

				<p> Unit
				<input type="text" name="item_unit" value="<?php echo $orig['item_unit']; ?>">
				</p>

				<p> Brand
				<input type="text" name="item_Brand" value="<?php echo $orig['item_Brand']; ?>">
				</p>

				<p> Cost Price
				<input type="text" name="supplierItem_CostPrice" value="<?php echo $orig['supplierItem_CostPrice']; ?>">
				</p>

				<input type="hidden" name="supplier_ID" value="<?php echo $supplier_ID; ?>">

			
	<div class="text-center">
	<!-- Button HTML (to Trigger Modal) -->
		<button type="button" class="trigger-btn" data-toggle="modal" data-target="#myModal">Update</button>
		<?php echo"<button onclick=\"location.href='suppliertable.php?supplier_ID=".$supplier_ID."'\">Back</button>"; ?>
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