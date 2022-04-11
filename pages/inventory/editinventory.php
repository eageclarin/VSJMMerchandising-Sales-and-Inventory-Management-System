<?php
	error_reporting(0);
	include_once '../../env/conn.php';
	$itemID = $_SESSION['itemID'];
	echo $_POST['editID'];
	if (isset($_POST['edit'])) { //UPDATING INVENTORY
			echo $_POST['editID'];
			$itemID = $_POST['editID'];
			$item_Name =$_POST['editName'];
			$item_Unit =$_POST['editUnit'];
			$item_Brand =$_POST['editBrand'];
			$item_Retail =$_POST['editRetail'];
			$item_Markup =$_POST['editMarkup'];
			$item_Stock =$_POST['editStock'];
			$item_Category = $_POST['editCategory'];

		if($item_Stock<=10){
			$pend = 1;
		} else{
			$pend =0;
		}
		
		$updateStatus = "UPDATE inventory SET in_pending=$pend, item_Stock = '$item_Stock', item_RetailPrice = '$item_Retail', Item_markup = '$item_Markup' WHERE item_ID = '$itemID' AND branch_ID=1;";
		$sqlUpdate = mysqli_query($conn,$updateStatus);
		//$updateStatus = "UPDATE item SET item_Name = '$item_Name', item_unit='$item_Unit', item_Brand ='$item_Brand', item_Category = '$item_Category' WHERE item_ID = '$itemID';";
		//$sqlUpdate = mysqli_query($conn,$updateStatus);
		if ($sqlUpdate) {
		  echo "Update in inventory success <br/>";
		} else {
		  echo mysqli_error($conn);
		} 
		unset($_POST['edit']);
		header("Location: ./inventory.php");
	}

	/**if(isset($_POST['edit'])){
		$_SESSION['itemID'] = $_POST['itemID'];
		$itemID = $_POST['itemID'];
		header("Location: ./inventory.php");
	  }**/



/*
<!DOCTYPE html>
<html>
<body>
<?php include 'navbar.html'; ?>
<div id="content">
<?php 
	$sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) WHERE item.item_ID='$itemID' ;";   
	$result = mysqli_query($conn,$sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck>0){
		while ($row = mysqli_fetch_assoc($result)) {
			$item_Name = $row['item_Name'];
			$item_Unit =$row['item_unit'];
			$item_Brand =$row['item_Brand'];
			$item_Retail =$row['item_RetailPrice'];
			$item_Markup =$row['Item_markup'];
			$item_Stock =$row['item_Stock'];
			$item_Category = $row['item_Category'];
			
		}
	}

?>
<form action="./editinventory.php" method="post">
<input type="hidden" name="item_ID" value=<?php echo $itemID; ?>>

	<p> Item ID
	<input type="text" name="item_ID" value="<?php echo $itemID; ?>"required disabled>
	</p>

	<p> Item Name
	<input type="text" name="item_Name" value="<?php echo $item_Name; ?>"required disabled>
	</p>

	<p> Item Unit
	<input type="text" name="item_Unit" value="<?php echo $item_Unit ?>"required disabled>
	</p>
	
	<p> Item Brand
	<input type="text" name="item_Brand" value="<?php echo $item_Brand ?>"required disabled>
	</p>

	<p> Item Retail Price
	<input type="number" name="item_RetailPrice" value="<?php echo  $item_Retail?>"required>
	</p>
	
	<p> Item Markup
	<input type="number" name="item_Markup" value="<?php echo  $item_Markup?>"required>
	</p>
	
	<p> Item Stock
	<input type="number" name="item_Stock" value="<?php echo $item_Stock  ?>"required>
	</p>
	
	<p> Item Category
	
	
	<select name="item_Category" id="item_Category" style="height:30px;" >
			<option value="<?php echo  $item_Category?>" selected ><?php echo  $item_Category?></option>
            <option value="Electrical" >Electrical</option>
            <option value="Plumbing">Plumbing</option>
            <option value="Architectural"> Architectural</option>
            <option value="Paints">Paints</option>
            <option value="Bolts">Bolts</option>
            <option value="Tools">Tools</option>
        </select>
	</p>
	
	<input type="submit" name="update" value= "Update" class="button">
	<button type="button" onclick="location.href='inventory.php'">Back</button>
</form>
</div>
</body>
</html>
*/?>
