<?php
$host="localhost";
$user="root";
$password="";
$db="VSJM";

session_start();


$data=mysqli_connect($host,$user,$password,$db);

if($data===false)
{
	die("connection error");
}


if($_SERVER["REQUEST_METHOD"]=="POST")
{
	$user_ID=$_POST["user_ID"];
	$user_pword=$_POST["user_pword"];


	$sql="select * from user where user_ID='".$user_ID."' AND user_pword='".$user_pword."' ";

	$result=mysqli_query($data,$sql);

	$row=mysqli_fetch_array($result);

	if($row !== null && $row["user_pword"]=$user_pword)
	{	

		//$_SESSION["customerID"]=$customerID;
		//$_SESSION['login_time'] = time();
		header("location:index.php");
	}

	else
	{
		echo "username or password incorrect";
	}

}

?>
<!DOCTYPE html>
<html>
<head>
   <script src="myjs.js" type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="logincss.css">
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
</head>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js"></script>


<body>
	<div class = "w-50 mx-auto">
		<img src="img/logo.png" class="rounded mx-auto d-block" width="130"/> 
		<br>
		
	</div>
	<div class="w-50 mx-auto" style="border-radius: 15px">
	
	<div class="fs-3 fw-bold text-center"> LOGIN </div>
		<hr>
		<form action = "#" method="post" id="form">
			<div class="form-group row"> 
				<label for="login_ID" class="col-5 col-form-label fw-bold">Login ID:</label>
				<input type = "text" name = "login_ID" id="login_ID" class="col-sm-5 form-control w-50"  required>
			</div>
			<div class="form-group row mt-2">
				<label for="login_pword" class="col-5 col-form-label fw-bold">Password:</label>
				<input type = "password" name = "login_pword" id="login_pword" class="col-sm-5 form-control w-50"  required>
			</div>
			<div class="form-group row">
				<div class="col">
					<input type="submit" name="submit" value="login" class="btn btn-lg btn-success mt-3 w-100">
				</div>
			</div>
		</form>
		</div>
	</div>
	


	

</body> 
</html>
