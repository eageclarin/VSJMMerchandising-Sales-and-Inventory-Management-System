<?php
    error_reporting(0);
    include_once '../../env/conn.php';
    
    // DELETE ITEM FROM SUPPLIER ITEM
    if (isset($_POST['delete1'])) {
        echo "delete clicked";
        $itemID = $_POST['itemID1'];
        $supplierID = $_POST['supplierID1'];
        $deleteItem = "delete from supplier_item where item_ID= ".$itemID." and supplier_ID=".$supplierID.";";
        $sqlDelete = mysqli_query($conn,$deleteItem);
        if ($sqlDelete) {
          echo "deleted";
        } else {
          echo mysqli_error($conn);
        }
        header("Location: ./supplieritem.php");
        unset($_SESSION['delete1']);
    }
    // EDIT AN ITEM FROM SUPPLIER ITEM
    if(isset($_POST['edit'])){

        $_SESSION['itemID'] = $_POST['edititemID'];
        $_SESSION['supplierID'] = $_POST['editsupplierID'];

        header("Location: ./editsupplieranditem.php");
        unset($_POST['edit']);
    }
    // SQL QUERIES ==========================================================================================
    // FROM SEARCH TAB
    if (isset($_POST['search']) && !isset($_POST['selected'])) {
        $Name = $_POST['search'];

        if ($Name!="") {    
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) WHERE (item_Name LIKE '%$Name%' OR item_Brand LIKE '%$Name%' OR supplier_Name LIKE '%$Name%'); ";
        } else {
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) ORDER BY item.item_ID;";  
        }
    // FROM SORT
    } else if (isset($_POST['selected']) && !isset($_POST['search'])) {
        $k = $_POST['selected'];
        $_SESSION['option'] = $_POST['selected'];
        
        if ($k == "PriceAsc") {
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) ORDER BY supplier_item.supplierItem_CostPrice ASC;";
        } else if ($k == "PriceDesc") {
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) ORDER BY supplier_item.supplierItem_CostPrice DESC;"; 
        } else if ($k == "ItemID"){
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) ORDER BY item.item_ID ;";
        } else if ($k == "SupplierID"){
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) ORDER BY supplier.supplier_ID ;";
        } else {
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) ORDER BY item.item_ID ;";
        }

        
    }  
    else if (isset($_POST['selected']) && isset($_POST['search'])) {
        $Name = $_POST['search'];
        $k = $_POST['selected'];
        $_SESSION['option'] = $_POST['selected'];
        
        if ($k == "PriceAsc") {
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) WHERE (item_Name LIKE '%$Name%' OR item_Brand LIKE '%$Name%' OR supplier_Name LIKE '%$Name%') ORDER BY supplier_item.supplierItem_CostPrice ASC;";
        } else if ($k == "PriceDesc") {
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) WHERE (item_Name LIKE '%$Name%' OR item_Brand LIKE '%$Name%' OR supplier_Name LIKE '%$Name%') ORDER BY supplier_item.supplierItem_CostPrice DESC;"; 
        } else if ($k == "ItemID"){
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) WHERE (item_Name LIKE '%$Name%' OR item_Brand LIKE '%$Name%' OR supplier_Name LIKE '%$Name%') ORDER BY item.item_ID ;";
        } else if ($k == "SupplierID"){
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) WHERE (item_Name LIKE '%$Name%' OR item_Brand LIKE '%$Name%' OR supplier_Name LIKE '%$Name%') ORDER BY supplier.supplier_ID ;";
        } else {
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) WHERE (item_Name LIKE '%$Name%' OR item_Brand LIKE '%$Name%' OR supplier_Name LIKE '%$Name%') ORDER BY item.item_ID ;";
        }

    }   // DEFAULT: BY ID
    else {
            $sql = "SELECT * FROM supplier_item INNER JOIN item ON (item.item_ID = supplier_item.item_ID) INNER JOIN supplier ON (supplier_item.supplier_ID = supplier.supplier_ID) ORDER BY item.item_ID ;"; 
    }  
    // END OF SQL QUERIES ==========================================================================================
    
    // SHOW RESULT OF QUERY
    $result = mysqli_query($conn,$sql) or die($conn->error);
    $resultCheck = mysqli_num_rows($result);
        
    echo "<html><div class='table-wrapper'><table class='table table-hover'> 
           <thead> 
            <tr>
                <th> Item ID </th>
                <th> Item </th>
                <th> Brand </th>
                <th> Supplier ID </th>
                <th> Supplier </th>
                <th> Supplier Status </th>
                <th> Cost Price </th>
                ";

            echo "<th> </th>
                    </tr>
                    </thead>
                     <tbody>";
            
    if ($resultCheck>0){
        while ($row = mysqli_fetch_assoc($result)) {

                echo "<td>" .$row['item_ID']. "</td>";  
                echo "<td>". $row['item_Name']. "</td>";  
                echo "<td>" . $row['item_Brand'] . "</td>";  
                echo "<td>" . $row['supplier_ID']. "</td>"; 
                echo "<td>" . $row['supplier_Name']. "</td>";
                if($row['supplier_Status']==1){
                    $status="Active";
                }else{
                    $status="Inactive";
                }
                echo "<td>" .$status. "</td>"; 
                echo "<td>" .$row['supplierItem_CostPrice']. "</td>"; 

                ?>
                <!--DELETE AND EDIT BUTTON-->
                <td style="width:100px;"> <button type="button" class="btn editbtn" style="float:left;"> <i class='fas fa-edit'></i> </button>
                    <form action="search_sort_item.php" class="mb-1" method="post">
                        <button class="btn" onclick='return checkdelete()' name="delete1" type="submit" style="float:right; padding-left:0px;"><i class='fas fa-trash'></i></button>
                        <input type=hidden name=itemID1 value=<?php echo $row['item_ID']?>>
                        <input type=hidden name=supplierID1 value=<?php echo $row['supplier_ID']?>>
                        
                    </form>
                </td>    
            </tr>
            
        <?php  
        } // END OF WHILE
    } // END OF RESULTCHECK
    
    echo "</tbody></table></div>";
?>

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

            function checkdelete(){
                return confirm('Are you sure you want to delete this record?');
            }

         </script></html>
