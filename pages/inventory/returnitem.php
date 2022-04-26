<!DOCTYPE html>
<html>
<head>
	<title> Return Items </title>
	<script src="myjs.js" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="style1.css">


</head>
<body>

<?php include 'navbar.php'; ?>
<?php

//error_reporting(0);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$db = mysqli_connect("localhost","root","","VSJM");

if(!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}
if(isset($_POST['submit'])){
	$item_ID = $_POST['item_ID'];
	$item_ReturnedQuan = $_POST['item_ReturnedQuan'];
	$item_Reason = $_POST['item_Reason'];
	
	$insert = mysqli_query($db,"INSERT INTO return_item ". "(item_ID, item_ReturnedQuan, item_Reason) ". "
			  VALUES('$item_ID', '$item_ReturnedQuan', '$item_Reason')");
			  
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
<div class = "page">
	<div class = "ret2">
		<div class = "table">
		<?php
		$server = "localhost:3306";
		$user = "root";
		$pass = "";
		$db = "VSJM";
		$conn = mysqli_connect($server, $user, $pass, $db);
		
		if(!$conn) die(mysqli_error($conn));
		$sql = "SELECT * FROM return_item;";                                    
		$result = mysqli_query($conn,$sql);
		$resultCheck = mysqli_num_rows($result);
			   
		echo "<table> 
				<tr>
					<th> ID </th>
					<th> Returned Quantity </th>
					<th> Reason </th>
				</tr>";

		if ($resultCheck>0){
			while ($row = mysqli_fetch_assoc($result)) {
					echo "
					<tr>
					<td>" .$row['item_ID']. "</td>   
					<td>" .$row['item_ReturnedQuan']. "</td>  
					<td>" .$row['item_Reason'] . "</td> 
					</tr>
					";
			}
		}       
		mysqli_close($conn);
		echo "</table>";

		?>
		</div>
	</div>
	
	<div class= "ret">
		
		<form action = "./returnitem.php" method="post" id="form">
			<p>
				Item ID: 
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
										echo "<select name='item_ID'>";
											while($row = mysqli_fetch_assoc($result)){
												echo "<option value='".$row['item_ID']."'>"
												.$row['item_ID']."</option>";
											}
											echo "</select><br>";
										}
								mysqli_close($conn);
					?>
			</p>
			<p>
				Returned Item Quantity:
				<input type = "text" name = "item_ReturnedQuan" id="item_ReturnedQuan" required>
			</p>
			<p>
				Reason:
				<select name="item_Reason" id="item_Reason" style="height:30px;">
				<option value="Excess quantity" >Excess quantity</option>
				<option value="Item has a defect">Item has a defect</option>
				<option value="Wrong item/s brought"> Wrong item/s bought </option>
				
			</select>
			</p>
			
			<input type="submit" name="submit" value="submit">
			
		</form>
		
	</div>
	
	
	
</div>

</body>
</html>
