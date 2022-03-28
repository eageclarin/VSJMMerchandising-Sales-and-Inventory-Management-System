<?php
    include_once '../../env/conn.php';

    //variables
    $sqlCateg = "SELECT DISTINCT item_category FROM inventory";
    $resCateg = mysqli_query($conn, $sqlCateg);

?>

<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var display = document.getElementById('list');
            display.innerHTML = "<object type='text/html' style='width:100%; height:100%' data='getItem.php'></object>";
        });

        function showItems(categ) {
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
    <?php
        while (($rowCateg = mysqli_fetch_assoc($resCateg))) {
            $itemCateg = $rowCateg['item_category'];
    ?>
            <button onclick="showItems('<?php echo $itemCateg ?>')"> <?php echo $itemCateg ?> </button>
    <?php
        }
    ?>

    <div id="list"> List of Items </div>
</body>
</html>