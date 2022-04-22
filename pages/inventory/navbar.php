<?php
error_reporting(0);
include_once '../../env/conn.php';
?>

<!--<!DOCTYPE html>
<html>-->
  <head>
    <link rel="stylesheet" href="./style.css?ts=<?=time()?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="inventory.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>


    <!-- CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

	<!-- JQUERY/BOOTSTRAP -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <!-- NAVBAR <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>-->
    <!--<script src="assets/js/jquery.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>--> 
  </head>
  <!--<body>-->
   <!------------ SIDEBAR ----------->
	<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;float:left;height:100%;">
		<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
		<img src="img/logo.png" class="me-2" width="40"/>
		<span class="fs-5"> VSJM Merchandising</span>
		</a>
		<hr>

		<!------ REMINDER ------>
		<ul class="nav nav-pills flex-column mb-auto">
      <div style="height:60%">
     <!-- <ul class="navbar-nav d-flex flex-column mt-5 w-100">-->
        <li clas="nav-item w-100">
              <a href="inventory.php" class="nav-link active  text-light pl-4"> Inventory </a>
          </li>
          <li clas="nav-item w-100">
              <a href="categories.php" class="nav-link  text-light pl-4"> Categories </a>
          </li>
          <li clas="nav-item w-100">
              <a href="brands.php" class="nav-link  text-light pl-4"> Brands </a>
          </li>
          <li clas="nav-item w-100">
            <a href="pending.php" class="nav-link  text-light pl-4"> Pending </a>
        </li>

          <li clas="nav-item w-100">
              <a href="transactions.php" class="nav-link text-light pl-4"> Transactions </a>
          </li>
          <li clas="nav-item w-100">
              <a href="#" class="nav-link text-light pl-4"> Low on Stock </a>
          </li>
          <li clas="nav-item w-100">
              <a href="salability.php" class="nav-link text-light pl-4">Salability </a>
          </li>
          <li clas="nav-item w-100">
              <a href="items.php" class="nav-link text-light pl-4"> All Items </a>
          </li>
          <li clas="nav-item w-100">
              <a href="returnitem.php" class="nav-link text-light pl-4"> Returns </a>
          </li>
      </div>
      <div style="height:300px;">
      <!--</ul>-->
				<p class="fw-bold fs-4 fst-italic mb-0"> Reminder </p>
				<!-- SHOW LOW ON STOCKS ITEMS AND PENDING DELIVERIES-->
				<?php
					//LOW ON STOCKS
					echo 'Low on Stocks';
					$sql = "SELECT * FROM inventory INNER JOIN item ON (inventory.item_ID = item.item_ID) WHERE inventoryItem_Status = 1 AND item_Stock<=10";
					$result = mysqli_query($conn,$sql);
					$resultCheck = mysqli_num_rows($result);
					if ($resultCheck>0){ 
						echo '<ul class="text-wrap nav nav-pills flex-column mb-auto gap-2">';
					  	while ($row = mysqli_fetch_assoc($result)) {	
						  	echo '<li class="rounded nav-item p-2 py-1" style="background-color: #343a40;">';
							echo	'<div style="float:left; width:85%;">'
										.$row['item_ID'] .': ' .$row['item_Name']
									.'</div>
									<div style="float:right;width:12%; padding-right:3px; color:#D8172B;">'
										.$row['item_Stock'] .$row['item_unit']
									.'</div>
								</li>';
					  	}
						echo '</ul>';
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
				
			<!--</li>-->
      <div>
		</ul>
        
		<!------ END OF REMINDER ------>

		<!------ USER FUNCTIONS ------>
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
		<!------ END OF USER FUNCTIONS ------>
	</div></div>
	<!------------ END OF SIDEBAR ----------->
                <!--</body>
                </html>-->
