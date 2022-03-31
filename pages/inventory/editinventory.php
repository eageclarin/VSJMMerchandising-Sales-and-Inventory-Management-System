<?php
	include_once '../../env/conn.php';
	$itemID = $_SESSION['itemID'];
	echo $itemID;

	if (isset($_POST['update'])) { //UPDATING INVENTORY
		$item_Retail =$_POST['item_RetailPrice'];
			$item_Markup =$_POST['item_Markup'];
			$item_Stock =$_POST['item_Stock'];
			$item_Category = $_POST['item_Category'];

		$updateStatus = "UPDATE inventory SET in_pending=0, item_Stock = '$item_Stock', item_RetailPrice = '$item_Retail', Item_markup = '$item_Markup', item_category = '$item_Category'   WHERE item_ID = '$itemID';";
		$sqlUpdate = mysqli_query($conn,$updateStatus);
		if ($sqlUpdate) {
		  echo "Update in inventory success <br/>";
		} else {
		  echo mysqli_error($conn);
		} 
		unset($_POST['update']);
	}
?>



<!DOCTYPE html>
<html>
<body>
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
			$item_Category = $row['item_category'];
			
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
	
	
	<select name="item_Category" id="item_Category" style="height:30px;">
			<option value="<?php echo  $item_Category?>" selected ><?php echo  $item_Category?></option>
            <option value="Elec\'l" >Elec'l</option>
            <option value="Plumbing">Plumbing</option>
            <option value="Arch\'l"> Arch'l</option>
            <option value="Paints">Paints</option>
            <option value="Bolts">Bolts</option>
            <option value="Tools">Tools</option>
        </select>
	</p>
	
	<input type="submit" name="update" value= "Update" class="button">
	<button type="button" onclick="location.href='inventory.php'">Back</button>
</form>

</body>
</html>
