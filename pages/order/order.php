<?php
    include_once '../../env/conn.php';

    //variables
    $button = "";
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
                    $countSearch = mysqli_num_rows($resSearch);
                    $rowSearch = mysqli_fetch_assoc($resSearch);

                    if($countSearch >= 1) { //if product not in cart yet
                        $qty = $rowSearch['quantity'];
                        $itemTotal = $rowSearch['itemTotalP'];
                        
                        $qty++;
                        $itemTotal = $qty * $price;

                        $sqlUpdate = "UPDATE cart SET quantity = '$qty', itemTotalP = '$itemTotal'
                            WHERE itemID = '$id'";
                        $resUpdate = mysqli_query($conn, $sqlUpdate);

                        //update total
                        //decreae stock
                        if ($resUpdate) {
                            header('location: order.php');
                        } else {
                            echo "ERROR: Could not be able to execute $sqlUpdate." . mysqli_error($conn);
                        }
                    } else { //if product already in cart
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="order.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <script src="order.js"></script>
    <script type="text/javascript">
        $(document).ready(function() { //display all items
            var display = document.getElementById('list');
            display.innerHTML = "<object type='text/html' style='width:100%; height:100%' data='getItem.php'></object>";
        
            var cash = document.getElementById('moneyInput').value;
            if (cash == 0 || cash = '') {
                document.getElementById('pay').disabled = true;
            } else {
                document.getElementById('pay').disabled = false;
            }
        });
    </script>
</head>
<body>
    <a href="../../index.php"><button> home </button></a>
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

                    $countRows = mysqli_num_rows($resDisplay);
                    if ($countRows > 0) {
                        $button = "";
                    } else {
                        $button = "disabled";
                    }

                    while($rowDisplay = mysqli_fetch_assoc($resDisplay)) {
                        $iID = $rowDisplay["itemID"];

                        $sqlStock = "SELECT item_Stock FROM inventory i
                        INNER JOIN cart c ON (i.item_ID = c.itemID)
                        WHERE i.item_ID = $iID";
                        $resStock = mysqli_query($conn, $sqlStock);
                        $rowStock = mysqli_fetch_assoc($resStock);
                        $itemStock = $rowStock['item_Stock'];

                        if ($itemStock <= 0) {
                            $disable = "disabled";
                        } else {
                            $disable = "";
                        }
                ?>
                    <tr>
                        <td style="width: 10%;">
                            <form action="order.php?action=delete&itemID=<?php echo $iID ?>" method="post">
                                <input type="image" src="icon-delete.png" />
                            </form>
                        </td>
                        <td style="width: 33%;"> <?php echo $rowDisplay["itemName"] ?> </td>
                        <td style="width: 15%;">
                            <form action="" method="post">
                                <select <?php echo $disable ?>  name="qty" class="select" onchange="changeQty('<?php echo $iID ?>', this.value);">
                                    <?php
                                        echo '<option value="'.$rowDisplay['quantity'].'" selected>'.$rowDisplay['quantity'].' </option>';
                                        $i = 1;
                                        while ($i <= $itemStock) {
                                            echo "<option value=".$i.">".$i."</option>";
                                            $i++;

                                            if ($i > 20) {
                                                break;
                                            }
                                        }
                                    ?> 
                                </select>
                            </form>
                        </td>
                        <td style="width: 20%;"> <?php echo $rowDisplay["itemPrice"] ?> </td>
                        <td style="width: 22%;">
                            <p id="itemTotal-<?php echo $iID ?>">
                                <?php echo $rowDisplay["itemTotalP"] ?>
                            </p>
                        </td>
                    </tr>
                <?php  
                        $totalPrice += $rowDisplay["itemTotalP"];
                    }
                ?>
                    <tr>
                        <td colspan="4" style="text-align: right"> Total: </td>
                        <td>
                            <p id="total" style="font-weight: bold">
                                <?php echo $totalPrice ?>.00
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <!-- Button trigger modal -->
                            <button <?php echo $button ?> type="button" class="btn btn-primary" data-toggle="modal" data-target="#receipt">
                            Order
                            </button>
                            <form action="updateItem.php?action=delete" method="post">
                                <input type="submit" <?php echo $button ?> class="btn btn-secondary" value="Clear"/>
                            </form>
                        </td>
                    </tr>
            </table>

            

            <!-- Modal -->
            <div class="modal fade bd-example-modal-lg" id="receipt" tabindex="-1" role="dialog" aria-labelledby="receiptLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptLabel">Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row w-100 m-0">
                            <div class="col pl-0">
                                <div clas="container">
                                <?php
                                    $sqlCart = "SELECT * FROM cart";
                                    $resCart = mysqli_query($conn, $sqlCart);
                                    $i = 0;

                                    while($rowCart = mysqli_fetch_assoc($resCart)) {
                                        if($i != 0){ //check if first in array
                                            $margin = "mt-3";
                                        } else {
                                            $margin = "";
                                        }
                                ?>
                                    <div class="row">
                                        <div class="col-8">
                                            <h6 class="fs-5 mb-0 <?php echo $margin ?>"> <?php echo $rowCart["itemName"] ?> </h6>
                                            <small class="text-muted mb-2"> <?php echo $rowCart["itemPrice"]?>.00 x <?php echo $rowCart["quantity"] ?></small>
                                        </div>
                                        <div class="col">
                                            <h6 class="fs-5 fw-bold mb-3 float-right <?php echo $margin ?>"> <?php echo $rowCart["itemTotalP"] ?>.00 </h6>
                                        </div>
                                    </div>
                                <?php
                                        $i++;
                                    }
                                ?>
                                </div>
                            </div>
                            <div class="col border-left pr-0">
                            <form action="updateItem.php?action=order" method="post">
                                <div class="form-floating mb-3 row">
                                    <label for="total" class="col-sm-2 col-form-label">Total</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext h2" id="totalOrder" name="total" value="<?php echo $totalPrice.'.00' ?>">
                                    </div>
                                </div>
                                <div class="form-floating mb-3 row">
                                    <label for="moneyInput" class="col-sm-2 col-form-label">Money</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control border font-weight-bold" name="money" id="moneyInput" placeholder="0.00" onkeyup="calculateChange(this.value)">
                                    </div>
                                </div>
                                <div class="form-floating mb-3 row">
                                    <label for="change" class="col-sm-2 col-form-label">Change</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext font-weight-bold" name="change" id="change" value="" placeholder="0.00">
                                    </div>
                                </div>
                                <button class="w-100 mb-2 btn btn-lg rounded-4 btn-primary" name="pay" id="pay" type="submit">Pay</button>
                                <button type="button" class="w-100 py-2 mb-2 btn btn-outline-primary rounded-4" data-dismiss="modal">Close</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>