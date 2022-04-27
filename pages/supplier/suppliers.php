<?php
	include_once '../../env/conn.php';
?>
<!DOCTYPE html>

<html>
<head>
	<title> Suppliers </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="./style.css?ts=<?=time()?>">
    <script type="text/javascript" src="myjs.js"></script> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php include 'navbar.php'; ?>

    <!-- CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<!-- JQUERY/BOOTSTRAP -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<script>
		function changeLoc(loc, id) {
			if (loc == 'supplier') {
				location.href=loc+"table.php?supplier_ID="+id;
			} else {
				location.href=loc+"supplier.php?supplier_ID="+id;
			}
		}
		
	</script>
</head>
<body>
	<main class="h-100">
    <?php include 'navbar.php'; ?>
        
    <div class="container-fluid bg-light p-5">
	<!------ TITLE ------>
	<div class="row justify-content-md-center">
		<div class="row">
			<div class="col position-relative">
				<div class="text-center fs-1 fw-bold"> SUPPLIERS </div>
			</div>
		</div>
        <div class="form-group row mt-2 justify-content-md-center">
            <label for="sort" class="col-auto col-form-label fw-bold">Sort by:</label>
			<select name="sort" id="sort" class="col-sm-10 form-select w-auto">
				<option value="ID" selected >ID</option>
				<option value="SupplierName">Name</option>
				<option value="ContactP">Contact Person</option>
				<option value="Address">Address</option>
			</select> <!-- END OF SORTING -->

			<div class="col-5">
                <input type="text" id="search" class="form-control w-100" autocomplete="off" onkeyup="search()" placeholder="Search for ID, Name, Address...">
            </div>
        </div>
	</div>

	<!------ ORDER FUNCTIONS ------>
	<div class="row mt-5 justify-content-md-center" style="height:80%">
	<?php
		$querySupplier = "select * from supplier";
		$resultSupplier = mysqli_query($conn,$querySupplier);
		if(mysqli_num_rows($resultSupplier) > 0){
			echo "<table class='table'>
			<tr>
				<th>Supplier ID</th>
				<th>Supplier Name</th>
	      		<th>Supplier Contact Person</th>
				<th>Supplier Number</th>
				<th>Supplier Address</th>
				<th>Status</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			";
			while($row = mysqli_fetch_assoc($resultSupplier)){
				if($row['supplier_Status']==0){
					$supplier_Status="Inactive";
				}
				else{
					$supplier_Status="Active";
				}
			?>
				<tr>
					<td> <?php echo $row['supplier_ID'] ?> </td>
					<td> <?php echo $row['supplier_Name'] ?> </td>
					<td> <?php echo $row['supplier_ContactPerson'] ?> </td>
					<td> <?php echo $row['supplier_ContactNum'] ?> </td>
					<td> <?php echo $row['supplier_Address'] ?> </td>
					<td> <?php echo $supplier_Status ?> </td>
					<td>
						<button class="btn btn-outline-success" onclick="changeLoc('edit','<?php echo $row['supplier_ID']?>')">
							Edit
						</button>
					</td>
					<td>
						<button class="btn btn-outline-primary" onclick="changeLoc('delete','<?php echo $row['supplier_ID']?>')">
							Change Status
						</button>
					</td>
					<!-- <td> <button> <a onclick='return checkdelete()' href='deletesupplier.php?supplier_ID=".$row['supplier_ID']."'> Delete</button></a></td> -->
					<td>
						<button class="btn btn-outline-danger" onclick="changeLoc('supplier','<?php echo $row['supplier_ID']?>')">
							More Info
						</button>
					</td>
				</tr>
			<?php
			}
			echo "</table>";
		}
		else echo "No results";
	?>
	</div>
	<button onclick="location.href='./addsupplier.php'">Add new supplier</button>
	<?php mysqli_close($conn); ?>

	</div>
</div>

	<script>
		 function fill(Value) {
		    $('#search').val(Value);
		    $('#display').hide();
		 }


		$(document).ready(function(){
		    $("#search").keyup(function() {
		        var input = $(this).val();

		            $.ajax({
		                type: "POST",
		                url: "search_sort.php",
		                data: {
		                    search: input
		                },
		                success: function(data) {
		                    $("#display").html(data);
		                }
		            });
		  
		    });

		    $("#sort").change(function(){
		        var option = $(this).find(":selected").val();
		        sessionStorage.setItem("selectedOption", option);
		        var optionValue = $(this).selectedIndex;
		        $.ajax({
		            type: "POST",
		            url: "search_sort.php",
		            data: {
		                selected: option
		            },
		            success: function(data) { 
		                $("#display").html(data);
		            }
		        });
		        
		    });

		    //$('#sort').find('option[value='+sessionStorage.getItem('selectedOption')+']').attr('selected','selected');
		    $("#categ").change(function(){
		        var categOption = $(this).find(":selected").val();
		        $.ajax({
		            type: "POST",
		            url: "search_sort.php",
		            data: {
		                category: categOption
		            },
		            success: function(data) { 
		                $("#display").html(data);
		            }
		        });
		        
		    });
		});


		function checkdelete(){
		return confirm('Are you sure you want to delete this record?');
		}

		function togglePopup(){
			document.getElementById("popup-1").classList.toggle("active");
		}


	</script>
</body>
</html>

