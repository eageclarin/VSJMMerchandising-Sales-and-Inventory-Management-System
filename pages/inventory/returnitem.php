<?php
include_once '../../env/conn.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title> Return Items </title>
	<link rel="stylesheet" href="style1.css">
    <script type="text/javascript" src="myjs.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

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
	<main class="h-100">
    <?php include 'navbar.php'; ?>
        
    <div class="container-fluid bg-light p-5">
		<div class="row">
			<div class="col-7">
				<?php
				$sql = "SELECT * FROM return_item;";                                    
				$result = mysqli_query($conn,$sql);
				$resultCheck = mysqli_num_rows($result);
					
				echo "<table> 
						<thead>
						<tr>
							<th> ID </th>
							<th> Returned Quantity </th>
							<th> Reason </th>
						</tr>
						</thead>";

				if ($resultCheck>0){
					while ($row = mysqli_fetch_assoc($result)) {
							echo "
							
							<tr>
							<td>" .$row['item_ID']. "</td>   
							<td>" .$row['item_ReturnedQuan']. "</td>  
							<td>" .$row['item_Reason'] . "</td> 
							</tr>
							";
					}
				}       
				echo "</table>";

				?>
			</div>
			<div class="col bg-white border shadow-sm p-5" style="border-radius: 15px">
			<div class="fs-3 fw-bold text-center"> RETURN ITEM </div>
			<hr>
			<form action = "./returnitem.php" method="post" id="form">
				<div class="form-group row"> 
					<label for="item_ID" class="col-5 col-form-label fw-bold">Item ID:</label>

					<?php
						$sql = "SELECT * FROM item";                                    
						$result = mysqli_query($conn,$sql);
						$resultCheck = mysqli_num_rows($result);
						
						if($resultCheck > 0){
					?>
						<select name="item_ID" id="item" class="col-sm-10 form-select w-25">
					<?php
							while($row = mysqli_fetch_assoc($result)){
					?>
								<option value='<?php echo $row['item_ID'] ?>'>
									<?php echo $row['item_ID'] ?>
								</option>
					<?php
							}
						}
					?>
					</select>
				</div><!-- END OF CATEGORY CONTAINER -->
					
				<div class="form-group row mt-2">
					<label for="item_ReturnedQuan" class="col-5 col-form-label fw-bold">Returned Qty:</label>
					<input type="text" id="item_ReturnedQuan" class="col-sm-10 form-control w-25" autocomplete="off" required>
				</div>
				<div class="form-group row mt-2">
					<label for="item_Reason" class="col-5 col-form-label fw-bold">Reason:</label>
					<select name="item_Reason" id="item_Reason" class="col-sm-10 form-select w-50">
						<option value="Excess quantity" >Excess quantity</option>
						<option value="Item has a defect">Item has a defect</option>
						<option value="Wrong item/s brought"> Wrong item/s bought </option>
					</select>
				</div>
				
				<div class="form-group row">
					<div class="col">
						<input type="submit" name="submit" value="submit" class="btn btn-lg btn-success mt-3 w-100">
					</div>
				</div>
			</form>
			</div>
		</div>
</div>
</main>
</body>
</html>
