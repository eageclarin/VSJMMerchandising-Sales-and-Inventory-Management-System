<?php
    include_once '../../env/conn.php';

    //variables
    $categ = "";
    $branch = 1;

    if (isset($_GET['categ'])) {
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
                    $itemName = $rowItems['item_Name']; //item name
                    $itemStock = $rowItems['item_Stock']; //item stock
                    $itemUnit = $rowItems['item_unit']; //item unit
                    $itemPrice = $rowItems['item_RetailPrice']; //item price
    ?>
                    <div style="width:24%; border-style: solid">
                        <div>
                            <?php echo $itemName ?><br>
                            <?php echo "Stocks: ".$itemStock ?><br>
                            <?php echo "P".$itemPrice."/".$itemUnit ?><br>
                            <button>add to cart</button>
                        </div>
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
                                <div>
                                    <?php echo $itemName ?>
                                    <?php echo $itemStock ?>
                                    <?php echo $itemPrice ?>
                                    <button>add to cart</button>
                                </div>
                            </div>
                            ';
                            $i++;
                        }
                    }
                }
                    echo "</div>";
                    echo "</div><br><br>";
        } else {
            mysqli_error($conn);
            echo $sqlItems;
        }
    ?>
</body>
</html>