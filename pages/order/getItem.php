<?php
    include_once '../../env/conn.php';

    //variables
    $categ = "";
    $branch = 1;

    if (isset($_GET['categ']) && $_GET['categ'] != "all") {
        $categ = $_GET['categ'];

        $sqlItems = "SELECT * FROM inventory iv 
            INNER JOIN branch b ON (iv.branch_ID = b.branch_ID)
            INNER JOIN item i ON (iv.item_ID = i.item_ID)
            WHERE iv.item_Stock > 0
            AND b.branch_ID = '$branch'
            AND iv.item_category = '$categ'
            ORDER BY i.item_Name ASC";
        $resItems = mysqli_query($conn, $sqlItems);
    } else {
        $sqlItems = "SELECT * FROM inventory iv 
            INNER JOIN branch b ON (iv.branch_ID = b.branch_ID)
            INNER JOIN item i ON (iv.item_ID = i.item_ID)
            WHERE iv.item_Stock > 0
            AND b.branch_ID = '$branch'
            ORDER BY i.item_Name ASC";
        $resItems = mysqli_query($conn, $sqlItems);
    }
?>

<html>
<head>
    <link rel="stylesheet" href="order.css" />
    <script src="order.js"></script>
</head>
<body style="margin:0;">
    <?php
        if ($resItems) {
            $i = $row = 0;
            $count = mysqli_num_rows($resItems); //number of rows

    ?>
            <div>
                <div>
    <?php
                while (($rowItems = mysqli_fetch_assoc($resItems))) {
                    $itemID = $rowItems['item_ID']; //item ID
                    $itemName = $rowItems['item_Name']; //item name
                    $itemStock = $rowItems['item_Stock']; //item stock
                    $itemUnit = $rowItems['item_unit']; //item unit
                    $itemPrice = $rowItems['item_RetailPrice']; //item price
    ?>
                    <div style="width:24%; border-style: solid">
                        <form action="order.php?action=add&itemID=<?php echo $itemID ?>&itemName=<?php echo $itemName ?>&itemPrice=<?php echo $itemPrice ?>" method='post' target="_top">
                        <div>
                            <?php echo $itemName ?><br>
                            Stocks: <?php echo $itemStock ?> <br>
                            <?php echo $itemPrice ?> / <?php echo $itemUnit ?><br>
                            <input type="submit" value="Add to Cart"/>
                        </div>
                        </form>
                    </div>
    <?php
                    $i++; //number of items in row
                    if ($i % 4 != 0) { //5 items per row display
                        echo "</div><div>"; //next row display
						$i = 0;
                    }

                    if(++$row == $count) {
                        while ($i % 4 != 0) {
                            echo '<div style="width:24%">
                                <form action="" method="">
                                <div>
                                    <input type="hidden" class="itemID" name="itemID" value="" />
                                    <input type="hidden" class="itemName" name="itemName"  value="" /><br>
                                    Stocks: <br>
                                    <input type="hidden" class="itemPrice" name="itemPrice" value="" /> / <?php echo $itemUnit ?><br>
                                    <input type="hidden" onclick="" name="add" value="Add to Cart" />
                                </div>
                                </form>
                            </div>
                            ';
                            $i++;
                        }
                    }
                }
                    echo "</div>";
                    echo "</div><br><br>";
        }
    ?>
</body>
</html>