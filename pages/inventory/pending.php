<?php

include_once '../../env/conn.php';
$n=0;
$k=0;

//ORDER BUTTON IN PENDING ORDERS
if (isset($_POST['order'])) {
  $transID=$_POST['transaction'];
  //UPDATE TRANSACTION_STATUS TO 1 (ORDERED ALREADY)
  $updateStatusTrans = "UPDATE supplier_transactions SET transaction_Status=1 WHERE transaction_ID = '$transID';";
  $sqlUpdateTrans = mysqli_query($conn,$updateStatusTrans);
  if ($sqlUpdateTrans) {
    //echo "Update in supplier transactions Success </br>";
  } else {
    echo mysqli_error($conn);
  } //END OF UPDATING TRANSACTION STATUS
}

//REMOVE BUTTON IN PENDING ORDERS
if (isset($_POST['delete'])) {
  $deleteItemID=$_POST['itemID'];
  $deleteitemTrans = $_POST['transID'];
  //DELETE ITEM FROM PENDING TRANSACTION
  $deleteItem = "DELETE FROM transaction_Items WHERE item_ID = '$deleteItemID' AND transaction_ID = '$deleteitemTrans';";
  $sqldeleteItem = mysqli_query($conn,$deleteItem);
  //SET ITEM TO BE NOT IN PENDING ORDERS
  $deleteItem = "UPDATE inventory SET in_pending=0 WHERE item_ID='$deleteItemID';";
  $sqldeleteItem = mysqli_query($conn,$deleteItem);
  if ($sqldeleteItem) {
    //echo "Update in supplier transactions Success </br>";
  } else {
    echo mysqli_error($conn);
  } 
}

//EDIT BUTTON IN PENDING ORDERS
if (isset($_POST['edit'])) {
  $quantity = $_POST['quant'];
  $updateItemID=$_POST['itemID'];
  $updateitemTrans = $_POST['transID'];
  //EDIT ITEM QUANTITY
  $updateItem = "UPDATE transaction_Items SET transactionItems_Quantity = '$quantity' WHERE item_ID = '$updateItemID' AND transaction_ID = '$updateitemTrans';";
  $sqlupdateItem = mysqli_query($conn,$updateItem);
  if ($sqlupdateItem) {
    //echo "Update in supplier transactions Success </br>";
  } else {
    echo mysqli_error($conn);
  } 
}

//EDIT BUTTON IN TO BE DELIVERED
if (isset($_POST['editDeli'])) {
    $deliQuantity = $_POST['deliQuant'];
    $deliUpdateItemID=$_POST['deliItemID'];
    $deliUpdateitemTrans = $_POST['deliTransID'];
    $deliCost = $_POST['deliCost'];
    $total = $deliQuantity*$deliCost;
    //UPDATE QUANTITY, COST PRICE AND TOTAL
    $updateItem = "UPDATE transaction_Items SET transactionItems_Quantity = '$deliQuantity', transactionItems_CostPrice = '$deliCost', transactionItems_TotalPrice = '$total'  WHERE item_ID = '$deliUpdateItemID' AND transaction_ID = '$deliUpdateitemTrans';";
    $sqlupdateItem = mysqli_query($conn,$updateItem);
    if ($sqlupdateItem) {
      //echo "Update in supplier transactions Success </br>";
    } else {
      echo mysqli_error($conn);
    } 
}

