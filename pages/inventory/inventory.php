<?php
include_once '../../env/conn.php';

if (isset($_POST['delete'])) {
  $itemID = $_POST['itemID'];
  $deleteItem = "DELETE FROM inventory WHERE item_ID = '$itemID';";
  $sqlDelete = mysqli_query($conn,$deleteItem);
  if ($sqlDelete) {
    echo "deleted";
  } else {
    echo mysqli_error($conn);
  }
  unset($_SESSION['delete']);
}

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
<!-- ajax -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- jquery -->
     <!--   <script src="jquery-3.5.1.min.js"></script>-->
<script type="text/javascript" src="inventory.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
       


</head>
<body >
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="inventory.php">Inventory</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " href="pending.php">Pending</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " href="items.php">Items</a>
  </li>
  <li class="nav-item active">
    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Others</a>
  </li>
</ul>
<h1> Inventory </h1>

<div class="container-fluid" >
    <label for="sort">Sort by:</label>
    <select name="sort" id="sort" style="height:30px;">
    <option value="ID" selected >ID</option>
    <option value="Category">Category</option>
    <option value="PriceAsc"> <span>&#8593;</span>Price</option>
    <option value="PriceDesc"> <span>&#8595;</span>Price</option>
    <option value="Stocks">Stocks</option>
    <option value="Salability">Salability</option>
    </select>

    <label for="categ">Category:</label>
    <select name="categ" id="categ" style="height:30px;">
    <option value="All" selected >All</option>
    <option value="Arch\'l"> Architectural</option>
    <option value="Elec\'l"> Electrical</option>
    <option value="Plumbing"> Plumbing</option>
    <option value="Tools">Tools</option>
    <option value="Bolts">Bolts and Nuts</option>
    <option value="Paints">Paints and Accessories</option>
    </select>


    <input type="text" id="search" autocomplete="off" placeholder="Search for items, brand, category..." style="height:30px;">
    <button type="button" onclick="location.href='../supplier/suppliers.php'">New Item</button>
  </div>

<div id="display">
    <?php
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
                    echo "<tr class='table-danger'>";
                  
                    //ADDING IN PENDING ORDERS===================================================================
                    if ($row['in_pending']==0) {
                        $_SESSION['pending_ItemID'] = $row['item_ID'];
                        include 'addpending.php';
                    }   // END OF ADDING IN PENDING ORDERS =====================================================
                    
                } else{   //NOT LOW ON STOCK =================================================
                    echo '<tr><form action="inventory.php" class="mb-1" method="post">';
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
                <!--DELETE BUTTON-->
                  <td>
                  
                  <input type=hidden name=itemID value=<?php echo $row['item_ID']?>>
                    <button class="btn-primary" name="delete" type="submit">Delete</button>
                    <a href="editinventory.php"> <button class="btn-primary" name="edit" type="submit">Edit</button></a>
                  
                  </td>
                  </form>
              </tr>
                <?php
            }
        } 

        mysqli_close($conn);
        echo "</table>";
    ?>
</div>
<div id="dummy"></div>
</body>
</html>