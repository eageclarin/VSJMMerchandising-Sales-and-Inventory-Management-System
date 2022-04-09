<?php
include_once '../../env/conn.php';
?>

<!DOCTYPE html>
<html>
<head>
<script src="myjs.js" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<title> List of Items </title>
</head>
<body>
    <!-- NAV BAR -->
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link text-light" href="../../index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" aria-current="page" href="inventory.php">Inventory</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="../supplier/suppliers.php">Suppliers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="../sales/salesReport.php">Report</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="../order/order.php">Sales</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link disabled text-light" href="#" tabindex="-1" aria-disabled="true">Others</a>
      </li>
    </ul>
    <!-- END OF NAV BAR -->

    <!-- SIDE BAR -->
    <nav class="navbar navbar-expand d-flex flex-column align-item-start" id="sidebar">
      <ul class="navbar-nav d-flex flex-column mt-5 w-100">
          <li clas="nav-item w-100">
              <a href="inventory.php" class="nav-link active text-light pl-4"> <h3>Inventory</h3> </a>
          </li>
          <li clas="nav-item w-100">
              <a href="#" class="nav-link active text-light pl-4"> Categories </a>
          </li>
          <li clas="nav-item w-100">
              <a href="#" class="nav-link active text-light pl-4"> Brands </a>
          </li>
          <li clas="nav-item dropdown w-100">
              <a href="#" class="nav-link dropdown-toggle text-light pl-4" id="navbarDropDown" role="button" data-bs-toggle="dropdown" > Pending </a>

              <ul class="dropdown-menu w-100" aria-labelledby="navbarDropdown">
                <li><a href="#" class="dropdown-item text-light pl-4 p-2"> Orders </a> </li>
                <li><a href="#" class="dropdown-item text-light pl-4 p-2"> Deliveries </a> </li>
              </ul>
          </li>

          <li clas="nav-item w-100">
              <a href="transactions.php" class="nav-link text-light pl-4"> Transactions </a>
          </li>
          <li clas="nav-item w-100">
              <a href="#" class="nav-link text-light pl-4"> Low on Stock </a>
          </li>
          <li clas="nav-item w-100">
              <a href="#" class="nav-link text-light pl-4">Salability </a>
          </li>
          <li clas="nav-item w-100">
              <a href="items.php" class="nav-link active text-light pl-4"> All Items </a>
          </li>
          <li clas="nav-item w-100">
              <a href="transactions.php" class="nav-link text-light pl-4"> Returns </a>
          </li>
      </ul>
      <br/><h3 class="text-light" style="float:left;"> Reminders </h3>

    </nav>
    <!-- END OF SIDE BAR -->
    <div id="content">
<h1> List of Items </h1>
<?php

$sql = "SELECT * FROM item;";                                    
$result = mysqli_query($conn,$sql);
$resultCheck = mysqli_num_rows($result);
       
echo "<table> 
        <tr>
            <th> ID </th>
            <th> Item </th>
            <th> Unit </th>
            <th> Brand </th>
        </tr>";

if ($resultCheck>0){
    while ($row = mysqli_fetch_assoc($result)) {
            echo "
			<tr>
            <td>" .$row['item_ID']. "</td>  
            <td>". $row['item_Name']. "</td>  
            <td>" .$row['item_unit']. "</td>  
            <td>" .$row['item_Brand'] . "</td> 
            <td><button class='table-see' onclick=\"location.href='edititems.php?item_ID=".$row['item_ID']." ' \">Edit</button></td>
			</tr>
			";
    }
}       
mysqli_close($conn);
echo "</table>";

?>
<button type="button" onclick="location.href='./additem.php'">Add Item </button> 
</div>
</body>
</html>