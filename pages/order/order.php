<?php
    include_once '../../env/conn.php';

    /*-------- VARIABLES --------*/
    $button = $updateStyle = $undo = "";
    $update = "-";

    /*-------- STORE ITEMS INTO ARRAY --------*/
    $sqlList = "SELECT * FROM inventory iv 
        INNER JOIN item i ON (iv.item_ID = i.item_ID)
        WHERE iv.item_Stock > 0
        AND i.item_Name LIKE '%$str%'
        ORDER BY i.item_Name ASC";
    $resList = mysqli_query($conn, $sqlList);
    $countList = mysqli_num_rows($resList);
     
    if ($countList > 0) {
        while ($list = mysqli_fetch_assoc($resList)) {
            $res[] = trim($list['item_Name']);
        }
    } else {
        $res = array();  
    }
    //pass to javascript
    echo "<script> var plang = ".json_encode($res)."; </script>";

    /*-------- DISPLAY UPDATE TEXT --------*/
    if (isset($_GET['update'])) {
        $u = $_GET['update'];

        switch($u) {
            case 'u':
                $update = "Already in cart. Updated item quantity.";
                break;
            case 'i':
                $update = "Item added to cart.";
                break;
            case 'n':
                $update = "Item out of stock / not in inventory.";
                $updateStyle = "style='color: #dc3545;'";
                break;
            case 'd':
                $update = "Item removed from cart.";
                $updateStyle = "style='color: #dc3545;'";
                break;
            case 'q':
                $update = "Item quantity updated.";
                break;
        }
    }

    /*-------- ACTION: ADD/DELETE ITEM --------*/
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        switch($action) {
            case "add": /*------ ADD ITEM ------*/
                //variables
                if(isset($_POST['item'])) {
                    $name = $_POST['item'];
                    $id = $price = '';
                    $sqlGet = "SELECT * FROM item i
                        INNER JOIN inventory iv ON (i.item_ID = iv.item_ID)
                        WHERE i.item_Name = '$name'
                        AND iv.item_Stock > 0";
                    $resGet = mysqli_query($conn, $sqlGet);
                    $countGet = mysqli_num_rows($resGet);

                    if ($countGet >= 1){ //item in inventory
                        $rowGet = mysqli_fetch_assoc($resGet);
                        $id = $rowGet['item_ID'];
                        $price = $rowGet['item_RetailPrice'];
                    } else {
                        header('location: order.php?search=n'); //item not in inventory
                    }
 
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
                            header('location: order.php?update=u'); //item in cart. updated item quantity
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
                            header("location: order.php?update=i"); //item added to cart
                        } else {
                            echo "ERROR: Could not be able to execute $sqlInsert." . mysqli_error($conn);
                        }
                    }
                }
                break;
            case "delete": /*------ DELETE ITEM ------*/
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
                        header("location: order.php?update=d");
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
    
    <!-- CSS -->
    <link rel="stylesheet" href="order.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- JQUERY/BOOTSTRAP -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    
    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="order.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            /*------ PAYMENT ------*/        
            var cash = document.getElementById('moneyInput').value;
            if (cash == 0 || cash == '') {
                document.getElementById('pay').disabled = true;
            } else {
                document.getElementById('pay').disabled = false;
            }

            /*------ SEARCH ITEM ------*/  
            $("#searchItem").autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(plang, request.term);

                    response(results.slice(0,5));
                }
            });

            /*------ ENTER KEY - SUBMIT ------*/  
            document.getElementById('searchItem').addEventListener('keyup', function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    document.getElementById('addItem').click();
                }
            });
            document.getElementById('qty').addEventListener('keyup', function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    document.getElementById('addItem').click();
                }
            });
        });
    </script>
