<?php
require_once("/../models/scooter.php"); $model = new AdminModelScooter(); 
require ("/../../../classes/Reports/PDFresult.php");

$con = mysql_connect("localhost","root","");
 
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}
 
mysql_select_db("Trotinete", $con);

$query = "SELECT * FROM Trotinete";

$trotinete = mysql_query($query);

$trotineteList=$model->getScooterList();
 
echo "<h1>User Comments</h1>";
$denumiri = array();
$descrieri = array();
/*$iCount=0;
foreach($arr as $trotineteList) {
    $denumiri[$iCount]= $arr['denumire'] ;
    $descrieri[$iCount]=$arr['descriere'];
    $iCount ++;
}         */

$count = count($trotineteList);
for ($i = 0; $i < $count; $i++) {
         $denumiri[$i]=   $trotineteList[$i]['denumire'];
          $descrieri[$i]=   $trotineteList[$i]['caracteristici'];
}


mysql_close($con);



$pdf = new PDF_result();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetY(100);
$pdf->Cell(100, 13, "Stocul de trotinete");
$pdf->SetFont('Arial', '');
$pdf->Cell(250, 13, $_POST['name']);
$pdf->SetFont('Arial', 'B');
$pdf->Cell(50, 13, "Date:");
$pdf->SetFont('Arial', '');
$pdf->Cell(100, 13, date('F j, Y'), 0, 1);
$pdf->SetFont('Arial', 'I');
$pdf->SetX(140);
$pdf->Cell(200, 15, "Data:acum", 0, 2);
$pdf->Cell(200, 15, "Oras:Toate", 0, 2);
$pdf->Cell(200, 15, "Trotinete:inchiriate sau nu", 0, 2);
$pdf->Ln(100);
$array1 = array("tro", "asfds", "aaa", "bbb");
$array2 = array("fsasoo", "baasr", "halaslo", "worasld");
$pdf->Generate_Table($denumiri, $descrieri);
$pdf->Ln(50);
$message = "Stocul de trotinete ";
$pdf->MultiCell(0, 15, $message);
$pdf->SetFont('Arial', 'U', 12);
$pdf->SetTextColor(1, 162, 232);
$pdf->Write(13, "admin@youhack.me", "mailto:example@example.com");
$pdf->Output('trotinete.pdf', 'F');

?>