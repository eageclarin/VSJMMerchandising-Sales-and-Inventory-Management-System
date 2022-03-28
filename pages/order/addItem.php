<?php
    include_once '../../env/conn.php';

    //variables
    $itemID = "";
    $wasFound = false;

    if(isset($_GET['itemID'])) {
        $itemID = $_GET['itemID'];

        //search item in inventory
        $sqlSearch = "SELECT * FROM inventory iv
            INNER JOIN item i ON (iv.item_ID = i.item_ID)
            WHERE i.item_ID = '$itemID' 
            AND iv.item_Stock > 0";
        $resSearch = mysqli_query($conn, $sqlSearch);
        $countS = mysqli_num_rows($resSearch);
        mysqli_error($conn);
        echo $sqlSearch;
        echo "hello";

        //if item exists in inventory, get retail price
        if ($countS >= 1) {
            $rowS = mysqli_fetch_assoc($resSearch);
            $itemPrice = $rowS['item_RetailPrice'];
            $itemName = $rowS['item_Name'];

            if(empty($_SESSION['cart'])) {
                //if no cart yet
                $itemTotal = $itemPrice * 1;
                $_SESSION['cart'] = array(array("name" => $itemName, "qty" => 1, "price" => $itemPrice, "total" => $itemTotal));
            } else {
                foreach ($_SESSION['cart'] as $eachItem) {
                    if ($eachItem['name'] == $itemName) {
                        $eachItem['qty'] += 1;
                        $eachItem['total'] = $eachItem['qty'] * $eachItem['price'];
                        $wasFound = true;
                        break;
                    }
                }

                if ($wasFound == false) { //if cart exists, but product not added yet
                    array_push($_SESSION['cart'], array("name" => $itemName, "qty" => 1, "price" => $itemPrice, "total" => $itemTotal));
                }
            }

            header("location: order.php");
            exit();
        } else {
            mysqli_error($conn);
            echo $sqlSearch;
        }
    }
?>