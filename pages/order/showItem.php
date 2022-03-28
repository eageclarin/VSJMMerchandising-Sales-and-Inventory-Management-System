<?php
    include_once '../../env/conn.php';
?>

<html>
<body>
    <?php
        if(isset($_SESSION['cart'])){
        ?>	
            <table width="100%">
            <?php		
                foreach ($_SESSION["cart"] as $item){
                    ?>
                        <tr>
                            <td style="width: 10%;"> </td>
                            <td style="width: 33%;"> <?php echo $item["name"] ?> </td>
                            <td style="width: 15%;"> <?php echo $item["qty"] ?> </td>
                            <td style="width: 20%;"> <?php echo $item["price"] ?> </td>
                            <td style="width: 22%;"> <?php echo $item["total"] ?> </td>
                        </tr>
                    <?php
                }
                    ?>
            </table>		
        <?php
        } 
    ?>
</body>
</html>