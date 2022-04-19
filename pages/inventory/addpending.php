<?php
error_reporting(0);
include_once '../../env/conn.php';
//ADDING IN PENDING ORDERS===================================================================
if ($row['in_pending']==0) {
    $_SESSION['pending_ItemID'] = $row['item_ID'];
    $pending = $_SESSION['pending_ItemID'];
    $sql1 = "SELECT * FROM supplier_item WHERE item_ID = '$pending' ORDER BY supplierItem_CostPrice ASC LIMIT 1;";   
    $result1 = mysqli_query($conn,$sql1);
    $resultCheck1 = mysqli_num_rows($result1);
        
    if ($resultCheck1>0){
        while ($row1 = mysqli_fetch_assoc($result1)) {
              $Supplier = $row1['supplier_ID'];
              $CostPrice = $row1['supplierItem_CostPrice'];
        }
    } 

    //see if item already pending in supplier transactions
    $sql2 = "SELECT * FROM supplier_Transactions WHERE supplier_ID = '$Supplier' AND transaction_Status = 0;";   
    $result2 = mysqli_query($conn,$sql2);
    $resultCheck2 = mysqli_num_rows($result2);
        
    if ($resultCheck2>0){
        while ($row2 = mysqli_fetch_assoc($result2)) {
              $Transaction = $row2['transaction_ID'];
        }
    } else {
        $timestamp = date('Y-m-d H:i:s');
        $insert = "INSERT INTO supplier_Transactions (supplier_ID, transaction_Date, transaction_Status, transaction_TotalPrice)
        VALUES ('$Supplier', '$timestamp', 0, 0 );";
        $sqlInsert = mysqli_query($conn, $insert);
        if ($sqlInsert) {
            $last_id = mysqli_insert_id($conn);
            $Transaction = $last_id;
        } else {
            echo mysqli_error($conn);
        }
    }
    
    //insert in transaction items
    $quantity = 20; //to edit
    $items_total = $CostPrice*$quantity;
    $insert = "INSERT INTO transaction_items(transaction_ID, item_ID, transactionItems_Quantity, transactionItems_CostPrice, transactionItems_TotalPrice)
        VALUES ('$Transaction', '$pending', '$quantity', '$CostPrice' , '$items_total');";
        $sqlInsert = mysqli_query($conn, $insert);
        if ($sqlInsert) {
            $update = "UPDATE inventory SET in_pending=1 WHERE item_ID = '$pending';";
            $sqlUpdate = mysqli_query($conn,$update);
            echo "Item ".$pending. " added in pending orders <br/>";
            $updateTotal = "UPDATE supplier_Transactions SET transaction_TotalPrice = transaction_TotalPrice + '$items_total'";
            $sqlUpdateTotal = mysqli_query($conn,$updateTotal);
        } else {
            echo mysqli_error($conn);
        }


}   // END OF ADDING IN PENDING ORDERS =====================================================


?>
