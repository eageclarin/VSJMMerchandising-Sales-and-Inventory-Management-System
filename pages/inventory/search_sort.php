<?php
    include_once '../../env/conn.php';

    if (isset($_POST['search'])) {
        $Name = $_POST['search'];
        if ($Name!="") {
             
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) WHERE item_Name LIKE '%$Name%'";
        } else {
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID);"; 
        }
    } else if (isset($_POST['selected'])) {
        $k = $_POST['selected'];
        $_SESSION['option'] = $_POST['selected'];
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
        
    } else {
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID);"; 
        }
                                   
$result = mysqli_query($conn,$sql);
$resultCheck = mysqli_num_rows($result);
       
echo "<table class='table'> 
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
        if ($row['item_Stock']<=5){
            echo "<tr class='table-danger'>";
        } else{
            echo "<tr>";
        }   
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