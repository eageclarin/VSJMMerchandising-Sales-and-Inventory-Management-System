<!DOCTYPE html>
<html>
  <head>
    <?php
      include_once '../../env/conn.php';

    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <link rel="stylesheet" href="style.css">
  </head>

  
  <body >
    

    <!-- NAV BAR -->
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link text-light" href="../../index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="../inventory/inventory.php">Inventory</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="suppliers.php">Suppliers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="../sales/salesReport.php">Report</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="../order/order.php">Sales</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link disabled text-light" href="#" tabindex="-1" aria-disabled="true">Others</a>
      </li>
    </ul>
    <!-- END OF NAV BAR -->

    <!-- SIDE BAR -->
    <nav class="navbar navbar-expand d-flex flex-column align-item-start" id="sidebar">
      <ul class="navbar-nav d-flex flex-column mt-5 w-100">
          <li class="nav-item w-100">
              <a href="suppliers.php" class="nav-link active text-light pl-4"> <h3>Suppliers</h3> </a>
          </li>
          <div class="dropdown">
            <li class="nav-item w-100">
                <a href="suppliers.php" class="nav-link active text-light pl-4"> Suppliers </a>
            </li>
            <div class="supplierlist">
              <?php

                $querySupplier = "select * from supplier";
                $resultSupplier = mysqli_query($conn,$querySupplier);
                if(mysqli_num_rows($resultSupplier) > 0){
                  while($row = mysqli_fetch_assoc($resultSupplier)){
                    echo"<li class=\"nav-item w-100\">
                      <a href=\"suppliers.php\" class=\"nav-link active text-light pl-4\">".$row['supplier_Name']."</a>
                    </li>";

                  }
                }

              ?>

            </div>
          </div>
          <li class="nav-item w-100">
              <a href="supplieritem.php" class="nav-link active text-light pl-4"> Items </a>
          </li>

        
      </ul>
      <br/><h3 class="text-light" style="float:left;"> Reminders </h3>

    </nav>
    <!-- END OF SIDE BAR -->
</body>
</html>