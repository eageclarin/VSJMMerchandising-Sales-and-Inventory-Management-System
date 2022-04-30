<?php
  error_reporting(0);
  include_once '../../env/conn.php';

?>

<!DOCTYPE html>
<html>
  <head>
    <title> Suppliers </title>
    <link rel="stylesheet" href="./style.css?ts=<?=time()?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

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
    <main>
      <?php include 'navbar.php'; ?>


    <div class="container-fluid bg-light p-5">
      <div class="row justify-content-md-center">
        <div class="row">
          <div class="col position-relative">
            <div class="text-center fs-1 fw-bold"> SUPPLIERS </div>
          </div>
        </div>
      </div>
      <!-- EDIT MODAL ############################################################################ -->
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Edit Item & Supplier</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> <!-- MODAL-HEADER -->
            
            <form id="newform" action="editsupplieranditem.php" method="post" class="form-inline" > 
              <div class="modal-body mb-2">   

                <!--<input type="hidden"  id="edititemID" name="edititemID" placeholder="Enter"> -->
                <div style="display:flex; flex-direction: row; align-items: center;">
                  <label for="edititemID" style="border:0; background-color: transparent; font-size: 1.35em; color:black; font-weight: 500;">Item ID: </label>
                  <span><input type="text" class="form-control" id="edititemID" name="edititemID" style="font-size: 1.35em; color:black; font-weight: 500;" readonly></span>
                </div>
                <div style="display:flex; flex-direction: row; align-items: center;">
                  <label for="editsupplierID" id="labelsupplierID" style="border:0; background-color: transparent; font-size: 1.35em; color:black; font-weight: 500;">Supplier ID: </label>
                  <span><input type="text" class="form-control" id="editsupplierID" name="editsupplierID" style="font-size: 1.35em; color:black; font-weight: 500;" readonly></span>
                </div>
                <div class="mb-1 mt-1"> 
                  <label for="editName" >Item Name: </label>
                  <div>
                    <input type="text" class="form-control"  id="editName" name="editName" placeholder="Enter">
                  </div> 
                  <label for="editBrand" >Brand: </label>
                  <div>
                    <input type="text" class="form-control"  id="editBrand" name="editBrand" placeholder="Enter">
                  </div> 
                  <label for="editsupplier" >Supplier Name: </label>
                  <div>
                    <input type="text" class="form-control"  id="editsupplier" name="editsupplier" placeholder="Enter">
                  </div> 
                  
                  <label for="editstatus" >Supplier Status: </label>
                  <div>
                    <select name="editstatus" id="editstatus" style="height:30px;" >
                      <option value="1" >Active</option>
                      <option value="0" >Inactive</option>
                    </select>        
                  </div> 
                  <label for="editcostprice">Cost Price: </label>
                  <div>
                    <input type="number" step="any" class="form-control"  id="editcostprice" name="editcostprice" placeholder="Enter">
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

              <form action = "addsupplieritem.php" method="post" id="myForm">
                <div class="mb-1 mt-1">
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

                    
                  <p>
                    Item:
                    <?php
                      $query = "SELECT * from item";
                        $result = mysqli_query($conn,$query);
                        if(mysqli_num_rows($result) > 0){
                          echo "<select id='item_ID' name='item_ID'>";
                            while($row = mysqli_fetch_assoc($result)){
                              echo "<option value='".$row['item_ID']."'>".$row['item_ID']." - ".$row['item_Name']."</option>";
                            }
                            echo "<option value='other'>Other</option>";
                            echo "</select><br>";
                          }
                      
                    ?>
                  </p>

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

                  <p>Item Cost Price:<input type="text" name="supplierItem_CostPrice" class="form-control" placeholder="Enter"></p>

                  
                </div>
                <div class="modal-footer pb-0">
                  <input type="hidden" id="prevpage" name="prevpage" value="supplieritem">
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


      <div id="supplierHead"> 

        <h1 style="float:left;"> Items </h1><br>
          
      <!-- END OF INVENTORY HEAD -->
      
       <!-- <div id="filters">-->
            
          <!-- SEARCH TAB -->
        <div class="row justify-content-md-center">
          <div class="form-group row mt-2 justify-content-md-center">
          <!--<div id="searchSortContainer">-->

            <!-- SORTING -->
            <label for="sort" class="col-auto col-form-label fw-bold">Sort by:</label>
            <select name="sort" id="sort" class="col-sm-10 form-select w-auto">
              <option value="ItemID" selected>Item ID</option>
              <option value="SupplierID">Supplier ID</option>
              <option value="PriceAsc"> <span>&#8593;</span>Price</option>
              <option value="PriceDesc"> <span>&#8595;</span>Price</option>
            </select> <!-- END OF SORTING -->

            <div class="col-5">
              <input type="text" id="search" class="form-control w-100" autocomplete="off" placeholder="Search for Items, Brand, Supplier..." <?php if(isset($_GET['item_Name'])){ echo" value='".$_GET['item_Name']."'";} ?> >
            </div>
            
          <!--</div>--> <!-- END OF SEARCHSORT CONTAINER -->
          </div>
        </div> 
      <!--</div> END OF FILTERS -->
      
        <!-- DISPLAY LIST OF ITEMS IN INVENTORY -->
        <div id="display">
            <?php include 'search_sort_item.php'; ?>
        </div> <!-- END OF DISPLAY -->

        <div id="filters">
          <!-- ADD NEW ITEM IN INVENTORY BUTTON -->
          <button class="btn btn-success additembtn mt-3" type="button" >Add Item/Supplier</button>
        </div>

    </div>
  </div>

  </main><!-- END OF CONTENT -->

         <script>
           $(document).ready(function(){
              $('.editbtn').on('click',function(){
                $('#staticBackdrop').modal('show');
                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#edititemID').val(data[0]);
                $('#editName').val(data[1]);
                $('#editBrand').val(data[2]);
                $('#editsupplierID').val(data[3]);
                $('#editsupplier').val(data[4]);
                $('#editstatus').val(data[5]);
                $('#editcostprice').val(data[6]);


                const $select = document.querySelector('#editstatus');
                $select.value = data[5];
                
                
              });
           });

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

              $("#item_ID").change(function () {
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

            if ($("#item_ID").val() === "other"){
                $("#additem").show();
              }
            else{
                $("#additem").hide();
            }
          }

          //SEARCH AND SORT JS

           function fill(Value) {
              $('#search').val(Value);
              $('#display').hide();
           }


          function edit(){
              $('#staticBackdrop').modal('show');
              alert("hi");
          }


          //CHECK SUPPLIERS FROM THE ITEM LIST IN INVENTORY
          $(window).on('load', function() {
                  var input = $("#search").val();
                  var option = $("#sort").find(":selected").val();
                  sessionStorage.setItem("selectedOption", option);
                  var optionValue = $("#sort").selectedIndex;

                      $.ajax({
                          type: "POST",
                          url: "search_sort_item.php",
                          data: {
                              search: input,
                              selected: option
                          },
                          success: function(data) {
                              $("#display").html(data);
                          }
                      });
          });

          //SEARCH AND SORT BY
          $(document).ready(function(){

              $("#search").keyup(function() {
                  var input = $("#search").val();
                  var option = $("#sort").find(":selected").val();
                  sessionStorage.setItem("selectedOption", option);
                  var optionValue = $("#sort").selectedIndex;

                      $.ajax({
                          type: "POST",
                          url: "search_sort_item.php",
                          data: {
                              search: input,
                              selected: option
                          },
                          success: function(data) {
                              $("#display").html(data);
                          }
                      });

              });

              $("#sort").change(function(){
                  var input = $("#search").val();
                  var option = $("#sort").find(":selected").val();
                  sessionStorage.setItem("selectedOption", option);
                  var optionValue = $("#sort").selectedIndex;
                  $.ajax({
                      type: "POST",
                      url: "search_sort_item.php",
                      data: {
                          search: input,
                          selected: option
                      },
                      success: function(data) { 
                          $("#display").html(data);
                      }
                  });
                  
              });

          });

         </script>   

  </body>
</html>