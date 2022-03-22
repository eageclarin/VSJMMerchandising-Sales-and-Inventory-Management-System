<?php
include_once 'env/conn.php';

//TEST CODE ONLY
$sql = "SELECT * FROM branch;";                                    #check if in customer table
$result = mysqli_query($conn,$sql);
$resultCheck = mysqli_num_rows($result);
$exists = false;                                                     

if ($resultCheck>0){
    while ($row = mysqli_fetch_assoc($result)) {
            $branchName = $row['branch_Name'];      
            $branchAddress = $row['branch_Address'];
            echo $branchName .'<br/>';
            echo $branchAddress;
    }
}       
mysqli_close($conn);


?>