<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="./css/styles.css">
<script src="myjs.js" type="text/javascript"></script>
<title>Hardware Suppliers</title>
</head>
<body>
<?php
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "VSJM";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	
?>

<!-- ------------------------ w/o search bar --------------------------- -->


<h3> Suppliers</h3>
<?php
	$querySupplier = "select * from supplier";
	$resultSupplier = mysqli_query($conn,$querySupplier);
	if(mysqli_num_rows($resultSupplier) > 0){
		echo "<table>
		<tr>
			<th>Supplier ID</th>
			<th>Supplier Name</th>
            <th>Supplier Contact Person</th>
			<th>Supplier Number</th>
			<th>Supplier Address</th>
		</tr>
		";
		while($row = mysqli_fetch_assoc($resultSupplier)){
			echo "
			<tr>
				<td>".$row['supplier_ID']."</td>
				<td>".$row['supplier_Name']."</td>
                <td>".$row['supplier_ContactPerson']."</td>
				<td>".$row['supplier_ContactNum']."</td>
                <td>".$row['supplier_Address']."</td>
				<td><button onclick=\"location.href='editsupplier.php?supplier_ID=".$row['supplier_ID']."'\">Edit</button></td>
				<td> <button> <a onclick='return checkdelete()' href='deletesupplier.php?supplier_ID=".$row['supplier_ID']."'> Delete</button></a></td>
				<td> <button onclick=\"location.href='suppliertable.php?supplier_ID=".$row['supplier_ID']."'\">More Information</button></td></tr>";
		}
		echo "</table>";
	}
	else echo "No results";
?>
<button onclick="location.href='./addsupplier.php'">Add new supplier</button>
<?php mysqli_close($conn); ?>

</div>
</body>
</html>