// IF delivered BUTTON IS SET FOR EACH TRANSACTION
if(isset($_POST['deliver'])){ 
  $transID=$_POST['transaction'];
  
  //GET ALL ITEMS IN GIVEN TRANSACTION ID
  $getitems = "SELECT * FROM transaction_Items WHERE transaction_ID = '$transID';";
  $resultItems = mysqli_query($conn,$getitems);
  $resultCheckItems = mysqli_num_rows($resultItems);
  if ($resultCheckItems>0){
    while ($rowitems = mysqli_fetch_assoc($resultItems)) {
      $transItem = $rowitems["item_ID"];

      //CHECKLIST OF DELIVERED ITEMS 
      if(!empty($_POST['check_list'])){          
        if (!in_array($transItem, $_POST['check_list'])) {
          //echo $transItem." not checked";
          //REMOVE UNCHECKED ITEM FROM TRANSACTION
          $unchecked = "DELETE FROM transaction_Items WHERE item_ID='$transItem' AND transaction_ID = '$transID';";
          $sqlunchecked = mysqli_query($conn,$unchecked);
          //SET ITEM TO BE NOT IN PENDING
          $unchecked = "UPDATE inventory SET in_pending=0 WHERE item_ID='$transItem';";
          $sqlunchecked = mysqli_query($conn,$unchecked);
          break;
        }
      } // END OF CHECKLIST
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
        $updateStatus = "UPDATE inventory SET in_pending=0, inventoryItem_Status=1, item_Stock = item_Stock + '$transQuant', item_RetailPrice = '$newPrice'   WHERE item_ID = '$transItem';";
        $sqlUpdate = mysqli_query($conn,$updateStatus);
        if ($sqlUpdate) {
          //echo "Update in inventory success <br/>";
        } else {
          echo mysqli_error($conn);
        } //END OF ITEM IS ALREADY IN INVENTORY

      } else {  //ELSE, INSERT NEW ITEM IN INVENTORY
        $markup = $_SESSION['addInventory_markup']; //to be edited, insert modal here for item cetegory and markup
        $newPrice = $CostTrans*$markup;
        $insert = "INSERT INTO inventory(branch_ID, item_ID, item_Stock, item_RetailPrice, item_category, Item_markup, in_pending)
        VALUES (1, '$transItem', '$transQuant', '$newPrice' , 'dummy', $markup, 0);";
        $sqlInsert = mysqli_query($conn, $insert);
      } //END OF INSERTING NEW ITEM  
    } //END OF RESULTITEMS WHILE LOOP
  }//END OF GETTING ALL ITEMS
        
  //UPDATE TRANSACTION_STATUS TO 2 (DELIVERED ALREADY)
  $updateStatusTrans = "UPDATE supplier_transactions SET transaction_Status=2 WHERE transaction_ID = '$transID';";
  $sqlUpdateTrans = mysqli_query($conn,$updateStatusTrans);
  if ($sqlUpdateTrans) {
    //echo "Update in supplier transactions Success </br>";  
  } else {
    echo mysqli_error($conn);
  } //END OF UPDATING TRANSACTION STATUS
}// END OF DELIVER BUTTON SET
?>

<!DOCTYPE html>
<html>
<head>
<title> Pending </title>
<link rel="stylesheet" href="./style.css?ts=<?=time()?>">
  <script type="text/javascript" src="inventory.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <!-- CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  
	<!-- JQUERY/BOOTSTRAP -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 

  <style>
    .panel-heading .colpsible-panel:after {
        
        font-family: 'Glyphicons Halflings'; 
        content: "\e114";    
        float: right;        
        color: #408080;         
    }
    .panel-heading .colpsible-panel.collapsed:after {
        content: "\e080"; 
    }
  </style>
