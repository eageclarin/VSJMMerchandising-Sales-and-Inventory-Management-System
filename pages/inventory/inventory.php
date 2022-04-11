<?php
error_reporting(0);
include_once '../../env/conn.php';

// Delete an item from the inventory 
if (isset($_POST['delete'])) {
  $itemID = $_POST['itemID'];
  //$deleteItem = "DELETE FROM inventory WHERE branch_ID =1 AND item_ID = '$itemID';";
  $deleteItem = "UPDATE inventory SET inventoryItem_Status = 0 WHERE branch_ID =1 AND item_ID = '$itemID';";
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
/**if(isset($_POST['edit'])){
    $_SESSION['itemID'] = $_POST['itemID'];
    $itemID = $_POST['itemID'];
		//header("Location: ./editinventory.php");
    $showModal  ="true";
    echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#staticBackdrop").modal("show");
			});
		</script>';
    unset($_POST['edit']);
    $showModal = true;
	}**/

?>

<!DOCTYPE html>
<html>
  <head>
    <title> Inventory </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="inventory.js"></script> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
  <script src="assets/js/jquery.js"></script>
    <link rel="stylesheet" href="style.css">
  </head>

  
  <body >
    
  <?php include 'navbar.html'; ?>

    <div id="content">
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Item</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
          <form id="newform" action="editinventory.php" method="post" class="form-inline" > 
            <div class="modal-body mb-2">   
            <input type="hidden"  id="editID" name="editID" placeholder="Enter"> 
              <label for="editID" id="labelID" style="border:0; background-color: transparent; font-size: 1.25em; color:black; font-weight: 500;">Item ID: </label>
             <!-- <input type="text"  id="editID" name="editID" placeholder="Enter" disabled style="border:0; background-color: transparent;padding-left: 5px; font-size: 1.25em; color:black; font-weight: 500;}">-->
             

              <div class="mb-1 mt-1"> 
                <label for="editName" >Item Name: </label>
                <div>
                  <input type="text" class="form-control"  id="editName" name="editName" placeholder="Enter">
                </div> 
                <label for="editUnit" >Item Unit: </label>
                <div>
                  <input type="text" class="form-control"  id="editUnit" name="editUnit" placeholder="Enter">
                </div> 
                <label for="editBrand" >Brand: </label>
                <div>
                  <input type="text" class="form-control"  id="editBrand" name="editBrand" placeholder="Enter">
                </div> 
                <label for="editRetail" >Retail Price: </label>
                <div>
                  <input type="number" step="any" class="form-control"  id="editRetail" name="editRetail" placeholder="Enter">
                </div> 
                <label for="editMarkup" >Markup: </label>
                <div>
                  <input type="number" step="any" class="form-control"  id="editMarkup" name="editMarkup" placeholder="Enter">
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

              </div>

              </div>


              <div class="modal-footer pb-0">
                <input  type="submit" value="update" name="edit" class="form-control btn btn-primary" style="width:150px" > 
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <!--end modal-->


      <h1 style="float:left;"> Inventory </h1>
      
      <div class="card float-right" style="width:400px; float:right;">
        <div class="card-body">
          <h4>Total items: N </h4>
          <h4>Total Value: 10,000.00</h4></div>
      </div>
      <br/> <br/> <br/> <br/> <br/>
    
    <div class="container-fluid" >
        
        <div id="categoryContainer">
          <!-- CHOOSING CATEGORY -->
          <label for="categ">Category:</label>
          <select name="categ" id="categ" style="height:30px;">
            <option value="All" selected >All</option>
            <option value="Architectural"> Architectural</option>
            <option value="Electrical"> Electrical</option>
            <option value="Plumbing"> Plumbing</option>
            <option value="Tools">Tools</option>
            <option value="bolts and nuts">Bolts and Nuts</option>
            <option value="Paints">Paints and Accessories</option>
          </select> <!-- END OF CHOOSING CATEGORY -->
          N items
        </div>
        
        <div id="searchSortContainer">
        <!-- SEARCH TAB -->
        <input type="text" id="search" autocomplete="off" placeholder="Search for items, brand, category..." style="height:30px;">
        
        <!-- SORTING -->
        <label for="sort">Sort by:</label>
        <select name="sort" id="sort" style="height:30px;">
          <option value="ID" selected >ID</option>
          <option value="Category">Category</option>
          <option value="PriceAsc"> <span>&#8593;</span>Price</option>
          <option value="PriceDesc"> <span>&#8595;</span>Price</option>
          <option value="item_Stock">Stocks</option>
          <option value="Salability">Salability</option>
        </select> <!-- END OF SORTING -->
        </div>
      </div>
    
    <!-- DISPLAY LIST OF ITEMS IN INVENTORY -->
    <div id="display">
        <?php
            // SELECT ALL ITEMS FROM INVENTORY ORDER BY ITEM ID
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) WHERE inventoryItem_Status = 1 ORDER BY inventory.item_ID;";   
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
                        <th> modal </th>
                        <th> </th>
                    </tr>";

            if ($resultCheck>0){
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['item_Stock']<=10){ //LOW ON STOCK ======================================
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
                    echo "<td>". $row['item_Name']."</td>";  
                    echo "<td>" .$row['item_unit']. "</td>";  
                    echo "<td>" . $row['item_Brand'] . "</td>";  
                    echo "<td>" . $row['item_RetailPrice']. "</td>"; 
                    echo "<td>" .$row['Item_markup']. "</td>";
                    // echo "<td> <input type=number name=itemStock id='itemStock' min=1 value=" .$row['item_Stock']." style='width:70px;'/> </td>";  
                    echo "<td>" .$row['item_Stock']. "</td>"; 
                    echo "<td>" .$row['item_Category']. "</td>";      
                    ?>
                    <!--DELETE AND EDIT AN ITEM BUTTON-->
                      <td> <button type="button" class="btn btn-success editbtn"> EDIT </button></td>
                      <td>
                        
                      <form action="editinventory.php" class="mb-1" method="post" name="editDelete">
                        <input type=hidden id="itemID" name=itemID value=<?php echo $row['item_ID']?>>
                        <button class="btn-primary" name="delete" type="submit">Delete</button>
                        <button class="btn-primary" name="edit" type="submit">Edit</button>
                       
                        <!--<a href="editinventory.php"> <button class="btn-primary" name="edit" type="submit">Edit</button></a>-->                     
                      </form>
                      
                      </td>
                      

                  </tr>
                    <?php
                } // END OF WHILE($ROW)
            } //END OF RESULTCHECK
            mysqli_close($conn);
            echo "</table>";
          ?>
      </div> <!-- END OF DISPLAY -->

      <p class="float-left"> Legend: --------- </p>
      <!-- ADD NEW ITEM IN INVENTORY BUTTON -->
      <button style="float:right;" type="button" onclick="location.href='../supplier/suppliers.php'">New Item</button>

    </div> <!-- END OF CONTENT -->

         <script>
           $(document).ready(function(){
              $('.editbtn').on('click',function(){
                $('#staticBackdrop').modal('show');
                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#editID').val(data[0]);
                $('#editName').val(data[1]);
                $('#editUnit').val(data[2]);
                $('#editBrand').val(data[3]);
                $('#editRetail').val(data[4]);
                $('#editMarkup').val(data[5]);
                $('#editStock').val(data[6]);
                $('#editCategory').val(data[7]);
                const $select = document.querySelector('#item_Category');
                $select.value = data[7];
                document.getElementById("labelID").innerHTML = "Item ID: " + data[0];
              });
           });
         </script>   

  </body>
</html>
