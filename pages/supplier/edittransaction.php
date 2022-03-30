<html>
	<head>
		<?php
			include_once '../../env/conn.php';
		?>
	</head>
	<body>
		<?php

			/*$sql = "SELECT * from supplier_transactions INNER JOIN transaction_items on transaction_items.transaction_ID = supplier_transactions.transaction_ID";
			$result = $conn-> query($sql) or die($conn->error);
			*/
			
			if(count($_POST)>0){
			
				$supplier_ID = $_POST['supplier_ID'];
				$transactionItems_TotalPrice = $_POST['transactionItems_Quantity']*$_POST['transactionItems_CostPrice'];
				
				mysqli_query($conn, "UPDATE supplier_transactions set transaction_ID='".$_SESSION['transaction_ID']."', supplier_ID='".$_POST['supplier_ID']."', transaction_Date='".$_POST['transaction_Date']."', transaction_Status='".$_POST['transaction_Status']."', transaction_TotalPrice='".$_POST['transaction_TotalPrice']."' WHERE transaction_ID = '". $_SESSION['transaction_ID']."'") or die( mysqli_error($conn));

				$message = "Supplier transaction record edited successfully. ";
				
				mysqli_query($conn, "UPDATE transaction_items set transaction_ID='".$_SESSION['transaction_ID']."', item_ID='".$_POST['item_ID']."',transactionItems_Quantity='".$_POST['transactionItems_Quantity'] ."',transactionItems_CostPrice='".$_POST['transactionItems_CostPrice']."',
				transactionItems_TotalPrice='".$transactionItems_TotalPrice."' 
				WHERE transaction_ID ='".$_SESSION['transaction_ID']."'") or die( mysqli_error($conn));
				
				$message = "Transaction item record edited successfully.";

				

				unset($_SESSION['transaction_ID']);
				mysqli_close($conn);

				header("Location: ./suppliertable.php?supplier_ID=".$supplier_ID);
				exit();
			}

			$result = mysqli_query($conn, "SELECT * from supplier_transactions INNER JOIN transaction_items on transaction_items.transaction_ID = supplier_transactions.transaction_ID where supplier_transactions.transaction_ID = '". $_GET['transaction_ID'] . "'") or die( mysqli_error($conn));
			$orig=mysqli_fetch_array($result);

		?>
		<div id ="transactionform">
			<form action = "./edittransaction.php" method="post">
			<h3>Fill the Form</h3>
			<?php  
				$_SESSION['transaction_ID'] = $_GET['transaction_ID'];
			?>

				<p>
					Supplier:
					<?php
						$query = "SELECT * from supplier";
							$result = mysqli_query($conn,$query);
							if(mysqli_num_rows($result) > 0){
								echo "<select name='supplier_ID'>";
									while($row = mysqli_fetch_assoc($result)){
										echo "<option value='".$row['supplier_ID']."'";

										if($row['supplier_ID']===$orig['supplier_ID']){
											echo " selected";
										}

										echo">".$row['supplier_Name']."</option>";										

									}
									echo "</select><br>";
							}
					?>
				</p>

				<p>
					Item:
					<?php
						$query = "SELECT * from item";
							$result = mysqli_query($conn,$query);
							if(mysqli_num_rows($result) > 0){
								echo "<select name='item_ID'>";
									while($row = mysqli_fetch_assoc($result)){
										echo "<option value='".$row['item_ID']."'";

										if($row['item_ID']==$orig['item_ID']){ echo " selected";}

										echo">".$row['item_ID']."</option>";
									}
									echo "</select><br>";
								}
					?>
				</p>
				<?php
					echo "<p>Item Quantity: <input type=\"text\" name=\"transactionItems_Quantity\" value='".$orig['transactionItems_Quantity']."'></p>
					<p>Item Cost Price: Php <input type=\"text\" name=\"transactionItems_CostPrice\" value='".$orig['transactionItems_CostPrice']."'></p>";

					echo "<p>Transaction Date: <input type=\"datetime-local\" name=\"transaction_Date\" value='".$orig['transaction_Date']."' /></p>";
					echo"<p>Transaction Status: <select name=\"transaction_Status\" id=\"transaction_Status\">
						<option value=\"1\""; 
						if($orig['transaction_Status']=="1"){
							echo " selected";
						}
					echo ">Successful</option>
						<option value=\"0\"";
						if($orig['transaction_Status']=="0"){
							echo " selected";
						}
					echo ">Failed</option>
					</select></p>";
					echo"<p>Transaction Total Price: Php <input type=\"text\" name=\"transaction_TotalPrice\" value='".$orig['transaction_TotalPrice']."'></p>";
				?>

				<input type="hidden" name="transactionItems_TotalPrice" id="transactionItems_TotalPrice" <?php echo"value='".$orig['transactionItems_TotalPrice']."'"; ?>Size="6" readonly>

				<input type="submit" name="submit" value="Submit" class="button">


			</form>
			<?php echo"<button onclick=\"location.href='suppliertable.php?supplier_ID=".$orig['supplier_ID']."'\">Back</button>"; ?>

		</div>

	</body>

</html>