<?php
    include_once '../../env/conn.php';

    //variables
    $sqlCateg = "SELECT DISTINCT item_category FROM inventory";
    $resCateg = mysqli_query($conn, $sqlCateg);

?>

<html>
<head>
    <link rel="stylesheet" href="order.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() { //display all items
            var display = document.getElementById('list');
            display.innerHTML = "<object type='text/html' style='width:100%; height:100%' data='getItem.php'></object>";

            var cart = document.getElementById('cart');
            cart.innerHTML = "<object type='text/html' style='width:100%; height:100%' data='showItem.php'></object>";
        });

        function showItems(categ) { //display items by categ
            $.ajax({
                url: 'getItem.php?categ='+categ,
                success: function(html) {
                var display = document.getElementById('list');
                display.innerHTML = html;
                }
            });
        }
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

            <div id="list"> List of Items </div>
        </div>
        
        <div class="right" style="width:30%;"> 
            <table style="width:100%;">
                <th>
                    <td style="width: 10%;"> </td>
                    <td style="width: 33%;"> Name </td>
                    <td style="width: 15%;"> Qty </td>
                    <td style="width: 20%;"> Each </td>
                    <td style="width: 22%;"> Total </td>
                </th>
            </table>

            <div id="cart"> </div>
        </div>
    </div>
</body>
</html>