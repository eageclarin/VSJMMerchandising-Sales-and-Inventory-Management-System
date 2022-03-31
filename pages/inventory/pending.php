<?php
include_once '../../env/conn.php';

// IF ORDER BUTTON IS SET FOR EACH TRANSACTION
if(isset($_POST['order'])){ 
  echo "You're about to order... //insert modal form here";
  $transID=$_POST['transaction'];
  //GET ALL ITEMS IN GIVEN TRANSACTION ID
  $getitems = "SELECT * FROM transaction_Items WHERE transaction_ID = '$transID';";
  $resultItems = mysqli_query($conn,$getitems);
  $resultCheckItems = mysqli_num_rows($resultItems);
        if ($resultCheckItems>0){
          while ($rowitems = mysqli_fetch_assoc($resultItems)) {
            $transItem = $rowitems["item_ID"];
            $transQuant = $rowitems["transactionItems_Quantity"];
            $CostTrans =$rowitems["transactionItems_CostPrice"];
            //UPDATING ITEMS IN INVENTORY
            $inventoryItem = "SELECT * FROM inventory WHERE item_ID = '$transItem'";
            $resultInventory = mysqli_query($conn,$inventoryItem);
            $resultCheckInventory = mysqli_num_rows($resultInventory);
            if($resultCheckInventory>0){
              while ($rowinventory = mysqli_fetch_assoc($resultInventory)) {
                // SETTING OF NEW PRICE BASED ON NEW COSTPRICE
                $currentPrice = $rowinventory['item_RetailPrice'];
                $newPrice = $CostTrans+($CostTrans*$rowinventory['Item_markup']/100);
                if($currentPrice> $newPrice){
                  $newPrice = $currentPrice;
                } 
              } // END OF SETTING NEW PRICE
              // IF ITEM IS ALREADY IN INVENTORY
              $updateStatus = "UPDATE inventory SET in_pending=0, item_Stock = item_Stock + '$transQuant', item_RetailPrice = '$newPrice'   WHERE item_ID = '$transItem';";
               $sqlUpdate = mysqli_query($conn,$updateStatus);
               if ($sqlUpdate) {
                 echo "Update in inventory success <br/>";
               } else {
                 echo mysqli_error($conn);
               } //END OF ITEM IS ALREADY IN INVENTORY

            } else {  //ELSE, INSERT NEW ITEM IN INVENTORY
              $markup = 1.0; //to be edited, insert modal here for item cetegory and markup
              $newPrice = $CostTrans*$markup;
              $insert = "INSERT INTO inventory(branch_ID, item_ID, item_Stock, item_RetailPrice, item_category, Item_markup, in_pending)
        VALUES (1, '$transItem', '$transQuant', '$newPrice' , 'dummy', $markup, 0);";
               $sqlInsert = mysqli_query($conn, $insert);
            } //END OF INSERTING NEW ITEM  
          } 
        }//END OF UPDATING ITEMS IN INVENTORY
        //UPDATE TRANSACTION_STATUS TO 1 (ORDERED ALREADY)
        $updateStatusTrans = "UPDATE supplier_transactions SET transaction_Status=1 WHERE transaction_ID = '$transID';";
        $sqlUpdateTrans = mysqli_query($conn,$updateStatusTrans);
        if ($sqlUpdateTrans) {
          echo "Update in supplier transactions Success </br>";
        } else {
          echo mysqli_error($conn);
        } //END OF UPDATING TRANSACTION STATUS

}// END OF ORDER BUTTON SET

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
    <a class="nav-link " aria-current="page" href="inventory.php">Inventory</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="pending.php">Pending</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " href="items.php">Items</a>
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
        echo "Total: ".$total. "<br/>";?>

      <!--ORDER BUTTON-->
      <form action="pending.php" class="mb-1" method="post">
      <input type=hidden name=transaction value=<?php echo $ID?>>
        <button class="btn-primary" name="order" type="submit">Order</button>
      </form>

        <?php

        
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