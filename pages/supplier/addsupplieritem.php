<html>

	<body>
		<?php
		if(isset($_POST['submit'])){	
			$server = "localhost:3306";
			$user = "root";
			$pass = "";
			$db = "VSJM";
			$conn = mysqli_connect($server, $user, $pass, $db);
			if(!$conn) die(mysqli_error($conn));

			$supplier_ID = $_POST['supplier_ID'];
			$item_ID = $_POST['item_ID'];
			$empty=0;

			$sql = "SELECT * from supplier_item where supplier_ID =".$_POST['supplier_ID']." and item_ID =".$_POST['item_ID'];
				$result = $conn-> query($sql) or die($conn->error);
				if ($result-> num_rows >0) {
					$empty=1;
				}
			
			if($empty==0){
				$insert = mysqli_query($conn,"INSERT INTO supplier_item". "(supplier_ID, item_ID)"."VALUES('$supplier_ID', '$item_ID')");
				mysqli_query($conn, $insert);
			}
			
			mysqli_close($conn);
		

			header( "Location: ./suppliertable.php?supplier_ID=".$supplier_ID);
			exit;
		}
		?>
		<div id ="transactionform">

			<h3>Fill the Form</h3>


			<form action = "./addsupplieritem.php" method="post" id="myForm">
				<p>
				

					Supplier:

						<?php
							$server = "localhost:3306";
							$user = "root";
							$pass = "";
							$db = "VSJM";
							$conn = mysqli_connect($server, $user, $pass, $db);
							if(!$conn) die(mysqli_error($conn));

							$supplier_ID=$_GET['supplier_ID'];

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
							mysqli_close($conn);
						?>
					</p>

					<input type="submit" name="submit" value="Confirm" id="submitform">
			</form>
			<?php echo"<button onclick=\"location.href='suppliertable.php?supplier_ID=".$supplier_ID."'\">Back</button>"; ?>
		</div>

	</body>
</html>