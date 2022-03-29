<?php
include_once '../../env/conn.php';

//$_POST['selected'] = "ID";
?>

<!DOCTYPE html>
<html>
<head>
<title> Inventory </title>
<!-- ajax -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- jquery -->
     <!--   <script src="jquery-3.5.1.min.js"></script>-->
<script type="text/javascript" src="inventory.js"></script> 
</head>
<body id="display">
<h1> Inventory </h1>


    <label for="sort">Sort by:</label>
    <select name="sort" id="sort">
    <option value="ID" >ID</option>
    <option value="Category">Category</option>
    <option value="PriceAsc"> <span>&#8593;</span>Price</option>
    <option value="PriceDesc"> <span>&#8595;</span>Price</option>
    <option value="Stocks">Stocks</option>
    <option value="Salability">Salability</option>
    </select>

    <div id="display"></div>


<?php
    //show list of items sorted by some option
    //if ($_POST['selected']) {
        $k = $_POST['selected'];
        echo $k;
        if ($k == "PriceAsc") {
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) ORDER BY item_RetailPrice ASC;"; 
        } else if ($k == "PriceDesc") {
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) ORDER BY item_RetailPrice DESC;"; 
        } else if ($k == "Stocks") {
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) ORDER BY item_Stock ASC;"; 
        } else if ($k == "Category") {
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) ORDER BY  item_category,item_Name ASC;"; 
        } else {
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID);"; 
        }
        
    //}
                                   
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