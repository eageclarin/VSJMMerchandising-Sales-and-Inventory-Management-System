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
				<i class="bi bi-archive"></i> Inventory
				</a>
			</li>
			<li>
				<a href="#" class="nav-link text-white">
				<i class="bi bi-people"></i> Suppliers
				</a>
			</li>
			<li>
				<a href="#" class="nav-link text-white">
				<i class="bi bi-table"></i> Summary of Sales
				</a>
			</li>
			<li>
				<a href="#" class="nav-link text-white">
				<i class="bi bi-cart"></i> Order
			</li>
		</ul>
        <div class="col align-self-top">
                <div > Time & Date </div>
				<div class="clock fw-bold fs-2 text-light">00:00:00</div>
				<div class="date fs-4"> Date </div>
                <div class="day fs-5 fst-italic"> Day </div>
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

	<!----------- RIGHT SIDE ------------>
	<div class="container-fluid bg-light">
		<!------ ORDERED FROM SUPPLIERS ------>
		<div class="row px-3 mt-3 d-flex justify-content-between">
			<div class="col-7 h-100">
                <div class="conainer-fluid">
                    <div class="row">
                        <div class="col">
                            <span class="fs-5 pb-1 fw-bold"> Suppliers </span>
                        </div>
                    </div>
                    <div class="row" style="height:95%;max-height:95%;">
                        <div class="col mh-100 mt-2 px-0 rounded shadow-sm">
                            <div class="row w-100 text-center bg-dark text-light border-bottom px-0 py-2 mx-0">
                                <div class="col-4 p-0">Item Name</div>
                                <div class="col-2 p-0">Stocks Ordered</div>
                                <div class="col-3 p-0">Date Ordered</div>
                                <div class="col-3 p-0">To be Paid</div>
                            </div>
                            <div class="row bg-white m-0" style="overflow-y:scroll">
                            <?php
                                $i = 0;
                                while($i < 15) {
                            ?>
                                    <div class="row text-center border-bottom p-2">
                                        <div class="col-4 fw-bold fs-5 pl-5">name <?php echo $i ?></div>
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
                    <div class="row px-3 h-25 mt-4">
                        <div class="col-7">
                            <span class="fs-5 pb-1 fw-bold"> Sales </span>
                            <hr class="mt-1">
                            <div class="bg-white text-center mt-2 rounded shadow-sm">
                                <div class="row h-50">
                                    <span class="align-middle fs-1 text-success fw-bold"> 0.00 PHP</span>
                                    <span> No. of Orders: 0 </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
            <div class="col h-100 border">
                <span class="fs-5 pb-1 fw-bold pl-5"> Reminder </span>
                <hr class="mt-1">

                        <div class="row m-0 mh-100" style="overflow-y:scroll;">
                        <?php
                            $i = 0;
                            while($i < 20) {
                        ?>
                                <div class="row text-center p-2">
                                    <div class="col-4 pl-5">name <?php echo $i ?></div>
                                </div>
                        <?php
                                $i++;
                            }
                        ?>
                        </div>
			</div>
		</div>
		<!------ END OF SUPPLIERS ------>
	</div>
	</main>
</body>
</html>
