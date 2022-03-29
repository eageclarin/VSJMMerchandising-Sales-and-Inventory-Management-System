<?php
if(isset($_GET["item_ID"])){
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "VSJM";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));

	$supplier_ID=$_GET['supplier_ID'];

	$query1 = "delete transaction_items, supplier_transactions from transaction_items inner join supplier_transactions on supplier_transactions.transaction_ID=transaction_items.transaction_ID where item_ID= ".$_GET["item_ID"]." and supplier_ID=".$supplier_ID;
	mysqli_query($conn, $query1);


	mysqli_close($conn);
}

header( "Location: ./suppliertable.php?supplier_ID=".$supplier_ID);
exit;
?>
