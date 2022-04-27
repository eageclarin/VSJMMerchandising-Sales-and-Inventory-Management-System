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
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <!-- NAVBAR <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>-->
    <!--<script src="assets/js/jquery.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>--> 
  </head>

  
  <body >  
    <?php include 'navbar.php'; ?>

    <div id="content">
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


      <div id="supplierHead"> 
        <h1 style="float:left;"> Suppliers </h1><br><br><br>
        <h2 style="float:left;"> Items </h2>
          
      <!-- END OF INVENTORY HEAD -->
      
        <div id="filters" >
            
          <!-- SEARCH TAB -->
          <div id="searchSortContainer">
            <input type="text" id="search" autocomplete="off" placeholder="Search for items, brand, supplier..." <?php if(isset($_GET['item_Name'])){ echo" value='".$_GET['item_Name']."'";} ?> style="height:30px;">
          
            <!-- SORTING -->
            <label for="sort">Sort by:</label>
            <select name="sort" id="sort" style="height:30px;">
              <option value="ItemID" selected>Item ID</option>
              <option value="SupplierID">Supplier ID</option>
              <option value="PriceAsc"> <span>&#8593;</span>Price</option>
              <option value="PriceDesc"> <span>&#8595;</span>Price</option>
            </select> <!-- END OF SORTING -->
          </div> <!-- END OF SEARCHSORT CONTAINER -->
        </div> <!-- END OF FILTERS -->
      
        <!-- DISPLAY LIST OF ITEMS IN INVENTORY -->
        <div id="display">
            <?php include 'search_sort_item.php'; ?>
        
        </div> <!-- END OF DISPLAY -->

        <div id="filters">
          
          <!-- ADD NEW ITEM IN INVENTORY BUTTON -->
          <button class="btn btn-dark"style="float:right;" type="button" onclick="location.href='addsupplieritem.php'">Add Item/Supplier</button>
        </div>

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