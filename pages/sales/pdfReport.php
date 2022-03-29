<?php
require('fpdf.php');


class PDF extends FPDF{
    function Header(){
        $this->Image('vsjm.png',40,6,30);
        // Arial bold 15
    $this->SetFont('Arial','B',20);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'VSJM Merchandising',50,0,'C');
    $this->SetFont('Arial','B',15);
    $this->Ln(10);
    $this->Cell(190,10,'Sales Report',50,0,'C');
    // Line break
    $this->Ln(20);
        $this->SetFont('Arial','B',8);
        $this->Cell(30,10,'Order Date',0,0);
        $this->Cell(15,10,'Order ID',0,0);
        $this->Cell(15,10,'Item ID',0,0);
        $this->Cell(35,10,'Item Name',0,0);
        $this->Cell(20,10,'Item Unit',0,0);
        $this->Cell(30,10,'Item Brand',0,0);
        $this->Cell(20,10,'Quantity',0,0);
        $this->Cell(40,10,'Order Total',0,1);
        $y = $this->GetY();
        $this->Line(10,40,199,40);
        $this->Line(10,40,10,285);
        $this->Line(199,40,199,285);
        $this->Line(10,285,199,285);
        $this->Line(10,$y,199,$y);
        $this->Line(40,40,40,285);
        $this->Line(55,40,55,285);
        $this->Line(70,40,70,285);
        $this->Line(105,40,105,285);
        $this->Line(125,40,125,285);
        $this->Line(155,40,155,285);
        $this->Line(175,40,175,285);

    }
}


$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);
include "conn.php";

if(isset($_GET['from_date']) && isset($_GET['to_date']))
{
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
    $sql = "SELECT item.item_ID, item.item_Name, item.item_unit, item.item_Brand, order_items.order_ID, order_items.orderItems_Quantity, order_items.orderItems_TotalPrice, orders.order_Date, orders.order_Total 
            FROM item 
            INNER JOIN order_items on order_items.item_ID = item.item_ID 
            INNER JOIN orders on orders.order_ID = order_items.order_ID 
            WHERE orders.order_Date BETWEEN '$from_date' AND '$to_date'";
                                        
    $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0)
        {
            foreach($result as $row)
            {
                
                $y= $pdf ->GetY();
                $pdf->MultiCell(50,5,$row['order_Date'],0,'L');
                $y1=$pdf ->GetY();
                $pdf ->SetY($y);
                $pdf ->Cell(30,5,'');
                $pdf->Cell(15,5,$row['order_ID'],0,0);
                $pdf->Cell(15,5,$row['item_ID'],0,0);
                $pdf->Cell(35,5,$row['item_Name'],0,0);
                $pdf->Cell(20,5,$row['item_unit'],0,0);
                $pdf->Cell(30,5,$row['item_Brand'],0,0);
                $pdf->Cell(20,5,$row['orderItems_Quantity'],0,0);
                $pdf->Cell(40,5,$row['order_Total'],0,1);
                $pdf->Line(10,$y+8,199,$y+8);
                $pdf ->SetY($y1+5);
                
            }  
        }
}
else
{
echo "No Record Found";
}

$pdf->Output();
?>