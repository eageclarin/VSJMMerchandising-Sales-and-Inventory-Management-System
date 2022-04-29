<html>
	<head>
		<?php
			include_once '../../env/conn.php';

			if(isset($_POST['order'])){
				$_SESSION['orderItemID'] = $_POST['orderItemID'];
				$_SESSION['orderItemSupp'] = $_POST['orderItemSupp'];
					header("Location: ../inventory/addinventory.php");
				unset($_POST['edit']);
				}

		?>
		<script src="myjs.js" type="text/javascript"></script>
		<!-- CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<!-- JQUERY/BOOTSTRAP -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
		<style>

			body {
			    background: #ccc;
			}
			td, th{
				text-align: center;
				padding: 5px;
				margin: auto;
			}
		
			span.thick {
			  font-weight: bold;
			}
			.supplier_choice{
				margin:  auto;
				max-width: 90%;
			}
			.mytabs {
			    display: flex;
			    flex-wrap: wrap;
			    max-width: 100%;
			    margin: auto;
			    padding-top: 1px;
			   	padding-bottom: 5px;
			}
			.mytabs input[type="radio"] {
			    display: none;
			}
			.mytabs label {
			    padding: 15px;
			    background: #e2e2e2;
			    font-weight: bold;
			}

			.mytabs .tab {
			    width: 100%;
			    padding: 20px;
			    background: #fff;
			    order: 1;
			    display: none;
			}
			.mytabs .tab h2 {
			    font-size: 3em;
			}

			.mytabs input[type='radio']:checked + label + .tab {
			    display: block;
			}

			.mytabs input[type="radio"]:checked + label {
			    background: #fff;
			}
		</style>
		    <script>
        $(document).ready(function(){
            $('.editbtn').on('click',function(){
                $('#staticBackdrop').modal('show');
                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);
				var retail = data[5]*1.2;
                $('#editID').val(data[0]);
                $('#editRetail').val(Math.ceil(retail*4)/4);               
                $('#editMarkup').val(1.2);
                //$('#editStock').val(data[6]);
                $('#editCategory').val(data[4]);
                const $select = document.querySelector('#item_Category');
                $select.value = data[4];
				$('#editCost').val(data[5]);
                
                document.getElementById("labelID").innerHTML = "Item ID: " + data[0];
				document.getElementById("labelName").innerHTML = data[1];
				document.getElementById("labelBrand").innerHTML = data[3];
				document.getElementById("labelCost").innerHTML = data[5] + "/"+ data[2];
            });
        });

    </script> 



	</head>

	<body>
		


		<div class="supplier_choice">
			<?php

				$supplier_chosen = $_GET['supplier_ID'];
			
				$sql = "SELECT supplier_Name from supplier where supplier_ID =".$supplier_chosen;
				$result = $conn-> query($sql) or die($conn->error);
				if ($result-> num_rows >0) {
						while ($row = $result-> fetch_assoc()) {
							echo "<h1>".$row["supplier_Name"]."</h1>";
						}
				}
				
			?>
			<!-- EDIT MODAL ############################################################################ -->
			<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Buy Item</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div> <!-- MODAL-HEADER -->
					
					<form id="newform" action="../inventory/addinventory.php" method="post" class="form-inline" > 
					<div class="modal-body mb-2">   
						
						<input type="hidden"  id="editID" name="editID" placeholder="Enter"> 
						<input type="hidden" name=orderItemSupp value=<?php echo $supplier_chosen?>>
						<label for="editID" id="labelID" style="border:0; background-color: transparent; font-size: 1em; color:black; font-weight: 400;padding:0px;">Item ID: </label> </br>

						<label for="editName" id="labelName" style="border:0; background-color: transparent; font-size: 1.5em; color:black; font-weight: 500;"></label>
						<div>
							<label  id="labelBrand" style="border:0; background-color: transparent; font-size: 1em; color:black; font-weight: 500;"></label>
						</div>
						<div class="mb-1 mt-1">
						 
						
						<div>
							<label id="labelCost" style="border:0; background-color: transparent; font-size: 1.25em; color:black; font-weight: 500; padding-bottom:5px; color:#D8172B;"></label>
							<input type="hidden"  id="editCost" name="editCost" placeholder="Enter">
						</div> 
						
						<label for="editRetail" >Retail Price: </label>
						<div>
							<input type="number" step="0.25" class="form-control"  id="editRetail" name="editRetail" placeholder="Enter">
							<input type="hidden" step="0.25" class="form-control"  id="hiddenRetail" name="hiddenRetail" placeholder="Enter">
						</div> 
						
						<label for="editMarkup" >Markup: </label>
						<div>
							<input type="number" step="0.01" class="form-control"  id="editMarkup" name="editMarkup" placeholder="Enter">
							<input type="hidden" step="0.01" class="form-control"  id="hiddenmarkup" name="hiddenmarkup" placeholder="Enter">
						</div> 
						<label for="editStock" >Number of Stocks: </label>
						<div>
							<input type="number" step="any" class="form-control"  id="editStock" name="editStock" placeholder="Enter">
						</div> 
						<label for="item_Category" >Category: </label>
						<div>
							<select name="item_Category" id="item_Category" style="height:30px;" >
							<option value="Electrical" >Electrical</option>
							<option value="Plumbing">Plumbing</option>
							<option value="Architectural"> Architectural</option>
							<option value="Paints">Paints</option>
							<option value="bolts and nuts">Bolts and Nuts</option>
							<option value="Tools">Tools</option>
							</select>        
						</div> 
						</div> <!-- MB-1 MT-1 -->
					</div> <!-- MODAL-BODY -->
					<div class="modal-footer pb-0">
						<input type="hidden" name="url" value="inventory.php">
						<input  type="submit" value="Buy" name="buy" class="form-control btn btn-primary" style="width:150px" >  <!-- INSERT ALERT -->
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div> <!-- MODAL FOOTER -->
					</form>  
				</div> <!-- MODAL-CONTENT -->
				</div> <!-- MODAL-DIALOG -->
			</div> <!-- MODAL-FADE-->
			<!-- EDIT MODAL ############################################################################ -->

			<!--#################  LIST OF ITEMS #################-->
			<div class="mytabs">

			    <input type="radio" id="tabitems" name="mytabs" checked="checked">
			    <label for="tabitems">Items</label>
			    <div class="tab">
					<table>
						<th>Item ID</th>
						<th>Name</th>
						<th>Unit</th>
						<th>Brand</th>
						<th>Cost Price</th>
						<?php
							
							$sql = "SELECT * from item inner join supplier_item on item.item_ID=supplier_item.item_ID where supplier_ID = ".$supplier_chosen."";
							
							$result = $conn-> query($sql) or die($conn->error);

							if ($result-> num_rows >0) {
								while ($row = $result-> fetch_assoc()) {
									echo "<tr>
											<td>". $row["item_ID"]."</td>
											<td>". $row["item_Name"]."</td>
											<td>". $row["item_unit"]."</td>
											<td>". $row["item_Brand"]."</td>
											<td>". $row["item_Category"]."</td>
											<td>". $row["supplierItem_CostPrice"]."</td>
											<td><button onclick=\"location.href='editsupplieritem.php?item_ID=".$row['item_ID']."&supplier_ID=".$supplier_chosen."'\">Edit Item</button></td>
											<td><a onclick='return checkdelete()' href='deletesupplieritem.php?item_ID=".$row['item_ID']."&supplier_ID=".$supplier_chosen."'\"><button>Delete Item For This Supplier</a></button></td>
											<td><a onclick='return checkdelete()' href='deleteitemtransactions.php?item_ID=".$row['item_ID']."&supplier_ID=".$supplier_chosen."'\"><button>Delete Item & Transactions</a></button></td>"
											?>
											<td>
												<form action="suppliertable.php" class="mb-1" method="post">
												<input type=hidden name=orderItemID value=<?php echo $row['item_ID']?>>
												<input type=hidden name=orderItemSupp value=<?php echo $supplier_chosen?>>
												<!--<a href="../inventory/addinventory.php"> <button class="btn-primary" name="order" type="submit">Order</button></a>-->
												<button type="button" class="btn btn-primary editbtn p-2" style="float:left;">
                        Buy</i>
												</form>
											</td>
									<?php
									echo"</tr>";

								}
							echo "<tr><td colspan=\"11\"><button onclick=\"location.href='addsupplieritem.php?supplier_ID=".$supplier_chosen."'\">Add Item to Supplier</button></td></tr>";
							}
							else {
									
									echo "<tr><td colspan=\"6\">There are 0 results.</td></tr>";
									echo "<tr><td colspan=\"11\"><button onclick=\"location.href='addsupplieritem.php?supplier_ID=".$supplier_chosen."'\">Add Item to Supplier</button></td></tr>";
							}								

						?>
					</table>
				</div>

				<input type="radio" id="tabtransactions" name="mytabs">
			    <label for="tabtransactions">Transactions</label>
			    <div class="tab">
			      <table id="transaction_table">
						<th>Transaction ID</th>
						<th>Supplier ID</th>
						<th>Item ID</th>
						<th>Transaction Date</th>
						<th>Transaction Status</th>
						<th>Item Quantity</th>
						<th>Item Cost Price</th>
						<th>Item Total Price</th>
						<th>Transaction Total Price</th>
						<?php
							

							$sql = "SELECT * from supplier_transactions INNER JOIN transaction_items on transaction_items.transaction_ID = supplier_transactions.transaction_ID where supplier_ID = ".$supplier_chosen;
							$result = $conn-> query($sql) or die($conn->error);

							if ($result-> num_rows >0) {
								while ($row = $result-> fetch_assoc()) {
									echo "<tr>
											<td>". $row["transaction_ID"]."</td>
											<td>". $row["supplier_ID"]."</td>
											<td>". $row["item_ID"]."</td>
											<td>". $row["transaction_Date"]."</td>
											<td>". $row["transaction_Status"]."</td>
											<td>". $row["transactionItems_Quantity"]."</td>
											<td>". $row["transactionItems_CostPrice"]."</td>
											<td>". $row["transactionItems_TotalPrice"]."</td>
											<td>". $row["transaction_TotalPrice"]."</td>
											<td><button onclick=\"location.href='edittransaction.php?transaction_ID=".$row['transaction_ID']."'\">Edit</button></td>
											<td><button> <a onclick='return checkdelete()' href='deletetransaction.php?transaction_ID=".$row['transaction_ID']."'> Delete</button></a></td>
					
									</tr>";

								}
							echo "<tr><td colspan=\"11\"><button onclick=\"location.href='addtransaction.php?supplier_chosen=".$supplier_chosen."'\">Add Transaction</button></td></tr>";
							}
							else {
									
									echo "<tr><td colspan=\"11\">There are 0 results.</td></tr>";
									echo "<tr><td colspan=\"11\"><button onclick=\"location.href='addtransaction.php?supplier_chosen=".$supplier_chosen."'\">Add Transaction</button></td></tr>";
							}	


						?>
					</table>
			    </div>

			    <input type="radio" id="tabinformation" name="mytabs">
			    <label for="tabinformation">Supplier Information</label>
			    <div class="tab">
			      	<?php					

							$sql = "SELECT * from supplier where supplier_ID=".$supplier_chosen;
							$result = $conn-> query($sql) or die($conn->error);
							if ($result-> num_rows >0) {
								while ($row = $result-> fetch_assoc()) {
									echo "<br><span class='thick'>ID:</span> ".$row["supplier_ID"]." <br><br>";
									echo "<span class='thick'>Contact Person:</span> ".$row["supplier_ContactPerson"]." <br><br>";
									echo "<span class='thick'>Contact Number:</span> ".$row["supplier_ContactNum"]." <br><br>";
									echo "<span class='thick'>Supplier Address:</span> ".$row["supplier_Address"]." <br><br>";
								}
							}
							echo "<button onclick=\"location.href='editsupplier.php?supplier_ID=".$supplier_chosen."'\">Edit</button>";
					?>


			    </div>



			</div>
			<button type="button" onclick="location.href='./suppliers.php'">Back</button>
		</div>



			<?php
				$conn -> close();

			?>


		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script>
			$('#editRetail').change(function() {
				var costPrice = $('#editCost').val();
				var retail = $('#editRetail').val();
				
				$('#editMarkup').val(Number(parseFloat(retail /costPrice).toFixed(2)));
				
			});
			$('#editMarkup').change(function() {
				var costPrice = $('#editCost').val();
				var retail = (costPrice*$('#editMarkup').val()).toFixed(1);
				retail = Math.ceil(retail*4)/4;
				$('#editRetail').val( retail);
			});

			
		</script>
	</body>

</html>