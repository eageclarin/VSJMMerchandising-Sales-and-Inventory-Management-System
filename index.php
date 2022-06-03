<?php
error_reporting(0);
session_start();
include_once 'env/conn.php';
require_once 'auth_check.php';
?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
	<!-- CSS -->
	<link rel="stylesheet" href="index.css" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

	<!-- JQUERY/BOOTSTRAP -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 

	<script type="text/javascript">
		$(document).ready(function() {
			clockUpdate();
			setInterval(clockUpdate, 1000);
		});

		function clockUpdate() {
			var date = new Date();
			var ampm = 'AM';
			function addZero(x) {
				if (x<10) {
					return x = '0'+x;
				} else {
					return x;
				}
			}

			function twelveHour(x) {
				if (x>12) {
					ampm = 'PM';
					return x = x-12;
				} else if (x==0) {
					ampm = 'AM';
					return x = 12;
				} else {
					ampm = 'AM';
					if (x==12) {
						ampm = 'PM';
					}
					return x;
				}
			}

			var h = addZero(twelveHour(date.getHours()));
			var m = addZero(date.getMinutes());
			var s = addZero(date.getSeconds());

			const weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
			const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
			var da = weekday[date.getUTCDay()];
			var mo = month[date.getUTCMonth()];
			var d = date.getDate();
			var y = date.getFullYear();

			$('.clock').text(h + ':' + m + ':' + s + ' ' + ampm);
			$('.day').text(da);
			$('.date').text(mo + ' ' + d + ', ' + y);
		}
	</script>
