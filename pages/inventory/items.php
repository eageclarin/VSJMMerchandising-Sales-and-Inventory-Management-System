<?php
include_once '../../env/conn.php';
?>

<!DOCTYPE html>
<html>
<head>
<script src="myjs.js" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<title> List of Items </title>
</head>
<body>
<?php include 'navbar.php';?>
    <div id="content">
<h1> List of Items </h1>
<?php

$sql = "SELECT * FROM item;";                                    
$result = mysqli_query($conn,$sql);
$resultCheck = mysqli_num_rows($result);
       
echo "<div class='table-wrapper'><table class='table table-hover'> 
        <thead> 
        <tr>
            <th> ID </th>
            <th> Item </th>
            <th> Unit </th>
            <th> Brand </th>
            <th> Category </th>
            <th> </th>
        </tr>
        </thead>
        <tbody>";

if ($resultCheck>0){
    while ($row = mysqli_fetch_assoc($result)) {
            echo "
			<tr>
            <td>" .$row['item_ID']. "</td>  
            <td>". $row['item_Name']. "</td>  
            <td>" .$row['item_unit']. "</td>  
            <td>" .$row['item_Brand'] . "</td> 
            <td>" .$row['item_Category'] . "</td> 
            <td><button type='button' class='btn editbtn' onclick=\"location.href='edititems.php?item_ID=".$row['item_ID']." ' \"><i class='fas fa-edit'></i></button>
            <button class='btn btn-link' onclick=\"location.href='../supplier/supplieritem.php?item_Name=".$row['item_Name']." ' \">Suppliers</button></td>
			</tr>
			";
    }
}       
mysqli_close($conn);
echo "</tbody></table></div>";

?>
<button class='btn btn-primary p-2 mt-3' type="button" onclick="location.href='./additem.php'">Add Item </button> 
</div>
</body>
</html>