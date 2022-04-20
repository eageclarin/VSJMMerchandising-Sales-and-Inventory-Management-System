<!DOCTYPE html>
<html>
<head>
    <title>Add Records in Database</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script type="text/javascript"> 
        $(document).ready(function () {
            toggleFields(); 
            $("#supplier_ID").change(function () {
                toggleFields();
            });

        });
        
        function toggleFields() {
            if ($("#supplier_ID").val() === "other")
            $("#addsupplier").show();
        else
            $("#addsupplier").hide();
        }
    </script>
</head>
<body>

<?php


$db = mysqli_connect("localhost","root","","VSJM");

if(!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}



if(isset($_POST['submit']))
{		
    
    
    $item_Name= $_POST['item_Name'];
    $item_unit= $_POST['item_unit'];
    $item_Brand= $_POST['item_Brand'];
    $supplierItem_CostPrice= $_POST['supplierItem_CostPrice'];

  
    $insert = mysqli_query($db,"INSERT INTO item ". "(item_Name, item_unit, item_Brand) ". "
			  VALUES('$item_Name', '$item_unit', '$item_Brand')");
			
               
    if(!$insert)
    {
        echo mysqli_error();
    }
    else
    {
        echo "Records added successfully.";
    }


    $item_ID = $db->insert_id;

    if($_POST['supplier_ID']=="other"){

        $supplier_Name= $_POST['supplier_Name'];
        $supplier_ContactPerson = $_POST['supplier_ContactPerson'];
        $supplier_ContactNum= $_POST['supplier_ContactNum'];
        $supplier_Address= $_POST['supplier_Address'];

        $insert = mysqli_query($db,"INSERT INTO supplier ". "(supplier_Name, supplier_ContactPerson, supplier_ContactNum, supplier_Address) ". "VALUES('$supplier_Name', '$supplier_ContactPerson', '$supplier_ContactNum', '$supplier_Address')");

        if(!$insert)
        {
            echo mysqli_error();
        }
        else
        {
            echo " Supplier records added successfully.";
        }

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
        echo " Supplier item records added successfully.";
    }
}


?>

<form action="./additem.php" method="post">
    <p>
        Item Name:
        <input type="text" name="item_Name" id="item_Name" required>
    </p> 
    <p>
        Item Unit:
        <input type="text" name="item_unit" id="item_unit" required>
    </p>
    <p>
        Item Brand:
        <input type="text" name="item_Brand" id="item_Brand" required>
    </p> 
    <p>
        Supplier:
        <?php
            $query = "SELECT * from supplier";
            $result = mysqli_query($db,$query);
            if(mysqli_num_rows($result) > 0){
                echo "<select id='supplier_ID' name='supplier_ID'>";
                    while($row = mysqli_fetch_assoc($result)){

                        echo "<option value='".$row['supplier_ID']."'";
                        echo">".$row['supplier_Name']."</option>";                                      
                    }
                echo "<option value='other'>Other</option>";
                echo "</select><br>";
            }
            else{
                echo "<select id='supplier_ID' name='supplier_ID'><option value='other'>Other</option></select><br>";
            }

            mysqli_close($db); // Close connection
        ?>
    </p>
    <div id="addsupplier">
        <p>
            Supplier Name:
            <input type="text" name="supplier_Name" id="supplier_Name">
        </p> 
        <p>
            Supplier Contact Person:
            <input type="text" name="supplier_ContactPerson" id="supplier_ContactPerson">
        </p>
        <p>
            Supplier Contact Number:
            <input type="text" name="supplier_ContactNum" id="supplier_ContactNum">
        </p>  
        <p>
            Supplier Address:
            <input type="text" name="supplier_Address" id="supplier_Address">
        </p>
    </div>

    <p>Item Cost Price: Php <input type="text" name="supplierItem_CostPrice"></p>
    
  
  <input type="submit" name="submit" value="Submit">
  <button type="button" onclick="location.href='./items.php'">Go back </button>
</form>

</body>
</html>

