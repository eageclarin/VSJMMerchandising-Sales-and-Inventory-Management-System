<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./style.css?ts=<?=time()?>">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 

      <!-- CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<!-- JQUERY/BOOTSTRAP -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>


<?php 
include "conn.php";
require_once '../../env/auth_check.php';

$result = mysqli_query($conn, "SELECT SUM(order_Total) AS totalSum, COUNT(item_ID) AS totalItems, order_Date FROM order_items INNER JOIN orders on orders.order_ID = order_items.order_ID ");
$row = mysqli_fetch_array($result);
$totalItems = $row['totalItems'];
$totalSum = $row['totalSum'];
?>

<body>
<main>
    <div class="nav"> 
        <?php include 'navbar.php'; ?>
    </div>   

    <!-- NAV BAR -->
    <div class="container-fluid bg-light" style="padding-right:0;padding-left:0; padding-bottom:0">
    <nav class="navbar  px-3 py-3" style=" width:100%">
      <ul class="nav nav-tabs pb-2" style="width:100%">
        
        <li class="nav-item" style="padding-left: 2.1%">
          <a class="nav-link " aria-current="page" href="../inventory/inventory.php" ><i class="bi bi-archive-fill"></i> Inventory</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../supplier/suppliers.php"><i class="bi bi-people-fill"></i> Suppliers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="../sales/sales.php"><i class="bi bi-table"></i> Sales</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../order/order.php"><i class="bi bi-cart-fill"></i> Sales Entry</a>
        </li>

        <div class="btn-group" style="display:block; margin-left: auto; margin-right:5">
				<button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" id="dropdownUser1" aria-expanded="false">
					<img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
					<strong><?php echo $_SESSION["customerName"]; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</button>
				<ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start"  aria-labelledby="dropdownUser1">
				<li><a class="dropdown-item" href="#">Settings</a></li>
				<li><a class="dropdown-item" href="#">Profile</a></li>
				<li><hr class="dropdown-divider"></li>
				<li><a class="dropdown-item" href="../../login.php">Sign out</a></li>
				</ul>
			</div>
      </ul>
    </nav>
    <!-- END OF NAVBAR -->

    <div class="container-fluid bg-light p-5 pt-2 mb-0">
        <div id="head">
            <!--Heading -->
            <div id="inventoryHead" class="row mt-3" >
                <span class="fs-1 fw-bold"> SALES REPORT </span>
            </div> 
            
            <!-- Average Daily Sales Chart -->
            <div id="monthly">
                <div class="p-3 bg-white rounded border rounded shadow-sm">
                    <div class="card chart-container">
                        <canvas id="chart"></canvas>
                    </div>
                </div>
            </div>
            
            <div id="group">
                <!-- SALES INFO -->
                <div class="p-3 bg-white rounded border rounded shadow-sm" id="weekly" style="margin-right:15px; height:100%;">
                    <strong> NUMBER OF SALES </strong> <br/>
                    <span class="text-primary fs-3"><?php echo $totalItems;?> <i class="fas fa-coins pt-2" style="float:right;"></i></span> <br/>
                    <strong> REVENUE </strong> <br/>
                    <span class="text-primary fs-3"> Php <?php echo $totalSum;?><i class='fas fa-wallet pt-2' style="float:right;"></i></span> 
                </div>

                <!-- This Week's Sales -->
                <div class="p-3 bg-white rounded border rounded shadow-sm" id="weekly" style="float:right;">
                    <div class="card chart-container">
                        <canvas id="chart2"></canvas>
                    </div>
                </div>

                <!-- Buttons -->
                <div id="exportBtn">
                    <!-- Download Sales Report Excel File -->
                    <form action="export.php" method="post">
                        <button class="btn btn-success" style="float:left; width:48%; margin-bottom:10px; margin-right:15px;" name="export" type="submit" ><i class='fas fa-download'></i> Sales Report</button> 
                    </form>

                    
                    <!-- Summaries in PDF -->
                    
                    <form action="pdf_CustomReport.php" method="GET" target="_blank">

                        <!-- Choose Date -->
                        <div class="p-1 mb-0 rounded border shadow-sm" style="float:right;width:48%;">
                            <small class="font-weight-bold" style="padding-left:2px; badding-bottom:0px; font-weight:bold;">Custom Date</small>
                                <div class="form-floating">   
                                    <label style="padding-top:1px;"><small>From </small> </label>      
                                    <input type="date" name="from_date" id="from_date" value="<?php if(isset($_GET['from_date'])){ echo $_GET['from_date']; } else {
                                        echo '2022-01-01';
                                    } ?>" class="form-control" onchange="transactionDate()" style="padding:0px;padding-left:65px; padding-right:10px; height:30px; font-size:14px;">
                                </div>          
                                <div class="pt-1 form-floating">
                                    <label style="padding-top:6px;"><small>To</small> </label>
                                    <input type="date" name="to_date" id="to_date" value="<?php if(isset($_GET['to_date'])){ echo $_GET['to_date']; } else {echo date("Y-m-d");} ?>" class="form-control" onchange="transactionDate()" min="2022-01-01" style="padding:0px;padding-left:65px; padding-right:10px; height:30px; font-size:14px;">
                                </div>
                        </div> 
                        
                        <!--summary button -->
                        <button class="btn btn-primary dropdown-toggle" style="float:left; width:48%; margin-bottom:10px; " name="export" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" ><i class='fas fa-download' ></i> Summary</button>   
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="pdf_DailyReport.php"  target="_blank">Daily Sales</a></li>
                            <li><a class="dropdown-item" href="pdf_WeeklyReport.php"  target="_blank">Weekly Sales</a></li>
                            <li><a class="dropdown-item" href="pdf_MonthlyReport.php"  target="_blank">Monthly Sales</a></li>
                            <li><a class="dropdown-item" href="pdf_QuarterlyReport.php" target="_blank">Quarterly Sales</a></li>
                            <li><a class="dropdown-item" href="pdf_TodaysReport.php?from_date=<?php echo date('Y-m-d'); ?>&to_date=<?php echo date('Y-m-d'); ?>" target="_blank">Sales Today</a></li>
                            <li><button class="dropdown-item" type="submit">Sales in Date Range</button></li>
                        </ul>
                          

                    </form> 

                </div> <!-- END OF exportBtn-->
            </div><!-- END OF group -->
        </div><!-- END OF head -->

            <!--<div class="col-md-12" style="float:left;">
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
                    </div>-->
                    

                   <!-- 
                    <div class="card-header">
                        <h5>Custom Date</h5>
                    </div>-->
                    <!--<div class="card-body">
                        
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
                        </form> 
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
            </div>-->

        <!-- Daily Sales Table -->
        <div class="card mt-0" style="float:left; width:100%">
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
                            <!-- FILTER DATE -->
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
                                    $totalItems_Day = $row['totalItems'];
                                    $totalSum_Day = $row['totalSum'];
                                ?>
                                <p class="text-info"> Total Sales Items: <?php echo $totalItems_Day; ?> <br/>
                                REVENUE: Php <?php  echo number_format($totalSum_Day,2); ?> </p>
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
                    </div><!-- container1 -->
                </div><!-- card-body -->
            </div><!-- card -->

    </div> <!-- container-fluid -->
                             
 </main>

