<!DOCTYPE html>


<html>
	<head>
  		<link rel="stylesheet" type="text/css" href="mycss.css" />
  		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  		<script src="myjs.js" type="text/javascript"></script>
	</head>
	
<body>

		<?php
			include_once 'env/conn.php';

			//TEST CODE ONLY
			$sql = "SELECT * FROM branch;";                                    #check if in customer table
			$result = mysqli_query($conn,$sql);
			$resultCheck = mysqli_num_rows($result);
			$exists = false;                                                     

				if ($resultCheck>0){
    				while ($row = mysqli_fetch_assoc($result)) {
            		$branchName = $row['branch_Name'];      
            		$branchAddress = $row['branch_Address'];
            		echo $branchName .'<br/>';
            		echo $branchAddress;
    				}
				}       
				mysqli_close($conn);

					
		?>




	<div class="header">
		<div class="navbar">
			<img src="logo.png" width="30%" height="20%">
			<ul>
				<li><a href="index.php"><i class="fa fa-home"></i> Home </a></li>
				<li><a href="orders.php"><i class="fa fa-file"></i> Orders </a></li>
				<li><a href="salesReport.php"><i class="fa fa-book"></i> Sales </a></li>
				<li><a href="inventory.php"><i class="fa fa-pencil"></i> Inventory </a></li>
				<li><a href="suppliers.php"><i class="fa fa-wrench"></i> Suppliers </a></li>
				
			</ul>
		</div>
			<div class="banner">
				<div class="left-column">
					</br>
					</br>
					<h1>VSJM Merchandising </h1>
					</br>
					<p> VSJM Merchandising is a single proprietorship business that derives its revenues from selling hardware and construction materials. 
						The products are divided into the following: Electrical and Plumbing materials, Roofing Materials, Architectural Materials, Paint Materials and Accessories, Bolts and Nuts, and Tools.
						It also provides services such as architectural design consultancy, paint color matching and consultancy, CCTV hardware and software installation, 
						and electrical installation. The store operates daily from 8 am to 5 pm.</p>
					
					
				</div>
				
				
				
			</div>
	</div>



</body>
</html>
