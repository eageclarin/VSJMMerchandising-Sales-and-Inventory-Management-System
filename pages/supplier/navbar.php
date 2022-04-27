<?php
		$url = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
		$s = $si = 'text-white';
		if ($url == 'suppliers.php') {
			$s = 'active';
		} else if ($url == 'supplieritem.php') {
			$si = 'active';
		}
   ?>

	<!------------ SIDEBAR ----------->
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
		<a href="../../index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
		<img src="../../img/logo.png" class="me-2" width="40"/>
		<span class="fs-5"> VSJM Merchandising</span>
		</a>

		<!------ OTHER PAGES ------>
		<div class="mt-3 container w-100">
			<div class="row d-flex justify-content-between">
				<div class="col-auto p-0">
					<a href="../inventory/inventory.php">
						<button class="btn btn-primary">Inventory</button>
					</a>
				</div>
				<div class="col-auto p-0">
					<a href="../sales/sales.php">
						<button class="btn btn-danger">Sales</button>
					</a>
				</div>
				<div class="col-auto p-0">
					<a href="../order/order.php">
						<button class="btn btn-warning">Order</button>
					</a>
				</div>
			</div>
		</div>
		<!------ END OF OTHER PAGES ------>
		<hr>

		<!------ TABS ------>
		<ul class="nav nav-pills flex-column mb-auto">
			<li class="nav-item">
				<a href="suppliers.php" class="nav-link <?php echo $s ?>">
				  <i class="bi bi-archive"></i> Suppliers
				</a>
			</li>
			<li class="nav-item">
				<a href="supplieritem.php" class="nav-link <?php echo $si ?>">
					<i class="bi bi-grid"></i> Supplier Items
				</a>
			</li>
		</ul>
		<!------ END OF TABS ------>

        <div class="col mt-3">
            <div class="fw-bold fs-4 fst-italic mb-0"> Reminders </div>

			<!-- SHOW LOW ON STOCKS ITEMS AND PENDING DELIVERIES-->
			<?php
				//LOW ON STOCKS	
				$sql = "SELECT * FROM inventory INNER JOIN item ON (inventory.item_ID = item.item_ID) WHERE inventoryItem_Status = 1 AND item_Stock<=10";
				$result = mysqli_query($conn,$sql);
				$resultCheck = mysqli_num_rows($result);
				if ($resultCheck>0){ 
					echo 'Low on Stocks';
					echo '<div class="container flex-column mb-auto gap-2">';
					while ($row = mysqli_fetch_assoc($result)) {	
			?>
						<div class="rounded p-2 py-1 row" style="background-color: #343a40;">
							<div class="col-9 px-0">
								<?php echo $row['item_Name'] ?>
							</div>
							<div class="col px-0 text-danger text-end">
								<?php echo $row['item_Stock'] .$row['item_unit'] ?>
							</div>
						</div>
			<?php
					}
					echo '</div>';
				}

				//PENDING ORDERS
				$sql1 = "SELECT * FROM supplier_Transactions INNER JOIN transaction_items ON (supplier_Transactions.transaction_ID = transaction_Items.transaction_ID) INNER JOIN supplier ON (supplier.supplier_ID = supplier_Transactions.supplier_ID ) WHERE transaction_Status = 0";
				$result1 = mysqli_query($conn,$sql1);
				$resultCheck1 = mysqli_num_rows($result1);
				if ($resultCheck1>0){ 
					echo 'Pending Orders';
					echo '<ul class="text-wrap nav nav-pills flex-column mb-auto gap-2">';
					while ($row1 = mysqli_fetch_assoc($result1)) {	
						echo '<li class="rounded nav-item p-2 py-1" style="background-color: #343a40;">';
						echo	'<div style="float:left; width:80%;">'
										.$row1['transaction_ID'] .': ' .$row1['supplier_Name']
									.'</div>
									<div style="float:right;width:20%; padding-right:3px; color:#D8172B;">'
										.number_format($row1['transaction_TotalPrice'],2)
									.'</div>
								</li>';
					  	}
					echo '</ul>';
				}

				//PENDING DELIVERIES 	
				$sql1 = "SELECT * FROM supplier_Transactions INNER JOIN transaction_items ON (supplier_Transactions.transaction_ID = transaction_Items.transaction_ID) INNER JOIN supplier ON (supplier.supplier_ID = supplier_Transactions.supplier_ID ) WHERE transaction_Status = 1";
				$result1 = mysqli_query($conn,$sql1);
				$resultCheck1 = mysqli_num_rows($result1);
				if ($resultCheck1>0){ 
					echo 'Deliveries';
					echo '<ul class="text-wrap nav nav-pills flex-column mb-auto gap-2">';
					while ($row1 = mysqli_fetch_assoc($result1)) {	
						echo '<li class="rounded nav-item p-2 py-1" style="background-color: #343a40;">';
						echo	'<div style="float:left; width:80%;">'
										.$row1['transaction_ID'] .': ' .$row1['supplier_Name']
									.'</div>
									<div style="float:right;width:20%; padding-right:3px; color:#D8172B;">'
										.number_format($row1['transaction_TotalPrice'],2)
									.'</div>
								</li>';
					}
					echo '</ul>';
				}
				?>
		</div>
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
	</div>
	<!------------ END OF SIDEBAR ----------->
