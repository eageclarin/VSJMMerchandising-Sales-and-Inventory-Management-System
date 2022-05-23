<?php
	include_once '../../env/conn.php';

	//Edit supplier query
	if(isset($_POST['edit'])>0){
		$name = $_POST['editName'];
		$ID = $_POST['editID'];
		$person = $_POST['editPerson'];
		$number = $_POST['editNumber'];
		$address = $_POST['editAddress'];
		mysqli_query($conn, "UPDATE supplier set supplier_ID='$ID', supplier_Name='$name', supplier_ContactPerson='$person', 
		supplier_ContactNum='$number', supplier_Address='$address' 
		WHERE supplier_ID = '$ID' ");
		echo '<div class="popup" id="flash-msg">
		<div class="overlay"></div>
			<div class="popup-content">
			<i class="bi-check2-square" style="font-size:30px;"></i>
				<p class="title">Successfully Updated!</p>
			</div>
		</div>';
	}

?>


<!DOCTYPE html>

<html>
<head>
	<title> Suppliers </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="./style.css?ts=<?=time()?>">
    <script type="text/javascript" src="myjs.js"></script> 

    <!-- CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<!-- JQUERY/BOOTSTRAP -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


	
</head>
<body>
	<main >
    <?php include 'navbar.php'; ?>


	<div class="container-fluid bg-light p-5">
        <!-- EDIT MODAL ############################################################################ -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> <!-- MODAL-HEADER -->
                
                <form id="newform" action="suppliers.php" method="post" class="form-inline" > 
                <div class="modal-body mb-2">   
                    <input type="hidden"  id="editID" name="editID" placeholder="Enter"> 
                    <label for="editID" id="labelID" style="border:0; background-color: transparent; font-size: 1.25em; color:black; font-weight: 500;">Supplier ID: </label>
                    <div class="mb-1 mt-1"> 
                    <label for="editName" >Supplier Name: </label>
                    <div>
                        <input type="text" class="form-control"  id="editName" name="editName" placeholder="Enter">
                    </div> 
                    <label for="editPerson" >Supplier Contact Person: </label>
                    <div>
                        <input type="text" class="form-control"  id="editPerson" name="editPerson" placeholder="Enter">
                    </div> 
                    <label for="editNumber" >Supplier Contact Person: </label>
                    <div>
                        <input type="text" class="form-control"  id="editNumber" name="editNumber" placeholder="Enter">
                    </div> 
					<label for="editAddress" >Supplier Address: </label>
                    <div>
                        <input type="text" class="form-control"  id="editAddress" name="editAddress" placeholder="Enter">
                    </div> 
                    
                    </div> <!-- MB-1 MT-1 -->
                </div> <!-- MODAL-BODY -->
                <div class="modal-footer pb-0">
                    <input type="hidden" name="url" value="inventory.php">
                    <input  type="submit" value="update" name="edit" class="form-control btn btn-primary" style="width:150px" > 
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> <!-- MODAL FOOTER -->
                </form>  
            </div> <!-- MODAL-CONTENT -->
            </div> <!-- MODAL-DIALOG -->
        </div> <!-- MODAL-FADE-->
        <!-- EDIT MODAL ############################################################################ -->


	        <!-- ADD ITEM MODAL ############################################################################ -->

            <div class="modal fade" id="staticBackdropadd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> <!-- MODAL-HEADER -->
                    <div class="modal-body mb-2">
                        <div id ="transactionform">

                            <form action = "../supplier/suppliers.php" method="post" id="myForm">
								
                                <div class="mb-1 mt-1">

										<p>
                                            Supplier Name:
                                            <input type="text" name="supplier_Name" class="form-control" id="supplier_Name" placeholder="Enter">
                                        </p> 
                                        <p>
                                            Supplier Contact Person:
                                            <input type="text" name="supplier_ContactPerson" class="form-control"id="supplier_ContactPerson" placeholder="Enter">
                                        </p>
                                        <p>
                                            Supplier Contact Number:
                                            <input type="text" name="supplier_ContactNum" class="form-control"id="supplier_ContactNum" placeholder="Enter">
                                        </p>  
                                        <p>
                                            Supplier Address:
                                            <input type="text" name="supplier_Address" class="form-control" id="supplier_Address" placeholder="Enter">
                                        </p>
                                    
                                </div>
                                <div class="modal-footer pb-0">
                                    <input type="hidden" id="prevpage" name="prevpage" value="items">
                                    <input  type="submit" value="Submit" name="Submit" class="form-control btn btn-primary" style="width:150px" >  
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div> <!-- MODAL FOOTER -->
                            </form>
                        </div>

                    </div>
                    </form>
                </div>
                </div>
            </div>
            <!-- ADD ITEM MODAL ############################################################################ -->
        
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
			<select name="sort" id="sort" class="col-sm-10 form-select w-auto" onchange="sort()">
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

	<!------ADD SUPPLIER IN DB ------>
		<?php
			$db = mysqli_connect("localhost","root","","VSJM");

			if(!$db)
			{
				die("Connection failed: " . mysqli_connect_error());
			}

		if(isset($_POST['submit']) || isset($_POST['Submit']))
		{		
			
			$supplier_Name= $_POST['supplier_Name'];
			$supplier_ContactPerson = $_POST['supplier_ContactPerson'];
			$supplier_ContactNum= $_POST['supplier_ContactNum'];
			$supplier_Address= $_POST['supplier_Address'];
		

			$insert = mysqli_query($db,"INSERT INTO supplier ". "(supplier_Name, supplier_ContactPerson,
					supplier_ContactNum, supplier_Address) ". "
					VALUES('$supplier_Name', '$supplier_ContactPerson', '$supplier_ContactNum', '$supplier_Address')");
					
					
			if(!$insert)
			{
				echo mysqli_error();
			}
			else
			{
				echo '<div class="popup" id="flash-msg">
                		<div class="overlay"></div>
                			<div class="popup-content">
							<i class="bi-check2-square" style="font-size:30px;"></i>
                    			<p class="title">Successfully Added!</p>
                			</div>
            		 </div>';
			}
		}
		?>

	<!------ ORDER FUNCTIONS ------>

	<div class="row mt-3 justify-content-md-center" id="display" style="overflow-y:scroll; height: 450px">
	<?php
		$querySupplier = "select * from supplier";
		$resultSupplier = mysqli_query($conn,$querySupplier);
		if(mysqli_num_rows($resultSupplier) > 0){
			echo "<table class='table'>
			<thead>
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
			</thead>
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
						<button type="button" class="btn btn-outline-success editbtn" style="float:left; padding:5px;">
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
	<button class='btn btn-primary additembtn p-2 mt-3' type="button">Add New Supplier </button> 
	<?php mysqli_close($conn); ?>

	</div>
</div>



<script type="text/javascript">
		function changeLoc(loc, id) {
			if (loc == 'supplier') {
				location.href=loc+"table.php?supplier_ID="+id;
			} else {
				location.href=loc+"supplier.php?supplier_ID="+id;
			}
		}
		
		function fill(Value) {
		    $('#search').val(Value);
		    $('#display').hide();
		}

		function search() {
			var input = $('#search').val();

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
		}

		
		function sort() {
			var option = $('#sort').find(":selected").val();
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
		}

		function checkdelete(){
		return confirm('Are you sure you want to delete this record?');
		}

		function togglePopup(){
			document.getElementById("popup-1").classList.toggle("active");
		}


		//ADD SUPPLIER MODAL

          $(document).ready(function(){
            $('.additembtn').on('click',function(){
              $('#staticBackdropadd').modal('show');
            });
          });

          $(document).ready(function () {
              toggleFields(); 
              $("#supplier_ID").change(function () {
                  toggleFields();
              });


          });

		  //Edit Modal

		  $(document).ready(function(){
            $('.editbtn').on('click',function(){
                $('#staticBackdrop').modal('show');
                
                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#editID').val(data[0]);
                $('#editName').val(data[1]);
                $('#editPerson').val(data[2]);
                $('#editNumber').val(data[3]);
                $('#editAddress').val(data[4]);
                document.getElementById("labelID").innerHTML = "Supplier ID: " + data[0];
            });
        });


		  //Notification Modal
			$(document).ready(function () {
			$("#flash-msg").delay(1300).fadeOut("slow");
		});

          
</script>

</body>
</html>

