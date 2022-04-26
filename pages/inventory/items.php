<?php
include_once '../../env/conn.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title> List of Items </title>
    <link rel="stylesheet" href="style.css">
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
    <div class="fs-1 fw-bold text-center"> LIST OF ITEMS </div>
<?php

$sql = "SELECT * FROM item;";                                    
$result = mysqli_query($conn,$sql);
$resultCheck = mysqli_num_rows($result);
       
echo "<div class='table-wrapper mt-5'><table class='table table-hover'> 
        <thead> 
        <tr>
            <th> ID </th>
            <th> Item </th>
            <th> Unit </th>
            <th> Brand </th>
            <th> Category </th>
            <th> </th>
        </tr>
        </thead>
        <tbody>";

if ($resultCheck>0){
    while ($row = mysqli_fetch_assoc($result)) {
            echo "
			<tr>
            <td>" .$row['item_ID']. "</td>  
            <td>". $row['item_Name']. "</td>  
            <td>" .$row['item_unit']. "</td>  
            <td>" .$row['item_Brand'] . "</td> 
            <td>" .$row['item_Category'] . "</td> 
            <td><button type='button' class='btn editbtn pt-0' onclick=\"location.href='edititems.php?item_ID=".$row['item_ID']." ' \"><i class='fas fa-edit'></i></button>
            <button class='btn btn-success' onclick=\"location.href='../supplier/supplieritem.php?item_Name=".$row['item_Name']." ' \">Suppliers</button></td>
			</tr>
			";
    }
}       
mysqli_close($conn);
echo "</tbody></table></div>";

?>
<button class='btn btn-primary p-2 mt-3' type="button" onclick="location.href='./additem.php'">Add Item </button> 
</div>
</main>
</body>
</html>