<!DOCTYPE html>
<html>
<head>
	<title> Return Items </title>
	<script src="myjs.js" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

</head>
<body>
<?php //include 'navbar.html'; ?>
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
	$item_Name = $_POST['item_Name'];
	$item_ReturnedStock = $_POST['item_ReturnedStock'];
	$item_Reason = $_POST['item_Reason'];
	
	$insert = mysqli_query($db,"INSERT INTO return_item ". "(item_ID, item_Name, item_ReturnedStock, item_Reason) ". "
			  VALUES('$item_ID', '$item_Name', '$item_ReturnedStock', '$item_Reason')");
			  
	if(!$insert)
    {
        echo mysqli_error();
    }
    else
    {
        echo "Records added successfully.";
    }

}
?>
<div class= "returnform">
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
			Item Name:
			<input type = "text" name = "item_Name" id="item_Name">
		</p>
		<p>
			Returned Item Quantity:
			<input type = "text" name = "item_ReturnedStock" id="item_ReturnedStock">
		</p>
		<p>
			Reason:
			<select name="item_Reason" id="item_Reason" style="height:30px;">
            <option value="Excess" >Excess quantity</option>
            <option value="Defect">Item has a defect</option>
            <option value="Wrong_item"> Wrong item/s bought </option>
        </select>
		</p>
		<input type="submit" name="submit" value="submit">
		<button type="button" onclick="location.href='transactions.php'">Go back </button>
	</form>
</div>

<div class = "returned_table">
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
            <th> Item  </th>
            <th> Returned Quantity </th>
            <th> Reason </th>
        </tr>";

if ($resultCheck>0){
    while ($row = mysqli_fetch_assoc($result)) {
            echo "
			<tr>
            <td>" .$row['item_ID']. "</td>  
            <td>". $row['item_Name']. "</td>  
            <td>" .$row['item_ReturnedStock']. "</td>  
            <td>" .$row['item_Reason'] . "</td> 
			</tr>
			";
    }
}       
mysqli_close($conn);
echo "</table>";

?>
</div>

</body>
</html>