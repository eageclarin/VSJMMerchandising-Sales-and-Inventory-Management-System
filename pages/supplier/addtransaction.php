<html>

	<body>
		<?php

			if(isset($_POST['submit']))
			{	
				$db = mysqli_connect("localhost","root","","VSJM");

				if(!$db)
				{
				    die("Connection failed: " . mysqli_connect_error());
				}
			

			    $supplier_ID= $_POST['supplier_ID'];
			    $item_ID= $_POST['item_ID'];
			    $transactionItems_Quantity= $_POST['transactionItems_Quantity'];
			    $transactionItems_CostPrice= $_POST['transactionItems_CostPrice'];
			    $transaction_Date= $_POST['transaction_Date'];
			    $transaction_TotalPrice= $_POST['transaction_TotalPrice'];
			    $transaction_Status = $_POST['transaction_Status'];
			    
			     
			    $transactionItems_TotalPrice = $transactionItems_Quantity * $transactionItems_CostPrice;


			    $insert = mysqli_query($db,"INSERT INTO supplier_transactions". "(supplier_ID, transaction_Date, transaction_Status, transaction_TotalPrice) ". "
						  VALUES('$supplier_ID', '$transaction_Date', '$transaction_Status', '$transaction_TotalPrice')");
						
			    

			    if(!$insert)
			    {
			        echo mysqli_error($db);
			    }
			    else
			    {
			        echo "Supplier transaction records added successfully.";
			    }

			    $transaction_ID = $db->insert_id;

			    mysqli_close($db); 
			    
			    $db1 = mysqli_connect("localhost","root","","VSJM");

				if(!$db1)
				{
				    die("Connection failed: " . mysqli_connect_error());
				}
			  

			    $insert = mysqli_query($db1,"INSERT INTO transaction_items". "(transaction_ID, item_ID, transactionItems_Quantity, transactionItems_CostPrice, transactionItems_TotalPrice) ". "
						  VALUES('$transaction_ID', '$item_ID', '$transactionItems_Quantity', '$transactionItems_CostPrice', '$transactionItems_TotalPrice')");
						
			               
			    if(!$insert)
			    {
			        echo mysqli_error($db1);
			    }
			    else
			    {
			        echo " Transaction item records added successfully.";
			    }

			    mysqli_close($db1); 

			    $db2 = mysqli_connect("localhost","root","","VSJM");

				if(!$db2)
				{
				    die("Connection failed: " . mysqli_connect_error());
				}
			  

			    $insert = mysqli_query($db2,"INSERT INTO supplier_item". "(supplier_ID, item_ID) ". "
						  VALUES('$supplier_ID', '$item_ID')");
						
			   
			    

			    mysqli_close($db2); 

			   
			}
		?>
		<div id ="transactionform">

			<h3>Fill the Form</h3>


			<form action = "./addtransaction.php" method="post" id="myForm">


			<?php
				include_once '../../env/conn.php';
		
				if(isset($_GET['supplier_chosen'])){
					$supplier_ID = $_GET['supplier_chosen'];					
				}else if(isset($_POST['supplier_ID'])){
					$supplier_ID = $_POST['supplier_ID'];
				}else{
					$supplier_ID = 1;
				}
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

										if($row['supplier_ID']==$supplier_ID){
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
										echo "<option value='".$row['item_ID']."'>"
										.$row['item_ID']."</option>";
									}
									echo "</select><br>";
								}
					date_default_timezone_set('Asia/Taipei');
					?>
				</p>
				<p>Item Quantity: <input type="text" name="transactionItems_Quantity"></p>
				<p>Item Cost Price: Php <input type="text" name="transactionItems_CostPrice"></p>
				<p>Transaction Date: <input type="datetime-local" name="transaction_Date" value="<?php date('yyyy-MM-ddThh:mm'); ?>" /></p>
				<p>Transaction Status: <select name="transaction_Status" id="transaction_Status">
					<option value="1">Successful</option>
					<option value="0">Failed</option>
				</select><p>
				<p>Transaction Total Price: Php <input type="text" name="transaction_TotalPrice"><p>


				<input type="hidden" name="transactionItems_TotalPrice" id="transactionItems_TotalPrice" Size="6" readonly>

				<input type="submit" name="submit" value="Confirm" id="submitform">

			</form>
			<?php echo"<button onclick=\"location.href='suppliertable.php?supplier_ID=".$supplier_ID."'\">Back</button>"; ?>

		</div>

	</body>

</html>