</head>
<body >
    <main >
    <?php include 'navbar.php'; ?>
        
    <div class="container-fluid bg-light p-5">
    <h1> Pending Orders</h1>

    <!-- TO BE PURCHASED CARD -->
    <div class="card" style="width: 49%; min-height:80%; float:left;">
      <div class="card-header bg-dark text-white">
        <h3 class="card-title">To be Purchased</h3>
      </div>
      <div class="card-body">
        <p class="card-text">Items that are not yet ordered</p>
        <?php //SHOW PENDING TRANSACTIONS
          $sql = "SELECT * FROM supplier_transactions WHERE transaction_Status =0 ;";   
          $result = mysqli_query($conn,$sql);
          $resultCheck = mysqli_num_rows($result); ?>

          <!-- PANELS -->
          <div class = "container" style="width: 100%;">
            <div class="panel-group" id="accordion">
              <?php 
                if ($resultCheck>0){
                  while ($row = mysqli_fetch_assoc($result)) {
                    $n++;
                    $ID = $row['transaction_ID'];  
                    $supplier = $row['supplier_ID'];
                    $transacDate = $row['transaction_Date'];   
                    $total = $row['transaction_TotalPrice'];                
                    echo "<div class='panel panel-info'>"; ?>
                    <!-- PANEL HEADING -->
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a class="colpsible-panel" data-toggle="collapse" data-parent="#accordion"  href="#collapse<?php echo $n?>">
                          <?php echo "<h4> Transaction ID: ".$ID. "</h4>"; ?> 
                        </a>
                        <!--ORDER BUTTON-->
                        <form action="pending.php" class="mb-1" method="post">
                          <input type=hidden name=transaction value=<?php echo $ID?>>
                          <button class="btn btn-primary" name="order" type="submit" style="float:left;">Order</button>
                        <!-- EXPORT BUTTON -->
                        </form>
                        <form action="export.php" method="post">
                          <input type=hidden name=ExportTransactionID value=<?php echo $ID?>>
                          <input type=hidden name=ExportTransactionSupp value=<?php echo $supplier?>>
                          <button class="btn btn-success" name="export" type="submit" style="float:left;">Export</button>
                        </form>
                      </h4>
                      <?php 
                      echo "Supplier ID: ".$supplier. "<br/>";
                      echo "Date: ".$transacDate. "<br/>";
                      echo "Total: ".$total. "<br/>";?>
                    </div> <!-- END OF PANEL HEADING -->
                    <!-- PANEL COLLAPSE -->
                    <div id="collapse<?php echo $n?>" class="panel-collapse collapse">
                      <div class="panel-body"> <!-- PANEL BODY -->
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
                                    <th> </th>
                                  </tr>";

                          //SHOW ITEMS IN THE TRANSACTION
                          $sql1 = "SELECT * FROM transaction_Items INNER JOIN item ON (transaction_Items.item_ID = item.item_ID) WHERE transaction_ID = '$ID' ;";   
                          $result1 = mysqli_query($conn,$sql1);
                          $resultCheck1 = mysqli_num_rows($result1);
                          
                          if ($resultCheck1>0){
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                              echo '<form action="pending.php" class="mb-1" method="post">';
                              echo "  <tr>"; 
                              echo "    <td>" .$row1['item_ID']. "</td>";  
                              echo "    <td>". $row1['item_Name']. "</td>";  
                              echo "    <td>" .$row1['item_Brand']. "</td>";  
                              echo "    <td>" . $row1['item_unit'] . "</td>";  
                              echo "    <td><input type=number name=quant value=" . $row1['transactionItems_Quantity']. " style='width:50px;'></td>"; 
                              echo "    <td>" .$row1['transactionItems_CostPrice']. "</td>";
                              echo "    <td>" .$row1['transactionItems_TotalPrice']. "</td>";   ?>
                                        <td>
                                          <!-- REMOVE AND EDIT BUTTON-->
                                          <input type=hidden name=itemID value=<?php echo $row1['item_ID']?>>
                                          <input type=hidden name=transID value=<?php echo $ID?>>
                                          <button class="btn-primary" name="delete" type="submit" >Remove</button>
                                          <button class="btn-primary" name="edit" type="submit" >Edit</button>                    
                                        </td>      
                                      </tr>
                                    </form> <?php
                            } // END OF RESULT1 WHILE LOOP
                          } //END OF RESULTCHECK1
                          echo "</table>";
                          echo "<a href='../supplier/suppliertable.php?supplier_ID=".$supplier."'>Add Items</a>";?>
              
                      </div> <!-- END OF PANEL BODY -->
                    </div> <!-- END OF PANEL COLLAPSE -->
                  </div> <!-- END OF PANEL INFO --><?php
                  } 
                }?>  
            </div> <!-- END PANEL GROUP -->
          </div><!-- END CONTAINER -->
      </div> <!-- END CARD BODY -->  
    </div> <!-- END CARD -->

    

  <!-------------DELIVERED CARD --------------->
  <div class="card" style="width: 49%; float:right;">
    <div class="card-header bg-dark text-white">
      <h3 class="card-title">To be Delivered</h3>
    </div>
    <div class="card-body">
      <p class="card-text">Pending deliveries..</p>
      <?php
        $sql = "SELECT * FROM supplier_transactions WHERE transaction_Status =1 ;";   
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result); ?>
      <div class = "container" style="width: 100%;">
        <div class="panel-group" id="accordion2">
          <?php 
            if ($resultCheck>0){
              while ($row = mysqli_fetch_assoc($result)) {
                $k++;
                $ID = $row['transaction_ID'];  
                $supplier = $row['supplier_ID'];
                $transacDate = $row['transaction_Date'];   
                $total = $row['transaction_TotalPrice'];
                echo "<div class='panel panel-info'>";?>
                <form action="pending.php" class="mb-1" method="post">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a class="colpsible-panel" data-toggle="collapse" data-parent="#accordion2"  href="#collapseDeli<?php echo $k?>">
                        <?php echo "<h4> Transaction ID: ".$ID. "</h4>"; ?> 
                      </a>
                      <!--DELIVERED BUTTON-->
                      <input type=hidden name=transaction value=<?php echo $ID?>>
                      <button class="btn btn-primary" name="deliver" type="submit" style="float:left;">Delivered</button>
                      <!--</form> EXPORT BUTTON
                      <form action="export.php" method="post">
                        <input type=hidden name=ExportTransactionID value=<?php //echo $ID?>>
                        <input type=hidden name=ExportTransactionSupp value=<?php //echo $supplier?>>
                        <button class="btn btn-success" name="export" type="submit" style="float:left;">Export</button>
                      </form>-->
                    </h4>
                    <?php 
                      echo "Supplier ID: ".$supplier. "<br/>";
                      echo "Date: ".$transacDate. "<br/>";
                      echo "Total: ".$total. "<br/>";?>
                  </div> <!-- END OF PANEL HEADING -->

                  <div id="collapseDeli<?php echo $k?>" class="panel-collapse collapse">
                    <div class="panel-body">
                      <?php
                        echo "<table class='table' style='width:100%;'> 
                                <tr> 
                                  <th> ID </th>
                                  <th> Item </th>
                                  <th> Brand </th>
                                  <th> unit </th>
                                  <th> Quantity </th>
                                  <th> Unit Price </th>
                                  <th> Total Price </th>
                                  <th> </th>
                                  <th><input type='checkbox' onClick='toggle(this)' /> Select All </th>
                                </tr>";
                        //SHOW ITEMS IN TRANSACTIONS
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
                            echo "<td><input type=number name=deliQuant value=" . $row1['transactionItems_Quantity']. " style='width:50px;'></td>"; 
                            echo "<td><input type=number name=deliCost value=" .$row1['transactionItems_CostPrice']. " style='width:50px;'></td>";
                            echo "<td>" .$row1['transactionItems_TotalPrice']. "</td>";   ?>
                            <td>
                              <input type=hidden name=deliItemID value=<?php echo $row1['item_ID']?>>
                              <input type=hidden name=deliTransID value=<?php echo $ID?>>
                              <button class="btn-primary" name="editDeli" type="submit" >Edit</button> </td><td> <!-- EDIT BUTTON -->
                              <input type="checkbox" name="check_list[]" value="<?php echo $row1['item_ID']?>"> <!-- CHECKLIST -->
                            </td>    
                          </tr><?php
                          }
                        } 
                      echo "</table>";?>
                  </div> <!-- END OF PANEL BODY -->
                    </div> <!-- END OF PANEL COLLAPSE -->
                      </form>
                  </div> <!-- END OF PANEL INFO --><?php
                  } 
                }?>  
            </div> <!-- END PANEL GROUP -->
          </div><!-- END CONTAINER -->
      </div> <!-- END CARD BODY -->  
    </div> <!-- END CARD -->
  </div> <!-- END CONTENT -->
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script language="JavaScript">
  function toggle(source) {
    checkboxes = document.getElementsByName('check_list[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }
</script>

</body>
</html>