</head>
<body>
    <!----------- NAVIGATION BAR ------------>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../../index.php">VSJM</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="../../index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../inventory/inventory.php">Inventory</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="../supplier/supplier.php">Supplier</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="../sales/sales.php">Sales</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>
    <!----------- END NAVIGATION BAR ------------>

    <!------------ BODY ----------->
    <main class="container pt-5">
        <!------ TITLE ------>
        <div class="row w-100" style="height:20%">
            <div class="col position-relative">
                <span class="position-absolute top-50 start-50 translate-middle fs-1 fw-bold"> ORDER </span>
            </div>
        </div>

        <!------ ORDER FUNCTIONS ------>
        <div class="row w-100" style="height:80%">
            <!------ CART ------>
            <div class="col-8">
                <div class="row text-center border-bottom p-2">
                    <div class="col-4">Name</div>
                    <div class="col-2">Price/Unit</div>
                    <div class="col-2">Qty</div>
                    <div class="col-3">Total</div>
                    <div class="col-1"></div>
                </div>

                <!-- list of items in cart -->
                <?php
                    $sqlDisplay = "SELECT * FROM cart c
                                    INNER JOIN item i ON (c.itemID = i.item_ID)";
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
                        $iName = $rowDisplay["itemName"];
                        $iPrice = $rowDisplay["itemPrice"];
                        $iQty = $rowDisplay['quantity'];
                        $style = "";
                        $sqlStock = "SELECT item_Stock FROM inventory i
                        INNER JOIN cart c ON (i.item_ID = c.itemID)
                        WHERE i.item_ID = $iID";
                        $resStock = mysqli_query($conn, $sqlStock);
                        $rowStock = mysqli_fetch_assoc($resStock);
                        $itemStock = $rowStock['item_Stock'];

                        if ($itemStock <= 10) { //if item stock is <=10
                            $style = "style='color:#dc3545;'";
                            if ($itemStock <= 0){ //if no more stock
                                $disable = "disabled";
                            }
                        } else {
                            $disable = "";
                        }
                ?>
                    <!-- display item information -->
                    <div class="row text-center border-bottom p-2 mt-2 fs-5">
                        <!-- item name -->
                        <div class="col-4 text-start fw-bold text-wrap">
                            <?php echo $iName ?> 
                        </div>

                        <!-- item unit -->
                        <div class="col-2">
                            <?php echo $iPrice ?> / <?php echo $rowDisplay["item_unit"] ?>
                        </div>

                        <!-- item quantity -->
                        <div class="col-2">
                            <form action="updateItem.php?action=update&itemID=<?php echo $iID ?>" method="post" class="mb-0">
                                <div class="input-group mb-0">
                                    <input type="number" name="qty" id="qty" class="form-control bg-dark text-light" value="<?php echo $iQty ?>" max="<?php echo $itemStock ?>" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-secondary" type="submit" id="qtyUpdate">&#8635;</button>
                                </div>
                            </form>
                            <p id="stocks" <?php echo $style ?>> Stocks left: <?php echo $itemStock ?> </p>
                        </div>

                        <!-- item total price -->
                        <div class="col-3">
                            <p id="itemTotal-<?php echo $iID ?>">
                                <?php echo $rowDisplay["itemTotalP"] ?>
                            </p>
                        </div>

                        <!-- item delete button -->
                        <div class="col">
                            <form action="order.php?action=delete&itemID=<?php echo $iID ?>" method="post">
                                <button type="submit" class="btn btn-danger" id="delItem" aria-label="Close">X</button>
                            </form>
                        </div>
                    </div>
                        
                    <?php  
                            $totalPrice += $rowDisplay["itemTotalP"];
                        }
                    ?>
            </div>
            <!------ END OF CART ------>

            <!------ ORDER ------>
            <div class="col">
                <!-- search item -->
                <form method="POST" action="order.php?action=add" class="d-flex mb-0">
                    <input type="text" name="item" autcomplete="off" class="form-control form-control-lg me-2 ui-autocomplete-input border" id="searchItem" placeholder="Search Item...">
                    <button class="btn btn-success" id="addItem" type="submit"><i class="fa fa-check btn-icon-prepend"></i>Add</button>
                </form>
                <p id="update" <?php echo $updateStyle ?>><?php echo $update ?></p>
                <!-- end of search item -->

                <!-- order total -->
                <div class="pb-0 mt-5"> Order ID #</div>
                <div class="row">
                    <div class="col-2">
                        <p class="fs-4"> Total </p>
                    </div>
                    <div class="col">
                        <p id="total" class="fw-bold text-end fs-2">
                            <?php echo $totalPrice ?>
                        </p>
                    </div>
                </div>
                <!-- end of order total -->

                <!-- buttons -->
                <div class="row">
                    <div class="col d-grid gap-2">
                        <!-- order button trigger modal -->
                        <button <?php echo $button ?> type="button" class="btn btn-lg btn-primary" id="order" data-toggle="modal" data-target="#receipt">
                            Order
                        </button>

                        <!-- empty cart -->
                        <button type="submit" <?php echo $button ?> form="emptyForm" class="btn btn-lg btn-outline-danger">
                            Empty Cart
                        </button>
                        <form action="updateItem.php?action=delete" method="post" id="emptyForm"></form>
                    </div>
                </div>
                <!-- end of buttons -->

                <!------ MODAL ------>
                <div class="modal fade bd-example-modal-lg" id="receipt" tabindex="-1" role="dialog" aria-labelledby="receiptLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <!-- modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="receiptLabel">Receipt</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <!-- end of modal header -->

                    <!-- modal body -->
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row w-100 m-0 pb-3">
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
                                                <h6 class="mb-0 <?php echo $margin ?>"> <?php echo $rowCart["itemName"] ?> </h6>
                                                <small class="text-muted mb-2"> <?php echo $rowCart["itemPrice"]?> x <?php echo $rowCart["quantity"] ?></small>
                                            </div>
                                            <div class="col">
                                                <h6 class="fw-bold mb-3 float-right <?php echo $margin ?>"> <?php echo $rowCart["itemTotalP"] ?> </h6>
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
                                    <div class="row mb-3">
                                        <div class="col-2">
                                            <span class="fs-5"> Total </span>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control fw-bold text-end fs-2" id="totalOrder" name="total" value="<?php echo $totalPrice ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-2">
                                            <p class="mb-0 pt-2"> Money </p>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control border text-end " autocomplete="off" name="money" id="moneyInput" placeholder="0" onkeyup="calculateChange(this.value)">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-2">
                                            <p class="mb-0 pt-2"> Change </p>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control text-end " name="change" id="change" value="" placeholder="0">
                                        </div>
                                    </div>
                                    <button class="w-100 mb-2 btn btn-lg rounded-4 btn-primary" name="pay" id="pay" type="submit">Pay</button>
                                    <button type="button" class="w-100 py-2 mb-2 btn btn-outline-danger rounded-4" data-dismiss="modal">Close</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of modal body -->

                    </div>
                </div>
                </div>
                <!------ END OF MODAL ------>
            </div>
        </div>
    </main>
</body>
</html>