<?php //CHART QUERIES
    //THIS WEEK
    $days = array(0,0,0,0,0,0);
    $date = date("Y-m-d");
    $week=date_create($date);
    $week = date_format($week,"W");
    $sql = "SELECT SUM(order_Total) AS orderTotal, order_Date FROM orders WHERE WEEK(order_Date) = '$week' GROUP BY order_Date;";                                    
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck>0){
        while ($row = mysqli_fetch_assoc($result)) {
            $index=date_create($row['order_Date']);
            $index = date_format($index,"w");
            $days[$index] = $row['orderTotal'];
        }
    }

    //AVERAGE DAILY SALES MONTHLY
    $months = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $date = date("Y-m-d");
    $year=date_create($date);
    $year = date_format($year,"Y");
    $sql = "SELECT AVG(daily) AS daily, orderDate FROM (SELECT SUM(order_Total) as daily, order_Date AS orderDate FROM orders WHERE YEAR(order_Date)='$year' GROUP BY order_Date) AS average GROUP BY MONTH(orderDate);";                                    
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck>0){
        while ($row = mysqli_fetch_assoc($result)) {
            $index=date_create($row['orderDate']);
            $index = date_format($index,"m");
            $index = intval(ltrim($index, '0'));
            $months[$index-1] = $row['daily'];
        }
    }

?>
<!-- FOR CHARTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"> </script>
<script>
      const ctx = document.getElementById("chart").getContext('2d');
      const arr1 = <?php echo json_encode($months);?>;
      const myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["January", "February", "March",
          "April", "May", "June", "July", "August", "September", "October",
          "November", "December"],
          datasets: [{
            label: 'Average Daily Sales',
            backgroundColor: 'rgba(161, 198, 247, 1)',
            borderColor: 'rgb(47, 128, 237)',
            data: arr1,
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
              }
            }]
          }
        },
      });  
</script>
<script>
      const ctx2 = document.getElementById("chart2").getContext('2d');
      const arr = <?php echo json_encode($days);?>;
      const myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
          labels: ["S","M", "T", "W", "Th",
          "F", "S"],
          datasets: [{
            label: 'This Week',
            backgroundColor: 'rgba(161, 198, 247, 1)',
            borderColor: 'rgb(47, 128, 237)',
            data: arr,
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
              }
            }]
          }
        },
      });
</script>
<!-- END OF CHARTS -->

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
