<?php
error_reporting(0);
include_once '../../env/conn.php';

// Delete an item from the inventory 
if (isset($_POST['delete'])) {
  $itemID = $_POST['itemID'];
  $deleteItem = "DELETE FROM inventory WHERE branch_ID =1 AND item_ID = '$itemID';";
  $sqlDelete = mysqli_query($conn,$deleteItem);
  if ($sqlDelete) {
    echo "deleted";
  } else {
    echo mysqli_error($conn);
  }
  // Check for open orders in transactions
  $sql1 = "SELECT * FROM transaction_Items INNER JOIN supplier_transactions ON (transaction_Items.transaction_ID = supplier_transactions.transaction_ID) WHERE transaction_Status = 0 ;";   
  $result1 = mysqli_query($conn,$sql1);
  $resultCheck1 = mysqli_num_rows($result1);
  if ($resultCheck1>0){ 
    while ($row1 = mysqli_fetch_assoc($result1)) {
      $transaction_ID = $row1['transaction_ID'];
      // Delete the flagged item present in all open orders
      $deleteItem = "DELETE FROM transaction_items WHERE transaction_ID = '$transaction_ID' AND item_ID = '$itemID';";
      $sqlDelete = mysqli_query($conn,$deleteItem);

      // Check if open transaction contains no items after deleting the flagged item
      $sql2 = "SELECT * FROM transaction_Items WHERE transaction_ID = '$transaction_ID';";   
      $result2 = mysqli_query($conn,$sql2);
      $resultCheck2 = mysqli_num_rows($result2);
      if ($resultCheck2==0){ // Delete the transaction ID if there are no items
        $deleteItem = "DELETE FROM supplier_transactions WHERE transaction_ID = '$transaction_ID';";
        $sqlDelete = mysqli_query($conn,$deleteItem);
      } // End of deleting transaction
    } // End of checking for open orders
  } // End of delete item functionality
  unset($_SESSION['delete']);
}

// Edit an item from the inventory
if(isset($_POST['edit'])){
    $_SESSION['itemID'] = $_POST['itemID'];
		header("Location: ./editinventory.php");
    unset($_POST['edit']);
	}

?>

<!DOCTYPE html>
<html>
  <head>
    <title> Inventory </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="inventory.js"></script> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>

  
  <body >
    

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
              <a href="transactions.php" class="nav-link text-light pl-4"> All Items </a>
          </li>
          <li clas="nav-item w-100">
              <a href="transactions.php" class="nav-link text-light pl-4"> Returns </a>
          </li>
      </ul>
      <br/><h3 class="text-light" style="float:left;"> Reminders </h3>

    </nav>
    <!-- END OF SIDE BAR -->

    <div id="content">
    <h1> Inventory </h1>
    <div class="container-fluid" >
        <!-- SORTING -->
        <label for="sort">Sort by:</label>
        <select name="sort" id="sort" style="height:30px;">
          <option value="ID" selected >ID</option>
          <option value="Category">Category</option>
          <option value="PriceAsc"> <span>&#8593;</span>Price</option>
          <option value="PriceDesc"> <span>&#8595;</span>Price</option>
          <option value="Stocks">Stocks</option>
          <option value="Salability">Salability</option>
        </select> <!-- END OF SORTING -->
        
        <!-- CHOOSING CATEGORY -->
        <label for="categ">Category:</label>
        <select name="categ" id="categ" style="height:30px;">
          <option value="All" selected >All</option>
          <option value="Architectural"> Architectural</option>
          <option value="Electrical"> Electrical</option>
          <option value="Plumbing"> Plumbing</option>
          <option value="Tools">Tools</option>
          <option value="Bolts">Bolts and Nuts</option>
          <option value="Paints">Paints and Accessories</option>
        </select> <!-- END OF CHOOSING CATEGORY -->

        <!-- SEARCH TAB -->
        <input type="text" id="search" autocomplete="off" placeholder="Search for items, brand, category..." style="height:30px;">
        <!-- ADD NEW ITEM IN INVENTORY BUTTON -->
        <button type="button" onclick="location.href='../supplier/suppliers.php'">New Item</button>
      </div>

    <!-- DISPLAY LIST OF ITEMS IN INVENTORY -->
    <div id="display">
        <?php
            // SELECT ALL ITEMS FROM INVENTORY ORDER BY ITEM ID
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) ORDER BY inventory.item_ID;";   
            $result = mysqli_query($conn,$sql);
            $resultCheck = mysqli_num_rows($result);
                
            echo "<table class='table'> 
                    <tr>
                        <th> ID </th>
                        <th> Item </th>
                        <th> Unit </th>
                        <th> Brand </th>
                        <th> Retail Price </th>
                        <th> Markup </th>
                        <th> Stock </th>
                        <th> Category </th>
                        <th> </th>
                    </tr>";

            if ($resultCheck>0){
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['item_Stock']<=5){ //LOW ON STOCK ======================================
                        echo "<tr class='table-danger'>"; // ROW WILL BE RED
                        //ADDING IN PENDING ORDERS===================================================
                        if ($row['in_pending']==0) { // IF NOT YET IN PENDING ORDERS
                            $_SESSION['pending_ItemID'] = $row['item_ID'];
                            include 'addpending.php';
                        }// END OF ADDING IN PENDING ORDERS =========================================    
                    } else{ //NOT LOW ON STOCK ====================================================
                        echo '<tr>'; // NORMAL ROW
                    }   
                    echo "<td>" .$row['item_ID']. "</td>";  
                    echo "<td>". $row['item_Name']. "</td>";  
                    echo "<td>" .$row['item_unit']. "</td>";  
                    echo "<td>" . $row['item_Brand'] . "</td>";  
                    echo "<td>" . $row['item_RetailPrice']. "</td>"; 
                    echo "<td>" .$row['Item_markup']. "</td>";
                    // echo "<td> <input type=number name=itemStock id='itemStock' min=1 value=" .$row['item_Stock']." style='width:70px;'/> </td>";  
                    echo "<td>" .$row['item_Stock']. "</td>"; 
                    echo "<td>" .$row['item_category']. "</td>";      
                    ?>
                    <!--DELETE AND EDIT AN ITEM BUTTON-->
                      <td>
                      <form action="inventory.php" class="mb-1" method="post">
                        <input type=hidden name=itemID value=<?php echo $row['item_ID']?>>
                        <button class="btn-primary" name="delete" type="submit">Delete</button>
                        <a href="editinventory.php"> <button class="btn-primary" name="edit" type="submit">Edit</button></a>                      
                      </td>
                      </form>
                  </tr>
                    <?php
                } // END OF WHILE($ROW)
            } //END OF RESULTCHECK
            mysqli_close($conn);
            echo "</table>";
          ?>
      </div> <!-- END OF DISPLAY -->
    </div> <!-- END OF CONTENT -->
  </body>
</html>
