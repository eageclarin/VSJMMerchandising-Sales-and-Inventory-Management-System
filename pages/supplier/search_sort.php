<?php
    error_reporting(0);
    include_once '../../env/conn.php';

    // SQL QUERIES ==========================================================================================
    // FROM SEARCH TAB
    if (isset($_POST['search'])) {
        $Name = $_POST['search'];
        if ($Name!="") {    
            $sql = "SELECT * FROM supplier WHERE supplier_Name LIKE '%$Name%' OR supplier_ContactPerson LIKE '%$Name%' OR supplier_Address LIKE '%$Name%' OR supplier_Status LIKE '%$Name%'; ";
        } else {
            $sql = "SELECT * FROM supplier;"; 
        }
	// FROM SORT
    } else if (isset($_POST['selected'])) {
        $k = $_POST['selected'];
        $_SESSION['option'] = $_POST['selected'];
        if ($k == "SupplierName") {
            $sql = "SELECT * FROM supplier ORDER BY supplier_Name ASC;"; 
        } else if ($k == "ContactP") {
			$sql = "SELECT * FROM supplier ORDER BY supplier_ContactPerson ASC;";
        } else if ($k == "Address") {
			$sql = "SELECT * FROM supplier ORDER BY supplier_Address ASC;";
        } else if ($k == "ID"){
            $sql = "SELECT * FROM supplier ORDER BY supplier_ID ASC;"; 
        } else {
            $sql = "SELECT * FROM supplier"; 
        }
    // DEFAULT: BY ID    
    }  else {
            $sql = "SELECT * FROM supplier ORDER BY supplier_ID;"; 
    }  
    // END OF SQL QUERIES ==========================================================================================
    
    // SHOW RESULT OF QUERY

	$resultSupplier = mysqli_query($conn,$sql);
	if(mysqli_num_rows($resultSupplier) > 0){
		echo "<table class='table'>
		<tr>
			<th>Supplier ID</th>
			<th>Supplier Name</th>
      		<th>Supplier Contact Person</th>
			<th>Supplier Number</th>
			<th>Supplier Address</th>
			<th>Status</th>
		</tr>
		";
		while($row = mysqli_fetch_assoc($resultSupplier)){
			if($row['supplier_Status']==0){
				$supplier_Status="Inactive";
			}
			else{
				$supplier_Status="Active";
			}
			echo "
			<tr>
				<td>".$row['supplier_ID']."</td>
				<td>".$row['supplier_Name']."</td>
        		<td>".$row['supplier_ContactPerson']."</td>
				<td>".$row['supplier_ContactNum']."</td>
        		<td>".$row['supplier_Address']."</td>
        		<td>".$supplier_Status."</td>
				<td><button onclick=\"location.href='editsupplier.php?supplier_ID=".$row['supplier_ID']."'\">Edit</button></td>
				<td><button onclick=\"location.href='deletesupplier.php?supplier_ID=".$row['supplier_ID']."'\">Change Status</button></td>
				<!-- <td> <button> <a onclick='return checkdelete()' href='deletesupplier.php?supplier_ID=".$row['supplier_ID']."'> Delete</button></a></td> -->
				<td> <button onclick=\"location.href='suppliertable.php?supplier_ID=".$row['supplier_ID']."'\">More Information</button></td></tr>";
		}
		echo "</table>";
	}
	else echo "No results";
?>

               


  