</head>	
<body>
	    <!-- NAV BAR 
		<nav class="navbar">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a href="../../index.php" class="d-flex align-items-center pl-3 mb-3 mb-md-0 me-md-auto text-decoration-none">
            <img src="img/logo.png" class="me-2" width="40"/>
            <span class="fs-5"> VSJM Merchandising</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="pages/inventory/inventory.php">Inventory</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="pages/supplier/suppliers.php">Suppliers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="pages/sales/sales.php">Sales</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="pages/order/order.php">Order</a>
        </li>
      </ul>
      
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
          <strong>User</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="login.php">Sign out</a></li>
        </ul>
      </div>
    </nav>
     END OF NAV BAR -->
	     <!----------- NAVIGATION BAR
		 <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="img/logo.png" class="me-2" width="30"/>VSJM Merchandising</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
                <a class="nav-link" href="pages/inventory/inventory.php">Inventory</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="pages/supplier/suppliers.php">Supplier</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="pages/sales/sales.php">Report</a>
            </li>
			<li class="nav-item">
                <a class="nav-link"  href="pages/sales/sales.php">Sales Entry</a>
            </li>
        </ul>
        </div>
    </div>
	<div class="dropdown " style="padding-right:80px;">
        <a href="#" class="pr-3 d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
          <strong ><?php //echo $_SESSION["customerName"]; ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1" >
			<li class=" dropdown-item text-muted">Settings</li>
          	<li class="dropdown-item text-muted">Profile</li>
          	<li><a class="dropdown-item" href="#">Settings</a></li>
          	<li><a class="dropdown-item" href="#">Profile</a></li>
          	<li><hr class="dropdown-divider"></li>
          	<li><a class="dropdown-item" href="login.php">Sign out</a></li>
        </ul>
      </div>
    </nav>
    END NAVIGATION BAR ------------>
	<main>
	
	<!------------ SIDEBAR ----------->
	<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark h-100" style="width: 280px;">
		<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
		<img src="img/logo.png" class="me-2" width="40"/>
		<span class="fs-5"> VSJM Merchandising</span>
		</a>
		<hr class="mb-1">

		<!------ REMINDER ------>
		<ul class="nav nav-pills flex-column mb-auto">
			<li class="nav-item">
				<p class="fw-bold fs-5 fst-italic mb-3"> Reminder </p>
				<!-- SHOW LOW ON STOCKS ITEMS AND PENDING DELIVERIES-->
			<?php
				//LOW ON STOCKS	
				$sql = "SELECT * FROM inventory INNER JOIN item ON (inventory.item_ID = item.item_ID) WHERE inventoryItem_Status = 1 AND item_Stock<=10";
				$result = mysqli_query($conn,$sql);
				$resultCheck = mysqli_num_rows($result);
				if ($resultCheck>0){ 
					echo '<span class="text-warning mt-3 pb-2">Low on Stocks</span>';
					echo "<div class='table-wrapper' style='height:auto; max-height:150px;' id='style-1'>";
					echo '<div class="container flex-column mb-auto gap-2">';
					while ($row = mysqli_fetch_assoc($result)) {	
			?>
						<div class="rounded p-2 py-1 row mb-2" style="background-color: #343a40;" id="reminder">
							<div class="col-9 px-0 text-muted" >
								<a href="pages/inventory/inventory.php" class="text-light"><?php echo $row['item_Name'] ?></a>
							</div>
							<div class="col px-0 text-danger text-end">
								<?php echo $row['item_Stock'] .$row['item_unit'] ?>
							</div>
						</div>
			<?php
					}
					echo '</div>';
					echo '</div>';
				}

				//PENDING ORDERS
				$sql1 = "SELECT * FROM supplier_Transactions  INNER JOIN supplier ON (supplier.supplier_ID = supplier_Transactions.supplier_ID ) WHERE transaction_Status = 0";
				$result1 = mysqli_query($conn,$sql1);
				$resultCheck1 = mysqli_num_rows($result1);
				if ($resultCheck1>0){ 
					
					echo '<span class="text-warning mt-3 pb-2">Pending Orders</span>';
					echo "<div class='table-wrapper' style='height:auto; max-height:150px;' id='style-1'>";
					echo '<div class="container flex-column mb-auto gap-2">';
					while ($row1 = mysqli_fetch_assoc($result1)) {	
			?>
						<div class="rounded p-2 py-1 row mb-2" style="background-color: #343a40;" id="reminder">
							<div class="col-9 px-0">
								<a href="pages/inventory/pending.php" class="text-light"><?php echo $row1['transaction_ID'] .': ' .$row1['supplier_Name'] ?></a>
							</div>
							<div class="col px-0 text-danger text-end">
								<?php echo number_format($row1['transaction_TotalPrice'],2) ?>
							</div>
						</div>
			<?php
					  	}
			
					echo '</div>';
					echo "</div>";
				}

				//PENDING DELIVERIES 	
				$sql1 = "SELECT * FROM supplier_Transactions  INNER JOIN supplier ON (supplier.supplier_ID = supplier_Transactions.supplier_ID ) WHERE transaction_Status = 1";
				$result1 = mysqli_query($conn,$sql1);
				$resultCheck1 = mysqli_num_rows($result1);
				if ($resultCheck1>0){ 
					echo '<span class="text-warning mt-3 pb-2">Deliveries</span>';
					echo "<div class='table-wrapper' style='height:auto; max-height:150px;' id='style-1'>";
					echo '<div class="container flex-column mb-auto gap-2">';
					while ($row1 = mysqli_fetch_assoc($result1)) {	
			?>
						<div class="rounded p-2 py-1 row mb-2" style="background-color: #343a40;" id="reminder">
							<div class="col-9 px-0">
								<a href="pages/inventory/pending.php" class="text-light"><?php echo $row1['transaction_ID'] .': ' .$row1['supplier_Name'] ?></a>
							</div>
							<div class="col px-0 text-danger text-end">
								<?php echo number_format($row1['transaction_TotalPrice'],2) ?>
							</div>
						</div>
			<?php
					}
					echo '</div>';
					echo '</div>';
				}
				?>
				
			</li>
		</ul>
		<a class="nav-link d-grid p-0 mt-auto" href="env/backup.php" >
			<button class="btn btn-light"><i class="bi bi-save"></i> Backup Database</button>
		</a>
		<!------ END OF REMINDER ------>

		<!------ USER FUNCTIONS
		<hr>
		<div class="dropdown">
			<a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
				<img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
				<strong>User</strong>
			</a>
			<ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
				<li><a class="dropdown-item" href="#">Settings</a></li>
				<li><a class="dropdown-item" href="#">Profile</a></li>
				<li><hr class="dropdown-divider"></li>
				<li><a class="dropdown-item" href="#">Sign out</a></li>
			</ul>
		</div>
		END OF USER FUNCTIONS ------>
	</div>
	<!------------ END OF SIDEBAR ----------->

	<!----------- RIGHT SIDE ------------>
	<div class="container-fluid bg-light w-100">
		<!-- NAV BAR -->
		<nav class="navbar px-3 py-3">
      	<ul class="nav nav-tabs  pb-2"   style="width:100%; border:0">
			<li class="nav-item" >
				<a class="nav-link  " href="pages/inventory/inventory.php"><i class="bi bi-archive-fill"></i> Inventory</a>
			</li>
			<li class="nav-item">
				<a class="nav-link link-success" href="pages/supplier/suppliers.php"><i class="bi bi-people-fill"></i> Suppliers</a>
			</li>
			<li class="nav-item">
				<a class="nav-link link-danger" href="pages/sales/sales.php"><i class="bi bi-table"></i> Sales</a>
			</li>
			<li class="nav-item">
				<a class="nav-link link-warning" href="pages/order/order.php"><i class="bi bi-cart-fill"></i> Order</a>
			</li>
		
			<div class="btn-group" style="display:block; margin-left: auto; margin-right:2">
				<button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" id="dropdownUser1" aria-expanded="false">
					<img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
					<strong><?php echo $_SESSION["customerName"]; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</button>
				<ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start"  aria-labelledby="dropdownUser1">
				<li><a class="dropdown-item" href="#">Settings</a></li>
				<li><a class="dropdown-item" href="#">Profile</a></li>
				<li><hr class="dropdown-divider"></li>
				<li><a class="dropdown-item" href="login.php">Sign out</a></li>
				</ul>
			</div>
		</ul>
    	</nav>
		<!------ MAIN PAGES
		<div class="row navbar-expand-md px-3 mt-3 mb-0" style="height:20%">
			<ul class="navbar-nav d-flex">
				INVENTORY
				<li class="nav-item flex-fill">
					<a class="nav-link d-grid h-75" href="pages/inventory/inventory.php">
						<button class="btn btn-primary fs-5 shadow-sm"><i class="bi bi-archive-fill"></i><br>Inventory</button>
					</a>
				</li>

				SUPPLIERS
				<li class="nav-item flex-fill">
					<a class="nav-link d-grid h-75" href="pages/supplier/suppliers.php">
						<button class="btn btn-success fs-5 shadow-sm"><i class="bi bi-people-fill"></i><br>Suppliers</button>
					</a>
				</li>

				SALES
				<li class="nav-item flex-fill">
					<a class="nav-link d-grid h-75" href="pages/sales/sales.php">
						<button class="btn btn-danger fs-5 shadow-sm"><i class="bi bi-table"></i><br>Reports</button>
					</a>
				</li>

				ORDER
				<li class="nav-item flex-fill">
					<a class="nav-link d-grid h-75" href="pages/order/order.php">
						<button class="btn btn-warning fs-5 shadow-sm"><i class="bi bi-cart-fill"></i><br>Sales Entry</button>
					</a>
				</li>
			</ul>
		</div>
		END OF MAIN PAGES ------>
		
		<?php
		?>
		<!------ ORDERED FROM SUPPLIERS ------>
		<div class="row px-3 mt-2" style="height:60%">
			<div class="col">
				<span class="fs-5 pb-1 fw-bold"> Pending Purchases  </span>(from Suppliers)
				<hr class="mt-1 ">
				<div class="bg-dark mt-2 rounded shadow-sm table-hover">
					<div class="row text-center text-light border-bottom p-2">
						<div class="col-2">Transaction ID</div>
						<div class="col-2">Supplier ID</div>
						<div class="col-3">Supplier Name</div>
						<div class="col-3">Transaction Date</div>
						<div class="col-2">Total Price</div>
					</div>
					<div style="overflow-y:scroll; overflow-x:hidden; max-height: 65%;">
					<?php 

					$sql = "SELECT * FROM supplier_transactions INNER JOIN supplier ON (supplier_transactions.supplier_ID = supplier.supplier_ID) WHERE transaction_Status =0 ;";   
					$result = mysqli_query($conn,$sql);
					$resultCheck = mysqli_num_rows($result); 

					if ($resultCheck>0){
						while ($row = mysqli_fetch_assoc($result)) {
						  $n++;
						  $ID = $row['transaction_ID'];  
						  $supplier = $row['supplier_ID'];
						  $supplierName = $row['supplier_Name'];
						  $transacDate = $row['transaction_Date'];   
						  $total = $row['transaction_TotalPrice'];                
						
					?>	
						<div class="row bg-white text-center border-bottom p-2" onclick="location.href='pages/inventory/pending.php'"> 
							<div class="col-2 fw-bold fs-5"><?php echo $ID ?></div> 
							<div class="col-2 fs-5"><?php echo $supplier ?></div>
							<div class="col-3 fs-5"><?php echo $supplierName ?></div>
							<div class="col-3 fs-5"><?php echo $transacDate ?></div>
							<div class="col-2 fs-5"><?php echo $total ?></div>
						</div>
					<?php
						$i++; 
					}
				}
					?>
					</div>
				</div>
			</div>
		</div>
				
		<!------ END OF SUPPLIERS ------>

		<!------ BOTTOM ------>
		<div class="row px-3 pt-0 mt-4" style="height:25%">
			<!-- SALES -->
			<?php 
			$result = mysqli_query($conn, "SELECT COUNT(order_ID) as orderCount, SUM(order_Total) AS orderTotal FROM orders");
			$row = mysqli_fetch_array($result);
			
			$orderCount = $row['orderCount'];
			$orderTotal = $row['orderTotal'];
			?>

			<div class="col-7">
				<span class="fs-5 pb-1 fw-bold"> Sales </span>
				<hr class="mt-1">
				<div class="bg-white text-center mt-2 rounded shadow-sm">
					<div class="row h-50">
						<span class="align-middle fs-1 text-success fw-bold"> <?php echo $orderTotal; ?> PHP</span>
						<span> No. of Orders: <?php echo $orderCount; ?> </span>
					</div>
				</div>
			</div>
			<!-- END OF SALES -->

			<!-- TIME AND DATE -->
			<div class="col text-end align-self-center">
				<div class="clock fw-bold fs-1 text-danger">00:00:00</div>
				<div class="day fs-3 fst-italic"> Day </div>
				<div class="date fs-3"> Date </div>
			</div>
			<!-- END OF TIME AND DATE -->
		</div>
		<!------ END OF BOTTOM ------>
	</div>
	</main>
</body>
</html>
