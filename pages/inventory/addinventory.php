<!DOCTYPE html>
<html>
<head>
  <title>Add Records in Database</title>
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
    $item_RetailPrice= $_POST['item_RetailPrice'];
	$Item_markup= $_POST['Item_markup'];
	$item_Stock= $_POST['item_Stock'];
	$item_category= $_POST['item_category'];
	

    $insert = mysqli_query($db,"INSERT INTO item ". "(item_Name, item_unit,
              item_Brand, item_RetailPrice, Item_markup, item_Stock, item_category) ". "
			  VALUES('$item_Name', '$item_unit', '$item_Brand', '$item_RetailPrice', '$Item_markup', '$item_Stock', '$item_category')");
			
               
    if(!$insert)
    {
        echo mysqli_error();
    }
    else
    {
        echo "Record added successfully.";
    }
}

mysqli_close($db); // Close connection
?>



<form action="./addinventory.php" method="post">
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
        Item Retail Price:
        <input type="text" name="item_RetailPrice" id="item_RetailPrice" required>
    </p>  
	<p>
        Item Markup:
        <input type="text" name="Item_markup" id="Item_markup" required>
    </p>  
	<p>
        Item Stock:
        <input type="text" name="item_Stock" id="item_Stock" required>
    </p>  
	<p>
        Item Category:
        <input type="text" name="item_category" id="item_category" required>
    </p>  
    
   
  
  
  <input type="submit" name="submit" value="Submit">
  <button type="button" onclick="location.href='./inventory.php'">Go back </button>
</form>

</body>
</html>

