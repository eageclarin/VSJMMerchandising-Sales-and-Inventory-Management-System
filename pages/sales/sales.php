<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 

    
</head>
<body>

<div class="d-flex flex-row flex-shrink-0" >
<?php 
include "conn.php";
include 'navbar.php'; 

require_once '../../env/auth_check.php';
?>


	
        <div class="container" style="width: 80%;">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 style="float:left;">Sales Report</h4>
                        <form action="export.php" method="post">
                            <button class="btn btn-success" style="float:right; margin-right:10px" name="export" type="submit" ><i class='fas fa-download'></i> Sales Report</button>
                        </form>
                    </div>
                    <div class="card-body">
                    
                        <form method="GET"  action="pdf_DailyReport.php"  target="_blank">
                            <div class="row">
                                <div class="col-md-3" >
                                    <div>
                                        <input type="submit" name="submit" value="Daily" class="form-control" style="background-color:#7393B3"/>
                                    </div>
                                </div>    
                                <div class="col-md-3">
                                    <a href="pdf_WeeklyReport.php" style="text-decoration:none;" target="_blank">
                                        <div>
                                            <input type="button" name="submit" value=" Weekly" class="form-control" style="background-color:#7393B3"/>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="pdf_MonthlyReport.php" style="text-decoration:none;" target="_blank">
                                        <div>
                                            <input type="button" name="submit" value="Monthly" class="form-control" style="background-color:#7393B3"/>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="pdf_QuarterlyReport.php" style="text-decoration:none;" target="_blank">
                                        <div>
                                            <input type="button" name="submit" value="Quarterly" class="form-control" style="background-color:#7393B3"/> 
                                        </div>
                                    </a>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    

                    
                    <div class="card-header">
                        <h5>Custom Date</h5>
                    </div>
                    <div class="card-body">
                        <!--
                        <form action="pdf_CustomReport.php" method="GET" target="_blank">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="date" name="from_date" value="<?php if(isset($_GET['from_date'])){ echo $_GET['from_date']; } ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="date" name="to_date" value="<?php if(isset($_GET['to_date'])){ echo $_GET['to_date']; } ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label></label> <br>
                                      <button type="submit" class="form-control" style="color:black; background-color:#7393B3" style="background-color:#7393B3">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form> -->
                        <form action="pdf_CustomReport.php" method="GET" target="_blank">
                            <div class="row pb-3 mb-3">
                            <div class="col-md-3">        
                                <div class="form-group">          
                                <label>From </label>
                                <input type="date" name="from_date" id="from_date" value="<?php if(isset($_GET['from_date'])){ echo $_GET['from_date']; } else {
                                    echo '2022-01-01';
                                } ?>" class="form-control" onchange="transactionDate()">
                                </div>          
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>To </label>
                                <input type="date" name="to_date" id="to_date" value="<?php if(isset($_GET['to_date'])){ echo $_GET['to_date']; } else {echo date("Y-m-d");} ?>" class="form-control" onchange="transactionDate()" min="2022-01-01">
                                </div>
                            </div>
                            <div class="col-md-3">        
                                <div class="form-group">        
                                <label></label> <br>        
                                <button type="submit" class="form-control" style="color:black; background-color:#7393B3" style="background-color:#7393B3"><i class='fas fa-download'></i> Sales in Date Range</button>
                                </div>               
                            </div>
                            <div class="col-md-3">        
                                <div class="form-group">  
                                <label></label> <br>              
                                <button type="btn" class="form-control" style="color:black; background-color:#7393B3" style="background-color:#7393B3" onclick="window.open('pdf_CustomReport.php?from_date=<?php echo date('Y-m-d'); ?>&to_date=<?php echo date('Y-m-d'); ?>')"><i class='fas fa-download'  ></i> Sales Today</button>
                                </div>               
                            </div>
                            </div>              
                        </form> 
                    </div>
                


                    

                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <div class= "container1">
                        <table class="table pr-3">
                            <?php
                                
                               $sql = "select distinct item_NAME from item order by item_NAME";
                                $result = mysqli_query($conn, $sql);
                                if (isset($_GET['to_date'])) {
                                    $from_date = $_GET['to_date'];
                                    $to_date = $_GET['to_date'];
                                    //unset($_GET['to_date']);
                                  } else {
                                    $from_date = date("Y-m-d");
                                    $to_date = date("Y-m-d");
                                  }
                                
                                    
                            ?>
                            <thead>
                                <h5>
                                    <?php 
                                    $labelDate2=date_create($to_date);
                                    $labelDate2 = date_format($labelDate2,"F d, Y");
                                    ?> 
                                    Sales<?php echo " (".$labelDate2.")"; ?>
                                    <div style="float:right; width:50%; padding-right:15px;">
                                        <form action="sales.php" method="GET">
                                            <div class="row pb-2 mb-2">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                <input type="date" name="to_date" id="to_date" value="<?php if(isset($_GET['to_date'])){ echo $_GET['to_date']; } else {echo date("Y-m-d");} ?>" class="form-control" onchange="transactionDate()" min="2022-01-01">
                                                </div>
                                            </div>
                                            <div class="col-md-4">        
                                                <div class="form-group">              
                                                <button type="submit" class="form-control" style="color:black; background-color:#7393B3" style="background-color:#7393B3">Filter</button>
                                                </div>               
                                            </div>
                                            </div>                             
                                        </form> 
                                    </div>
                                </h5>
                                <!-- TOTAL SALES INFO -->
                                <?php
                                    $result = mysqli_query($conn, "SELECT SUM(orderItems_TotalPrice) AS totalSum, COUNT(item_ID) AS totalItems, order_Date FROM order_items INNER JOIN orders on orders.order_ID = order_items.order_ID 
                                    WHERE order_Date BETWEEN '$from_date' AND '$to_date' ");
                                    $row = mysqli_fetch_array($result);
                                    $totalItems = $row['totalItems'];
                                    $totalSum = $row['totalSum'];
                                ?>
                                <p class="text-info"> Total Sales Items: <?php echo $totalItems; ?> <br/>
                                Total Sales Value (in Pesos): <?php echo number_format($totalSum,2); ?> </p>
                                <!-- END TOTAL SALES INFO -->

                                <tr>
                                    <th>Order Date</th>
                                    <th>Order ID</th>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Item Unit</th>
                                    <th>Item Brand</th>
                                    <th>Quantity</th>
                                    <th>Order Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 


                                    $sql = "SELECT item.item_ID, item.item_Name, item.item_unit, item.item_Brand, order_items.order_ID, order_items.orderItems_Quantity, order_items.orderItems_TotalPrice, orders.order_Date, orders.order_Total 
                                            FROM item 
                                            INNER JOIN order_items on order_items.item_ID = item.item_ID 
                                            INNER JOIN orders on orders.order_ID = order_items.order_ID 
                                            WHERE orders.order_Date BETWEEN '$from_date' AND '$to_date'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) > 0)
                                    {
                                        foreach($result as $row)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $row['order_Date']; ?></td>
                                                <td><?= $row['order_ID']; ?></td>
                                                <td><?= $row['item_ID']; ?></td>
                                                <td><?= $row['item_Name']; ?></td>
                                                <td><?= $row['item_unit']; ?></td>
                                                <td><?= $row['item_Brand']; ?></td>
                                                <td><?= $row['orderItems_Quantity']; ?></td>
                                                <td><?= $row['orderItems_TotalPrice']; ?></td>
                                                
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        echo "No Record Found"; 
                                        ?>
                                        </br>
                                        <?php
                                        //echo $to_date;
                                    }
                                
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
