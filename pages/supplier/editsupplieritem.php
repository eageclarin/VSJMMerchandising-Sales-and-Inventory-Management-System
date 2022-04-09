<html>
	<head>
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
		<div id ="supplieritemform">

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

				<input type="text" name="supplierItem_CostPrice" value="<?php echo $orig['supplierItem_CostPrice']; ?>">
				</p>

				<input type="hidden" name="supplier_ID" value="<?php echo $supplier_ID; ?>">

				<input type="submit" name="submit" value="Submit" class="button">

			</form>

			<?php echo"<button onclick=\"location.href='suppliertable.php?supplier_ID=".$supplier_ID."'\">Back</button>"; ?>

		</div>
	</body>
</html>