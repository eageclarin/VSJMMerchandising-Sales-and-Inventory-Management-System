<?php
include_once '../../env/conn.php';
?>

<!DOCTYPE html>
<html>
<head>
<script src="myjs.js" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
 
<title> List of Items </title>
</head>
<body>
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" aria-current="page" href="inventory.php">Inventory</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " href="pending.php">Pending</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="items.php">Items</a>
  </li>
  <li class="nav-item active">
    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Others</a>
  </li>
</ul>
<h1> List of Items </h1>
<?php

$sql = "SELECT * FROM item;";                                    
$result = mysqli_query($conn,$sql);
$resultCheck = mysqli_num_rows($result);
       
echo "<table> 
        <tr>
            <th> ID </th>
            <th> Item </th>
            <th> Unit </th>
            <th> Brand </th>
        </tr>";

if ($resultCheck>0){
    while ($row = mysqli_fetch_assoc($result)) {
            echo "
			<tr>
            <td>" .$row['item_ID']. "</td>  
            <td>". $row['item_Name']. "</td>  
            <td>" .$row['item_unit']. "</td>  
            <td>" .$row['item_Brand'] . "</td> 
            <td><button class='table-see' onclick=\"location.href='edititems.php?item_ID=".$row['item_ID']." ' \">Edit</button></td>
			</tr>
			";
    }
}       
mysqli_close($conn);
echo "</table>";

?>
<button type="button" onclick="location.href='./additem.php'">Add Item </button> 
</body>
</html>