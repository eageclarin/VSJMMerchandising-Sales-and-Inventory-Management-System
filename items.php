<?php
include_once '../../env/conn.php';

if(isset($_POST['edit'])>0){
    $name = $_POST['editName'];
    $ID = $_POST['editID'];
    $brand = $_POST['editBrand'];
    $categ = $_POST['item_Category'];
    $unit = $_POST['editUnit'];
    mysqli_query($conn, "UPDATE item set item_Name='$name', item_unit='$unit', item_Brand='$brand', item_Category = '$categ'
    WHERE item_ID = '$ID'");
    echo '<div class="popup" id="flash-msg">
    <div class="overlay"></div>
        <div class="popup-content">
        <i class="bi-check2-square" style="font-size:30px;"></i>
            <p class="title">Successfully Updated!</p>
        </div>
    </div>';
}


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
    <link rel="stylesheet" href="./style.css?ts=<?=time()?>">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  
	<!-- JQUERY/BOOTSTRAP -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 

  
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
                $('#editCategory').val(data[4]);
                const $select = document.querySelector('#item_Category');
                $select.value = data[4];
                document.getElementById("labelID").innerHTML = "Item ID: " + data[0];
            });
        });

    </script> 
</head>
<body>
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
                
                <form id="newform" action="items.php" method="post" class="form-inline" > 
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
                    <input type="hidden" name="url" value="inventory.php">
                    <input  type="submit" value="update" name="edit" class="form-control btn btn-primary" style="width:150px" > 
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> <!-- MODAL FOOTER -->
                </form>  
            </div> <!-- MODAL-CONTENT -->
            </div> <!-- MODAL-DIALOG -->
        </div> <!-- MODAL-FADE-->
        <!-- EDIT MODAL ############################################################################ -->


        <!-- ADD ITEM MODAL ############################################################################ -->

            <div class="modal fade" id="staticBackdropadd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Item to Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> <!-- MODAL-HEADER -->
                    <div class="modal-body mb-2">
                        <div id ="transactionform">

                            <form action = "items.php" method="post" id="myForm">
                                <div class="mb-1 mt-1">

                                    <div id="additem">
                                        <p>
                                            Item Name:
                                            <input type="text" name="item_Name" id="item_Name" class="form-control" placeholder="Enter">
                                        </p> 
                                        <p>
                                            Item Unit:
                                            <input type="text" name="item_unit" id="item_unit" class="form-control" placeholder="Enter">
                                        </p>
                                        <p>
                                            Item Brand:
                                            <input type="text" name="item_Brand" id="item_Brand" class="form-control" placeholder="Enter">
                                        </p>
                                        
                                        Category:
                                        <div>
                                            <select name="item_Category" id="item_Category" style="height:30px;" >
                                              <option value="Electrical" >Electrical</option>
                                              <option value="Plumbing">Plumbing</option>
                                              <option value="Architectural"> Architectural</option>
                                              <option value="Paints">Paints</option>
                                              <option value="bolts and nuts">Bolts and Nuts</option>
                                              <option value="Tools">Tools</option>
                                            </select>        
                                        </div><br>

                                    </div>

                                    <p>
                                

                                    Supplier:

                                        <?php
                                            

                                            if(isset($_GET['supplier_ID'])){
                                                $supplier_ID=$_GET['supplier_ID'];
                                            }

                                            $query = "SELECT * from supplier";
                                                $result = mysqli_query($conn,$query);
                                                if(mysqli_num_rows($result) > 0){
                                                    echo "<select id='supplier_ID' name='supplier_ID'>";
                                                        while($row = mysqli_fetch_assoc($result)){
                                                            echo "<option value='".$row['supplier_ID']."'";

                                                            if(isset($_GET['supplier_ID'])){
                                                                if($row['supplier_ID']==$supplier_ID){
                                                                    echo " selected";
                                                                }
                                                            }

                                                            echo">".$row['supplier_ID']." - ".$row['supplier_Name']."</option>";                                        

                                                        }
                                                        echo "<option value='other'>Other</option>";
                                                        echo "</select><br>";
                                                }
                                        ?>
                                    </p>
                                    <div id="addsupplier">
                                        <p>
                                            Supplier Name:
                                            <input type="text" name="supplier_Name" class="form-control" id="supplier_Name" placeholder="Enter">
                                        </p> 
                                        <p>
                                            Supplier Contact Person:
                                            <input type="text" name="supplier_ContactPerson" class="form-control"id="supplier_ContactPerson" placeholder="Enter">
                                        </p>
                                        <p>
                                            Supplier Contact Number:
                                            <input type="text" name="supplier_ContactNum" class="form-control"id="supplier_ContactNum" placeholder="Enter">
                                        </p>  
                                        <p>
                                            Supplier Address:
                                            <input type="text" name="supplier_Address" class="form-control" id="supplier_Address" placeholder="Enter">
                                        </p>
                                    </div>

                                    <p>Item Cost Price:<input type="number" name="supplierItem_CostPrice" class="form-control" placeholder="Enter"></p>

                                    
                                </div>
                                <div class="modal-footer pb-0">
                                    <input type="hidden" id="prevpage" name="prevpage" value="items">
                                    <input  type="submit" value="Submit" name="Submit" class="form-control btn btn-primary" style="width:150px" >  <!-- INSERT ALERT -->

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div> <!-- MODAL FOOTER -->
                            </form>
                        </div>
                    
                    

                    </div>
                    </form>
                </div>
                </div>
            </div>
            <!-- ADD ITEM MODAL ############################################################################ -->
            

           <!-- ADD ITEM QUERY ############################################################################ -->
            <?php
            $db = mysqli_connect("localhost","root","","VSJM");
            if(!$db)
            {
                die("Connection failed: " . mysqli_connect_error());
            }

            if(isset($_POST['submit']) || isset($_POST['Submit']))
            {		
                
                $item_Name= $_POST['item_Name'];
                $item_unit= $_POST['item_unit'];
                $item_Brand= $_POST['item_Brand'];
                $item_Category= $_POST['item_Category'];

                $supplierItem_CostPrice= $_POST['supplierItem_CostPrice'];

            
                $insert = mysqli_query($db,"INSERT INTO item ". "(item_Name, item_unit, item_Brand, item_Category) ". "
                        VALUES('$item_Name', '$item_unit', '$item_Brand', '$item_Category')");


                $item_ID = $db->insert_id;

                if($_POST['supplier_ID']=="other"){

                    $supplier_Name= $_POST['supplier_Name'];
                    $supplier_ContactPerson = $_POST['supplier_ContactPerson'];
                    $supplier_ContactNum= $_POST['supplier_ContactNum'];
                    $supplier_Address= $_POST['supplier_Address'];

                    $insert = mysqli_query($db,"INSERT INTO supplier ". "(supplier_Name, supplier_ContactPerson, supplier_ContactNum, supplier_Address) ". "VALUES('$supplier_Name', '$supplier_ContactPerson', '$supplier_ContactNum', '$supplier_Address')");
                    $supplier_ID = $db->insert_id;

                }else{
                    $supplier_ID = $_POST['supplier_ID'];
                }

                $insert = mysqli_query($db,"INSERT INTO supplier_item". "(supplier_ID, item_ID, supplierItem_CostPrice)"."VALUES('$supplier_ID', '$item_ID', '$supplierItem_CostPrice')");
                        
                if(!$insert)
                {
                    echo mysqli_error();
                }
                else
                {
                    echo '<div class="popup" id="flash-msg">
                    <div class="overlay"></div>
                        <div class="popup-content">
                        <i class="bi-check2-square" style="font-size:30px;"></i>
                            <p class="title">Successfully Added!</p>
                        </div>
                    </div>';
                }  
            }

        ?>  <!-- ADD ITEM QUERY ############################################################################ -->




<div class="fs-1 fw-bold text-center"> LIST OF ITEMS </div>
<?php

$sql = "SELECT * FROM item;";                                    
$result = mysqli_query($conn,$sql);
$resultCheck = mysqli_num_rows($result);
       
echo "<div class='table-wrapper mt-3'><table class='table table-hover'> 
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
            <td>" .$row['item_Category'] . "</td>";

                //<button type='button' class='btn editbtn pt-0' onclick=\"location.href='edititems.php?item_ID=".$row['item_ID']." ' \"><i class='fas fa-edit'></i></button>
            ?>
            <td>
                <button type="button" class="btn editbtn p-0" style="float:left; padding:5px;">
                <i class='fas fa-edit'></i>
                </button>
            </td>
            <?php    
            echo "<td> <button class='btn p-0' onclick=\"location.href='../supplier/supplieritem.php?item_Name=".$row['item_Name']." ' \"><i class='fas fa-shopping-cart'></i></button> </td>
            </tr>";
    }
}       
mysqli_close($conn);
echo "</tbody></table></div>";

?>
<button class='btn btn-primary additembtn p-2 mt-3' type="button">Add Item </button> 
</div>
</main>

<script>

//ADD ITEM/SUPPLIER MODAL

          $(document).ready(function(){
            $('.additembtn').on('click',function(){
              $('#staticBackdropadd').modal('show');
            });
          });

          $(document).ready(function () {
              toggleFields(); 
              $("#supplier_ID").change(function () {
                  toggleFields();
              });

          });
          
          function toggleFields() {
              if ($("#supplier_ID").val() === "other"){
                $("#addsupplier").show();
              }
            else{
                $("#addsupplier").hide();
            }

          }

          //Notification Modal
			$(document).ready(function () {
			$("#flash-msg").delay(1300).fadeOut("slow");
		});

</script>

</body>
</html>