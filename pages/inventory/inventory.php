<?php
include_once '../../env/conn.php';
?>

<!DOCTYPE html>
<html>
<head>
<title> Inventory </title>
</head>
<body>
<h1> Inventory </h1>
<?php
//TEST CODE ONLY
$sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID);";                                    
$result = mysqli_query($conn,$sql);
$resultCheck = mysqli_num_rows($result);
       
echo "<table> 
        <tr>
            <th> ID </th>
            <th> Item </th>
            <th> Unit </th>
            <th> Brand </th>
            <th> Retail Price </th>
            <th> Markup </th>
            <th> Stock </th>
            <th> Category </th>
        </tr>";

if ($resultCheck>0){
    while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" .$row['item_ID']. "</td>";  
            echo "<td>". $row['item_Name']. "</td>";  
            echo "<td>" .$row['item_unit']. "</td>";  
            echo "<td>" . $row['item_Brand'] . "</td>";  
            echo "<td>" . $row['item_RetailPrice']. "</td>"; 
            echo "<td>" .$row['Item_markup']. "</td>";
            echo "<td>" .$row['item_Stock']. "</td>";   
            echo "<td>" .$row['item_category']. "</td>";  
              
            echo "</tr>";   
    }
}       
mysqli_close($conn);
echo "</table>";

?>
</body>
</html>