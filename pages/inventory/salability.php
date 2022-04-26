<?php
error_reporting(0);
include_once '../../env/conn.php';
$result = mysqli_query($conn, "SELECT SUM(orderItems_Quantity) as salesnum, SUM(orderItems_TotalPrice) as salesvalue FROM order_items;");
$row = mysqli_fetch_array($result);

$totalItems = $row['salesnum'];
$totalValue = $row['salesvalue'];
?>

<!DOCTYPE html>
<html>
  <head>
    <title> Salability </title>
    <link rel="stylesheet" href="./style.css?ts=<?=time()?>">
    <script type="text/javascript" src="inventory.js"></script>
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

  
  <body >  
    <main class="h-100">
    <?php include 'navbar.php'; ?>
        
    <div class="container-fluid bg-light p-5">
      <!-- EDIT MODAL ############################################################################ -->
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Edit Item</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> <!-- MODAL-HEADER -->
            
            <form id="newform" action="editinventory.php" method="post" class="form-inline" > 
              <div class="modal-body mb-2">   
                <input type="hidden"  id="editID" name="editID" placeholder="Enter"> 
                <label for="editID" id="labelID" style="border:0; background-color: transparent; font-size: 1.25em; color:black; font-weight: 500;">Item ID: </label>
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
                </div> <!-- MB-1 MT-1 -->
              </div> <!-- MODAL-BODY -->
              <div class="modal-footer pb-0">
                  <input  type="submit" value="update" name="edit" class="form-control btn btn-primary" style="width:150px" > 
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div> <!-- MODAL FOOTER -->
            </form>  
          </div> <!-- MODAL-CONTENT -->
        </div> <!-- MODAL-DIALOG -->
      </div> <!-- MODAL-FADE-->
      <!-- EDIT MODAL ############################################################################ -->


      <div id="inventoryHead" class="row"> 
        <div class="col-7">
          <span class="fs-1 fw-bold"> SALABILITY </span>
        </div>
          
        <div class="col-5 py-auto mr-3 align-self-end">
          <div class="p-3 bg-white rounded border rounded shadow-sm ">
            <h5>Total items: <?php echo number_format($totalItems) ?> </h5>
            <h5 class="mb-0">Total Value (in Pesos): <?php echo number_format($totalValue,2) ?></h5>
          </div>
        </div>
      </div> <!-- END OF INVENTORY HEAD -->
      
        <div id="filters" class="row mt-3">
          <!-- CHOOSING CATEGORY -->
          <div id="categoryContainer" class="col-7">
            <div class="form-group row"> 
              <label for="categ1" class="col-auto col-form-label fw-bold">Category:</label>
              <select name="categ1" id="categ1" class="col-sm-10 form-select w-25" onchange="categ()">
                <option value="All" selected >All</option>
                <option value="Architectural"> Architectural</option>
                <option value="Electrical"> Electrical</option>
                <option value="Plumbing"> Plumbing</option>
                <option value="Tools">Tools</option>
                <option value="bolts and nuts">Bolts and Nuts</option>
                <option value="Paints">Paints and Accessories</option>
              </select>

              <label for="sort1" class="col-auto col-form-label fw-bold">Sort by:</label>
              <select name="sort1" id="sort" class="col-sm-10 form-select w-25" onchange="sort()">
                <option value="ID" selected >ID</option>
                <option value="Category">Category</option>
                <option value="PriceAsc"> <span>&#8593;</span>Price</option>
                <option value="PriceDesc"> <span>&#8595;</span>Price</option>
                <option value="item_Stock">Stocks</option>
                <option value="Salability">Salability</option>
              </select> <!-- END OF SORTING -->
            </div>
          </div><!-- END OF CATEGORY CONTAINER -->
            
          <!-- SEARCH TAB -->
          <div id="searchSortContainer" class="col">
            <div class="form-group row">
              <div class="col">
                <input type="text" id="search1" class="form-control w-100" autocomplete="off" onkeyup="search()" placeholder="Search for items, brand, category...">
              </div>
              <!-- SORTING -->
              </div>
          </div>
        </div> <!-- END OF FILTERS -->
      
        <!-- DISPLAY LIST OF ITEMS IN INVENTORY -->
        <div id="display" class="mt-3">
            <?php 
                    // DELETE ITEM FROM INVENTORY
    if (isset($_POST['delete1'])) {
        echo "delete clicked";
        $itemID = $_POST['itemID1'];
        $deleteItem = "UPDATE inventory SET inventoryItem_Status = 0 WHERE branch_ID =1 AND item_ID = '$itemID';";
        $sqlDelete = mysqli_query($conn,$deleteItem);
        if ($sqlDelete) {
          echo "deleted";
        } else {
          echo mysqli_error($conn);
        }
        header("Location: ./inventory.php");
        unset($_SESSION['delete1']);
    }
    // EDIT AN ITEM FROM INVENTORY
    if(isset($_POST['edit'])){
        $_SESSION['itemID'] = $_POST['itemID'];
        header("Location: ./editinventory.php");
        unset($_POST['edit']);
    }
    // SQL QUERIES ==========================================================================================
    // FROM SEARCH TAB
    if (isset($_POST['search1'])) {
        $Name = $_POST['search1'];
        if ($Name!="") {    
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) INNER JOIN (SELECT SUM(orderItems_Quantity) as sales_sum, item_ID as order_itemID FROM order_items GROUP BY item_ID) as orders ON (inventory.item_ID = orders.order_itemID) WHERE (item_Name LIKE '%$Name%' OR item_Brand LIKE '%$Name%' OR item_category LIKE '%$Name%'); ";
        } else {
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) INNER JOIN (SELECT SUM(orderItems_Quantity) as sales_sum, item_ID as order_itemID FROM order_items GROUP BY item_ID) as orders ON (inventory.item_ID = orders.order_itemID) ORDER BY sales_sum DESC;"; 
        
        }
    } 
        
    // FROM CATEGORY  
     else if (isset($_POST['category'])) {
        $category= $_POST['category'];
        echo "<h4> ".$category . "</h4>";
        if ($category=='All') {
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) INNER JOIN (SELECT SUM(orderItems_Quantity) as sales_sum, item_ID as order_itemID FROM order_items GROUP BY item_ID) as orders ON (inventory.item_ID = orders.order_itemID) ORDER BY sales_sum DESC;";
        } else {
            $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) INNER JOIN (SELECT SUM(orderItems_Quantity) as sales_sum, item_ID as order_itemID FROM order_items GROUP BY item_ID) as orders ON (inventory.item_ID = orders.order_itemID) WHERE item_Category = '$category' ORDER BY sales_sum DESC;";
        }
    // DEFAULT: BY ID    
    }  else {
        $sql = "SELECT * FROM item INNER JOIN inventory ON (item.item_ID = inventory.item_ID) INNER JOIN (SELECT SUM(orderItems_Quantity) as sales_sum, item_ID as order_itemID FROM order_items GROUP BY item_ID) as orders ON (inventory.item_ID = orders.order_itemID) ORDER BY sales_sum DESC;"; 
        
    }  
    // END OF SQL QUERIES ==========================================================================================
    
    // SHOW RESULT OF QUERY
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
        
    echo "<div class='table-wrapper'><table class='table table-hover'> 
           <thead> 
            <tr>
                <th> ID </th>
                <th> Item </th>
                <th> Unit </th>
                <th> Brand </th>
                <th> Retail Price </th>
                <th> Markup </th>
                <th> Stock </th>
                <th> Category </th>
                <th> Sales </th>
                ";
                if ($k == "Salability"){
                    echo "<th> Total Sales</th>"; 
                }  
            echo "<th> </th>
                    </tr>
                    </thead>
                     <tbody>";
            
    if ($resultCheck>0){
        while ($row = mysqli_fetch_assoc($result)) {
          if ( $row['inventoryItem_Status']==0) {
                    echo "<tr class = 'table-secondary'>";
                }   
            
                 else if ($row['item_Stock']<=10){ //LOW ON STOCK ======================================
                echo "<tr class='table-danger'>";
                //ADDING IN PENDING ORDERS===================================================================
                //if ($row['in_pending']==0) {
                    $_SESSION['pending_ItemID'] = $row['item_ID'];
                    include 'addpending.php';
               // }   // END OF ADDING IN PENDING ORDERS =====================================================
                } else{   //NOT LOW ON STOCK =================================================
                    echo '<tr>';
                }   

                echo "<td>" .$row['item_ID']. "</td>";  
                echo "<td>". $row['item_Name']. "</td>";  
                echo "<td>" .$row['item_unit']. "</td>";  
                echo "<td>" . $row['item_Brand'] . "</td>";  
                echo "<td>" . $row['item_RetailPrice']. "</td>"; 
                echo "<td>" .$row['Item_markup']. "</td>";
                // echo "<td> <input type=number name=itemStock id='itemStock' min=1 value=" .$row['item_Stock']." style='width:70px;'/> </td>";  
                echo "<td>" .$row['item_Stock']. "</td>"; 
                echo "<td>" .$row['item_Category']. "</td>";  
                echo "<td>" .$row['sales_sum']. "</td>";  
                ?>
                <!--DELETE AND EDIT BUTTON-->
                <td style="width:100px;"> <button type="button" class="btn editbtn" style="float:left;"> <i class='fas fa-edit'></i> </button>
                    <form action="search_sort.php" class="mb-1" method="post">
                        <button class="btn" name="delete1" type="submit" style="float:right; padding-left:0px;" <?php if($row['inventoryItem_Status']==0){echo 'disabled';} ?>><i class='fas fa-trash'></i></button>
                        <input type=hidden name=itemID1 value=<?php echo $row['item_ID']?>>
                        
                    </form>
                </td>    
            </tr>
            
        <?php  
        } // END OF WHILE
    } else {
        echo mysqli_error($conn);
    }// END OF RESULTCHECK
    
    echo "</tbody></table></div>";



                  include 'addpending.php';
                  ?>
        
        </div> <!-- END OF DISPLAY -->

        <div class="mt-2">
          <div style="color:red; float:left;">*Items highlighted are Low on Stocks</div> 
          
        </div>

    </div> <!-- END OF CONTENT -->
  </main>
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

           $('#editMarkup').change(function() {
                var markup = $('#editMarkup').val();
                var retail = $('editRetail').val();
                var costPrice = retail/(1+markup);
                $('#editRetail').val( (costPrice + costPrice*$('#editMarkup').val()).toFixed(1));
            });

            $('#editRetail').keyup(function() {
                var costPrice = <?php echo $item_CostPrice; ?>;
                $('#editMarkup').val(($('editRetail').val() - costPrice)/costPrice);
            });

         </script>   

  </body>
</html>

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