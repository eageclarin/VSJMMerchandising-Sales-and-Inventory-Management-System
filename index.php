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
	<main class="h-100">
	
	<!------------ SIDEBAR ----------->
	<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
		<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
		<img src="img/logo.png" class="me-2" width="40"/>
		<span class="fs-5"> VSJM Merchandising</span>
		</a>
		<hr>
		<ul class="nav nav-pills flex-column mb-auto">
			<li class="nav-item">
				<a href="#" class="nav-link active" aria-current="page">
				<i class="bi bi-house-door"></i>
				Home
				</a>
			</li>
			<li>
				<a href="#" class="nav-link text-white">
				<i class="bi bi-speedometer2"></i>
				Dashboard
				</a>
			</li>
			<li>
				<a href="#" class="nav-link text-white">
				<i class="bi bi-table"></i>
				Orders
				</a>
			</li>
			<li>
				<a href="#" class="nav-link text-white">
				<i class="bi bi-grid"></i>
				Products
				</a>
			</li>
			<li>
				<a href="#" class="nav-link text-white">
				<i class="bi bi-person-circle"></i>
				Customers
				</a>
			</li>
		</ul>
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

	<!----------- RIGHT SIDE ------------>
	<div class="container-fluid bg-light">
		<!------ MAIN PAGES ------>
		<div class="row navbar-expand-md px-3 mt-3" style="height:20%">
			<ul class="navbar-nav d-flex">
				<li class="nav-item flex-fill">
					<a class="nav-link d-grid h-75">
						<button class="btn btn-primary fs-5 shadow-sm"><i class="bi bi-archive-fill"></i><br>Inventory</button>
					</a>
				</li>
				<li class="nav-item flex-fill">
					<a class="nav-link d-grid h-75">
						<button class="btn btn-success fs-5 shadow-sm"><i class="bi bi-people-fill"></i><br>Suppliers</button>
					</a>
				</li>
				<li class="nav-item flex-fill">
					<a class="nav-link d-grid h-75">
						<button class="btn btn-danger fs-5 shadow-sm"><i class="bi bi-table"></i><br>Summary of Sales</button>
					</a>
				</li>
				<li class="nav-item flex-fill">
					<a class="nav-link d-grid h-75">
						<button class="btn btn-warning fs-5 shadow-sm"><i class="bi bi-cart-fill"></i><br>Order</button>
					</a>
				</li>
			</ul>
		</div>
		<!------ END OF MAIN PAGES ------>

		<!------ ORDERED FROM SUPPLIERS ------>
		<div class="row px-3 h-50">
			<div class="col">
				<span class="fs-5 pb-1 fw-bold"> Suppliers </span>
				<hr class="mt-1 ">
				<div class="bg-dark mt-2 rounded shadow-sm">
					<div class="row text-center text-light border-bottom p-2">
						<div class="col-4">Item Name</div>
						<div class="col-2">Stocks Ordered</div>
						<div class="col-3">Date Ordered</div>
						<div class="col-3">To be Paid</div>
					</div>
					<div style="overflow-y:scroll; overflow-x:hidden; max-height: 65%">
					<?php
					$i = 0;
					while($i < 10) {
					?>
						<div class="row bg-white text-center border-bottom p-2">
							<div class="col-4 fw-bold fs-5">name <?php echo $i ?></div>
							<div class="col-2 fs-5">Stocks <?php echo $i ?></div>
							<div class="col-3 fs-5">Date <?php echo $i ?></div>
							<div class="col-3 fs-5">Paid <?php echo $i ?></div>
						</div>
					<?php
						$i++;
					}
					?>
					</div>
				</div>
			</div>
		</div>
		<!------ END OF SUPPLIERS ------>

		<!------ BOTTOM ------>
		<div class="row px-3" style="height:25%">
			<div class="col-7">
				<span class="fs-5 pb-1 fw-bold"> Sales </span>
				<hr class="mt-1">
				<div class="bg-white text-center mt-2 rounded shadow-sm">
					<div class="row h-50">
						<span class="align-middle fs-1"> 0.00 PHP</span>
						<span> No. of Orders: 0 </span>
					</div>
				</div>
			</div>
			<div class="col text-end align-self-center">
				<div class="clock fw-bold fs-1 text-danger">00:00:00</div>
				<div class="day fs-3 fst-italic"> Day </div>
				<div class="date fs-3"> Date </div>
			</div>
		</div>
		<!------ END OF BOTTOM ------>
	</div>
	</main>
</body>
</html>
