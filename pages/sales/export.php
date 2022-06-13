<?php 
    include_once '../../env/conn.php';
    $output = '';

    if (isset($_POST['export'])) {

         $output .= "<table>
                            <tr> 
                                <th> Order Date </th>
                                <th> Total Orders </th>
                                <th> Total Items </th>
                                <th> Total Sales </th>
                            </tr>";

        $sql1 = "SELECT sales_Date, COUNT(DISTINCT sales.sales_ID) AS totalOrders, SUM(salesItems_Quantity) AS totalItems, SUM(salesItems_TotalPrice) AS totalSales FROM sales INNER JOIN sales_items ON (sales.sales_ID = sales_items.sales_ID) GROUP BY sales_Date;";   
        $result1 = mysqli_query($conn,$sql1);
        $resultCheck1 = mysqli_num_rows($result1);            
                    
        if ($resultCheck1>0){
            while ($row1 = mysqli_fetch_assoc($result1)) {
                $output .= "<tr>"; 
                $output .= "<td>" .$row1['sales_Date']. "</td>";  
                $output .= "<td>". $row1['totalOrders']. "</td>";  
                $output .= "<td>" .$row1['totalItems']. "</td>";  
                $output .="<td>" . $row1['totalSales'] . "</td>";     
                $output .= "</tr>"; 

            }
        } 
        $output .= "</table>"; 
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=VSJM_Sales@' .date("F_d_Y") .'.xls' );
        echo $output;
        


    } 
?>