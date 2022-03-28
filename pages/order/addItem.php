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

        //if item exists in inventory, get retail price
        if ($countS >= 1) {
            $rowS = mysqli_fetch_assoc($resSearch);
            $itemPrice = $rowS['item_RetailPrice'];
            $itemName = $rowS['item_Name'];

            $cartArray = array(
                $itemID => array (
                "name" => $itemName,
                "qty" => 1,
                "price" => $itemPrice,
                "total" => $itemTotal
            ));

            if(!isset($_SESSION['cart'])) {
                //if no cart yet
                $itemTotal = $itemPrice * 1;
                $_SESSION['cart'] = $cartArray;
            } else {
                //if cart exists
                $arrayKeys = array_keys($_SESSION['cart']);
                if (in_array($itemID,$arrayKeys)) {
                    //if item exists in cart, update
                    foreach ($_SESSION['cart'] as &$eachItem) {
                        if ($eachItem['name'] == $itemName) {
                            $eachItem['qty'] += 1;
                            $eachItem['total'] = $eachItem['qty'] * $eachItem['price'];
                            $wasFound = true;
                            break;
                        }
                    }
                } else {
                    //if cart exsists, but no item
                    $itemTotal = $itemPrice * 1;
                    $_SESSION['cart'] = array_merge($_SESSION['cart'], $cartArray);
                }
            }

            header("location: order.php");
            exit();
        }
    }
?>