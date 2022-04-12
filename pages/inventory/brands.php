<?php
include_once '../../env/conn.php';

?>

<!DOCTYPE html>
<html>
  <head>
    <title> Brands </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
    </head>
    <body>
        <?php include 'navbar.html';?>
        <div id='content'>   
            <h1 style="padding-bottom: 30px;"> Brands </h1>
            <div class="table-wrapper">
            <?php
                $sql = "SELECT COUNT(item.item_ID) AS num, item_Brand FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) GROUP BY item_Brand"; 
                $result = mysqli_query($conn,$sql);
                $resultCheck = mysqli_num_rows($result);
                if ($resultCheck>0){
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo $row['item_Brand']. ": " . $row['num']. " items <br/>";
                    }
                }
            ?>
            </div>
        </div>
    </body>
</html>