<?php
include_once '../../env/conn.php';

?>

<!DOCTYPE html>
<html>
<head>
<title> Pending </title>
<!-- ajax -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- jquery -->
     <!--   <script src="jquery-3.5.1.min.js"></script>-->
<script type="text/javascript" src="inventory.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
       
</head>
<body >
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link " aria-current="page" href="inventory.php">Active</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="pending.php">Pending</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " href="additem.php">Items</a>
  </li>
  <li class="nav-item active">
    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Others</a>
  </li>
</ul>
<h1> Pending </h1>

<?php

  $sql = "SELECT * FROM supplier_transactions WHERE transaction_Status =0 ;";   
  $result = mysqli_query($conn,$sql);
  $resultCheck = mysqli_num_rows($result);
        
  if ($resultCheck>0){
      while ($row = mysqli_fetch_assoc($result)) {
        $ID = $row['transaction_ID'];  
        $supplier = $row['supplier_ID'];
        $transacDate = $row['transaction_Date'];   
        $total = $row['transaction_TotalPrice'];

        echo "<h4> Transaction ID: ".$ID. "</h4>";
        echo "Supplier ID: ".$supplier. "<br/>";
        echo "Date: ".$transacDate. "<br/>";
        echo "Total: ".$total. "<br/>";
        echo "<table class='table'> 
                <tr> 
                    <th> ID </th>
                    <th> Item </th>
                    <th> Brand </th>
                    <th> unit </th>
                    <th> Quantity </th>
                    <th> Unit Price </th>
                    <th> Total Price </th>
                </tr>";

        $sql1 = "SELECT * FROM transaction_Items INNER JOIN item ON (transaction_Items.item_ID = item.item_ID) WHERE transaction_ID = '$ID' ;";   
        $result1 = mysqli_query($conn,$sql1);
        $resultCheck1 = mysqli_num_rows($result1);
        
        if ($resultCheck1>0){
          while ($row1 = mysqli_fetch_assoc($result1)) {
            echo "<tr>"; 
            echo "<td>" .$row1['item_ID']. "</td>";  
            echo "<td>". $row1['item_Name']. "</td>";  
            echo "<td>" .$row1['item_Brand']. "</td>";  
            echo "<td>" . $row1['item_unit'] . "</td>";  
            echo "<td>" . $row1['transactionItems_Quantity']. "</td>"; 
            echo "<td>" .$row1['transactionItems_CostPrice']. "</td>";
            echo "<td>" .$row1['transactionItems_TotalPrice']. "</td>";       
            echo "</tr>"; 

          }
        } 

        echo "</table>";


      }
  } 
?>

</body>
</html>