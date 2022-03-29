<html>
	<head>
		<?php
			include_once '../../env/conn.php';
		?>
		<script src="myjs.js" type="text/javascript"></script>
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

			<div class="mytabs">

			    <input type="radio" id="tabitems" name="mytabs" checked="checked">
			    <label for="tabitems">Items</label>
			    <div class="tab">
					<table>
						<th>Item ID</th>
						<th>Name</th>
						<th>Unit</th>
						<th>Brand</th>
						<?php
							
							$sql = "SELECT * from item where item_ID in ( SELECT item_ID from supplier_item where supplier_ID = ".$supplier_chosen.")";
							
							$result = $conn-> query($sql) or die($conn->error);

							if ($result-> num_rows >0) {
								while ($row = $result-> fetch_assoc()) {
									echo "<tr>
											<td>". $row["item_ID"]."</td>
											<td>". $row["item_Name"]."</td>
											<td>". $row["item_unit"]."</td>
											<td>". $row["item_Brand"]."</td>
											<td><button onclick=\"location.href='editsupplieritem.php?item_ID=".$row['item_ID']."&supplier_ID=".$supplier_chosen."'\">Edit Item</button></td>
											<td><a onclick='return checkdelete()' href='deletesupplieritem.php?item_ID=".$row['item_ID']."&supplier_ID=".$supplier_chosen."'\"><button>Delete Item For This Supplier</a></button></td>
											<td><a onclick='return checkdelete()' href='deleteitemtransactions.php?item_ID=".$row['item_ID']."&supplier_ID=".$supplier_chosen."'\"><button>Delete Item & Transactions</a></button></td>
					
									</tr>";

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
	</body>

</html>