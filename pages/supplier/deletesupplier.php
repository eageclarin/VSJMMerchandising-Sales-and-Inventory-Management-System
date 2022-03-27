<?php
if(isset($_GET["supplier_ID"])){
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "VSJM";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));
	$query = "delete from supplier where supplier_ID= ".$_GET["supplier_ID"];
	mysqli_query($conn, $query);
	mysqli_close($conn);
}
header("Location: ./suppliers.php");
exit;
?>
