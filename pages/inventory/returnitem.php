<?php
include_once '../../env/conn.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title> Return Items </title>
	<script src="myjs.js" type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="finalstyle.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

</head>
<body>
<main class="h-100">
<?php include 'navbar.php'; ?>
<?php
include_once '../../env/conn.php';

error_reporting(0);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$db = mysqli_connect("localhost","root","","VSJM");

if(!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['submit'])){
	$item_ID = $_POST['item_Name'];
	$item_ReturnedQuan = $_POST['item_ReturnedQuan'];
	$item_Reason = $_POST['item_Reason'];
	$itemReturn_Date = $_POST['itemReturn_Date'];
	$insert = mysqli_query($db,"INSERT INTO return_item ". "(item_ID, item_ReturnedQuan, item_Reason, itemReturn_Date) ". "
			  VALUES('$item_ID', '$item_ReturnedQuan', '$item_Reason', '$itemReturn_Date')");
			  
	if(!$insert)
    {
        echo mysqli_error();
    }
    else
    {
        echo "";
    }

}
?>
<div class="container-fluid bg-light p-5">
	<div class="row">
		<div class="col-7" style="overflow-y: scroll; height: 600px;">
			<?php
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "VSJM";
			$conn = mysqli_connect($server, $user, $pass, $db);
				
			if(!$conn) die(mysqli_error($conn));
			$sql = "SELECT * FROM item INNER JOIN return_item ON(item.item_ID = return_item.item_ID);";                                    
			$result = mysqli_query($conn,$sql);
			$resultCheck = mysqli_num_rows($result);			
				
			echo "<table> 
					<tr>
						<th> Return ID </th>
						<th> Item ID </th>
						<th> Item Name </th>
						<th> Returned Quantity </th>
						<th> Reason </th>
						<th> Date of Return </th>
					</tr>";

			if ($resultCheck>0){
				while ($row = mysqli_fetch_assoc($result)) {
						echo "
						<tr>
						<td>" .$row['return_ID']. "</td>  
						<td>" .$row['item_ID']. "</td>
						<td>" .$row['item_Name']. "</td>
						<td>" .$row['item_ReturnedQuan']. "</td>  
						<td>" .$row['item_Reason'] . "</td> 
						<td>" .$row['itemReturn_Date'] . "</td> 
						</tr>
						";
				}
			}       
			mysqli_close($conn);
			echo "</table>";
			?>
		</div>
		
	
	
	<div class="col bg-white border shadow-sm p-5" style="border-radius: 15px">
	<div class="fs-3 fw-bold text-center"> RETURN ITEM </div>
		<hr>
		<form action = "./returnitem.php" method="post" id="form">
			<div class="form-group row"> 
				<label for="item_Name" class="col-5 col-form-label fw-bold">Item ID:</label>
				<?php
						$server = "localhost:3306";
								$user = "root";
								$pass = "";
								$db = "VSJM";
								$conn = mysqli_connect($server, $user, $pass, $db);
								if(!$conn) die(mysqli_error($conn));
						$query = "SELECT * from item";
						$result = mysqli_query($conn,$query);
									if(mysqli_num_rows($result) > 0){
									?>
										<select name="item_Name" id="item" class="col-sm-10 form-select w-50" required>
									<?php
											while($row = mysqli_fetch_assoc($result)){
												echo "<option value='".$row['item_ID']."'>"
												.$row['item_ID']."</option>";
											}
											echo "</select><br>";
										}
								mysqli_close($conn);
					?>
			</div>
			<div class="form-group row mt-2">
				<label for="item_ReturnedQuan" class="col-5 col-form-label fw-bold">Returned Qty:</label>
				<input type = "text" name = "item_ReturnedQuan" id="item_ReturnedQuan" class="col-sm-10 form-control w-50"  required>
			</div>
			<div class="form-group row mt-2">
					<label for="item_TReason" class="col-5 col-form-label fw-bold">Reason:</label>
				<select name="item_TReason" id="item_TReason" class="col-sm-10 form-select w-50" onchange="Reason();" required >
				
				<option value="" id="reason">--Select Reason--</option>
				<option value="Excess quantity" >Excess quantity</option>
				<option value="Item has a defect">Item has a defect</option>
				<option value="Wrong item/s bought"> Wrong item/s bought </option>
				<option value="Wrong size bought"> Wrong size bougth </option>
				<option value=""> Others </option>
				</select>
			</div>
			<div class="form-group row mt-2">
				<label for="item_Reason" class="col-5 col-form-label fw-bold">Other Reason:</label>
				<input type="text" name= "item_Reason" id="item_Reason"  class="col-sm-10 form-control w-50"  required>
			</div>
			
			<div class="form-group row mt-2">
				<label for="itemReturn_Date" class="col-5 col-form-label fw-bold">Date of Return:</label>
				
					 <input type="datetime-local" name="itemReturn_Date" id="itemReturn_Date" class="col-sm-10 form-control w-50" required>
			</div>
			
			<div class="form-group row">
				<div class="col">
					<input type="submit" name="submit" value="submit" class="btn btn-lg btn-success mt-3 w-100">
				</div>
			</div>
		</form>
		</div>
	</div>
</div>
</main>
<script type="text/javascript">
function Reason() {
	var d = document.getElementById("item_TReason");
	var displaytext=d.options[d.selectedIndex].text;
	document.getElementById("item_Reason").value=displaytext;
}  

const now = new Date();
now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
document.getElementById('itemReturn_Date').value = now.toISOString().slice(0, 16);

</script>

</body>
</html>
