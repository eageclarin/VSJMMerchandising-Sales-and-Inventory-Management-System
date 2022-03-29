<?php
    include_once '../../env/conn.php';

    //variables
    $sqlCateg = "SELECT DISTINCT item_category FROM inventory";
    $resCateg = mysqli_query($conn, $sqlCateg);

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        switch($action) {
            case "add":
                //variables
                if(isset($_GET['itemID']) && isset($_GET['itemName']) && isset($_GET['itemPrice'])) {
                    $id = $_GET['itemID'];
                    $name = $_GET['itemName'];
                    $price = $_GET['itemPrice'];
                    $qty = 1;
                    $iTotal = $price * $qty;

                    $sqlSearch = "SELECT * FROM cart WHERE itemID = $id";
                    $resSearch = mysqli_query($conn, $sqlSearch);
                    $rowSearch = mysqli_fetch_assoc($resSearch);
                    $checkID = $rowSearch['itemID'];

                    if(!$checkID) { //if product not in cart yet
                        $sqlInsert = "INSERT INTO cart (
                            itemID, itemName, itemPrice, quantity, itemTotalP)
                            VALUES (
                            '$id', '$name', '$price', '$qty', '$iTotal')";
                        $resInsert = mysqli_query($conn, $sqlInsert);

                        //update total
                        //decrease stock
                        if ($resInsert) {
                            header("location: order.php");
                        } else {
                            echo "ERROR: Could not be able to execute $sqlInsert." . mysqli_error($conn);
                        }
                        
                    } else { //if product already in cart
                        $itemQty = $rowSearch['quantity'];
                        $itemTotal = $rowSearch['itemTotalP'];
                        
                        $itemQty++;
                        $itemTotal = $itemQty * $price;

                        $sqlUpdate = "UPDATE cart SET quantity = '$itemQty', itemTotalP = '$itemTotal'
                            WHERE itemID = (SELECT cart_ID FROM cart WHERE itemID = '$id')";
                        $resUpdate = mysqli_query($conn, $sqlUpdate);

                        //update total
                        //decreae stock
                        if ($resUpdate) {
                            header('location: order.php');
                        } else {
                            echo "ERROR: Could not be able to execute $sqlUpdate." . mysqli_error($conn);
                        }
                    }
                }
                break;
            case "delete":
                //variables
                if(isset($_GET['itemID'])) {
                    $id = $_GET['itemID'];

                    $sqlSearch = "SELECT * FROM cart WHERE itemID = $id";
                    $resSearch = mysqli_query($conn, $sqlSearch);
                    $rowSearch = mysqli_fetch_assoc($resSearch);
                    $checkID = $rowSearch['itemID'];

                    if($checkID) { //if product in cart
                        $sqlDelete = "DELETE FROM cart WHERE itemID = $id";
                        $resDelete = mysqli_query($conn, $sqlDelete);

                        //update total
                        //increase stock
                        header("location: order.php");
                    }
                }
                break;
        }
    }

?>

<html>
<head>
    <link rel="stylesheet" href="order.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <script src="order.js"></script>
    <script type="text/javascript">
        $(document).ready(function() { //display all items
            var display = document.getElementById('list');
            display.innerHTML = "<object type='text/html' style='width:100%; height:100%' data='getItem.php'></object>";
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="left" style="width:70%;">
            <?php
                while (($rowCateg = mysqli_fetch_assoc($resCateg))) {
                    $itemCateg = $rowCateg['item_category'];
            ?>
                    <button onclick="showItems('<?php echo $itemCateg ?>')"><?php echo $itemCateg ?></button>
            <?php    
                }
            ?>
                <button onclick="showItems('all')">all</button>
            <div id="list"> List of Items </div>
        </div>
        
        <div class="right" style="width:30%;"> 
            <table style="width:100%;">
                <tr>
                    <td style="width: 10%;"> </td>
                    <td style="width: 33%;"> Name </td>
                    <td style="width: 15%;"> Qty </td>
                    <td style="width: 20%;"> Each </td>
                    <td style="width: 22%;"> Total </td>
                </tr>

                <?php
                    $sqlDisplay = "SELECT * FROM cart";
                    $resDisplay = mysqli_query($conn, $sqlDisplay);
                    $totalPrice = 0;

                    while($rowDisplay = mysqli_fetch_assoc($resDisplay)) {
                ?>
                    <tr>
                        <td style="width: 10%;">
                            <form action="order.php?action=delete&itemID=<?php echo $rowDisplay["itemID"] ?>" method="post">
                                <input type="image" src="icon-delete.png" />
                            </form>
                        </td>
                        <td style="width: 33%;"> <?php echo $rowDisplay["itemName"] ?> </td>
                        <td style="width: 15%;"> <?php echo $rowDisplay["quantity"] ?> </td>
                        <td style="width: 20%;"> <?php echo $rowDisplay["itemPrice"] ?> </td>
                        <td style="width: 22%;"> <?php echo $rowDisplay["itemTotalP"] ?> </td>
                    </tr>
                <?php  
                        $totalPrice += $rowDisplay["itemTotalP"];
                    }
                ?>
            </table>
        </div>
    </div>
</body>
</html>