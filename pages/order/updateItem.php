<?php
    include_once '../../env/conn.php';

    $id = $qty = $price = $total = $totalPrice = "";
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        switch($action) {
            case "update":
                //variables
                if(isset($_GET['itemID']) && isset($_GET['qty'])) {
                    $id = $_GET['itemID'];
                    $qty = $_GET['qty'];

                    $sqlSearch = "SELECT * FROM cart WHERE itemID='$id'";
                    $resSearch = mysqli_query($conn, $sqlSearch);
                    $countSearch = mysqli_num_rows($resSearch);

                    if ($countSearch >= 1){ //if there's match, update
                        $rowSearch = mysqli_fetch_assoc($resSearch);
                        $price = $rowSearch['itemPrice'];

                        $total = $qty * $price;
                        $sqlUpdate = "UPDATE cart SET quantity='$qty', itemTotalP='$total' WHERE itemID='$id'";
                        $resUpdate = mysqli_query($conn, $sqlUpdate);
                        
                        echo $total;
                    }
                }
                break;
            case "total":
                $sqlSum = "SELECT SUM(itemTotalP) AS totalPrice FROM cart";
                $resSum = mysqli_query($conn, $sqlSum);
                $countSum = mysqli_num_rows($resSum);
        
                if($countSum >= 1) {
                    $rowSum = mysqli_fetch_assoc($resSum);
                    $totalPrice = $rowSum['totalPrice'];
        
                    echo $totalPrice;
                }
    
                break;
        }
    }
?>