<?php
		$url = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
		$s = $si = 'text-white';
		if ($url == 'suppliers.php' || $url == 'editsupplier.php' || $url == 'suppliertable.php') {
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

		<!------ OTHER PAGES 
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
		END OF OTHER PAGES ------>
		<hr>

		<!------ TABS ------>
		<ul class="nav nav-pills flex-column mb-auto">
			<li class="nav-item">
				<a href="suppliers.php" class="nav-link <?php echo $s ?>">
				<i class="bi bi-people-fill"></i> Suppliers
				</a>
			</li>
			<li class="nav-item">
				<a href="supplieritem.php" class="nav-link <?php echo $si ?>">
				<i class="bi bi-collection"></i> Supplier Items
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
					echo '<span class="text-warning mt-3 pb-2">Low on Stocks</span>';
					echo "<div class='table-wrapper' style='height:auto; max-height:150px;' id='style-1'>";
					echo '<div class="container flex-column mb-auto gap-2">';
					while ($row = mysqli_fetch_assoc($result)) {	
			?>
						<div class="rounded p-2 py-1 row mb-2" style="background-color: #343a40;" id="reminder">
							<div class="col-9 px-0">
								<a href="../inventory/inventory.php" class="text-light"><?php echo $row['item_Name'] ?></a>
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
								<a href="../inventory/pending.php" class="text-light"><?php echo $row1['transaction_ID'] .': ' .$row1['supplier_Name'] ?></a>
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
								<a href="../inventory/pending.php" class="text-light"><?php echo $row1['transaction_ID'] .': ' .$row1['supplier_Name'] ?></a>
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
		</div>
		</div>
	</div>
	<!------------ END OF SIDEBAR ----------->
	
