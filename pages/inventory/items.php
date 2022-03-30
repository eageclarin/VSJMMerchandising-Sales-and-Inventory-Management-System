<?php
include_once 'conn.php';
?>

<!DOCTYPE html>
<html>
<head>
<script src="myjs.js" type="text/javascript"></script>
<title> List of Items </title>
</head>
<body>
<h1> List of Items </h1>
<?php
//TEST CODE ONLY
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