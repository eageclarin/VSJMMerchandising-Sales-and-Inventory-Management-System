<!DOCTYPE html>
<html>
<head>
	<title> Return Items </title>
	<script src="myjs.js" type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="returnstyle.css">


</head>
<body>

<?php include 'navbar.html'; ?>
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
	$item_Name = $_POST['item_Name'];
	$item_ReturnedQuan = $_POST['item_ReturnedQuan'];
	$item_Reason = $_POST['item_Reason'];
	$itemReturn_Date = $_POST['itemReturn_Date'];
	$insert = mysqli_query($db,"INSERT INTO return_item ". "(item_Name, item_ReturnedQuan, item_Reason, itemReturn_Date) ". "
			  VALUES('$item_Name', '$item_ReturnedQuan', '$item_Reason', '$itemReturn_Date')");
			  
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
	<div class = "table">
	<h2>  List of Returned Items </h2>
	<h3> Number of returned items: <?php $server = "localhost:3306";
		$user = "root";
		$pass = "";
		$db = "VSJM";
		$conn = mysqli_connect($server, $user, $pass, $db);
			
		if(!$conn) die(mysqli_error($conn)); 
		$query = "SELECT SUM(item_ReturnedQuan) FROM return_item;";
		$result = mysqli_query($conn, 'SELECT SUM(item_ReturnedQuan) AS item_ReturnedQuan_sum FROM return_item'); 
		$row = mysqli_fetch_assoc($result); 
		$sum = $row['item_ReturnedQuan_sum'];
		echo $sum;
		?></h3>
		 
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
					<th> Return ID </th>
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
	
	<div class= "form">
		<h2> Return Forms </h2>
		<form action = "./returnitem.php" method="post" id="form">
			<div class ="input">
			<p>
				Item Name: 
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
										echo "<select name='item_Name' >";
											while($row = mysqli_fetch_assoc($result)){
												echo "<option value='".$row['item_Name']."'>"
												.$row['item_Name']."</option>";
											}
											echo "</select><br>";
										}
								mysqli_close($conn);
					?>
			</p>
			</div>
			<div class = "input">
			<p>
				Returned Item Quantity:
				<input type = "text" name = "item_ReturnedQuan" id="item_ReturnedQuan" required>
			</p>
			</div>
			<div class = "input">
			<p>
				Reason:
				<select name="item_TReason" id="item_TReason" style="height:30px;" onchange="mhie();" required >
				
				<option value="" id="reason">--Select Reason--</option>
				<option value="Excess quantity" >Excess quantity</option>
				<option value="Item has a defect">Item has a defect</option>
				<option value="Wrong item/s bought"> Wrong item/s bought </option>
				<option value="Wrong size bought"> Wrong size bougth </option>
				<option value=""> Others </option>
				</select>
				<p>
				Type reasons of return:
				<input type="text" name= "item_Reason" id="item_Reason"  />
				</p>
			</p>
			</div>
			<div class = "input">
			<p>
				Date of Return:
				<input type="datetime-local" name="itemReturn_Date" id="itemReturn_Date" required>
			</p>
			</div>
			<div class = "input">
			<input type="submit" name="submit" value="submit">
			</div>
		</form>
	</div>
	
</div>
<script type="text/javascript">
function mhie() {
	var d = document.getElementById("item_TReason");
	var displaytext=d.options[d.selectedIndex].text;
	document.getElementById("item_Reason").value=displaytext;
}  
</script>
</body>
</html>
