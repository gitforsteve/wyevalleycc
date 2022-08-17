<?PHP

require 'classes.php';
require 'fpdf.php';
require 'fpdi.php';
$rate = 0.45;
$name = $_POST['name'];
$date = $_POST['date'];
$description = $_POST['description'];
$farerect = isset($_POST['farerec']);
$parkrect = isset($_POST['parkingrec']);
$accomrect = isset($_POST['accomrec']);
$foodrect = isset($_POST['foodrec']);
$fares = floatval($_POST['fares']);
$miles = floatval($_POST['mileage']);
$parking = floatval($_POST['parking']);
$accommodation = floatval($_POST['accom']);
$food = floatval($_POST['food']);
$total = $fares + ($miles*$rate) + $parking + $accommodation + $food;
$pdf = new FPDI();
$pdf->AddPage();
$pdf->setSourceFile('wvccexpenses.pdf');
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx);
$pdf->SetFont("Arial","B",10);
// NAME
$pdf->SetXY(60,45);
$pdf->Cell(0,5,$name);
// DATE
$pdf->SetXY(60,60);
$pdf->Cell(0,5,$date);
// DESCRIPTION
$pdf->SetXY(35,85);
$pdf->MultiCell(150,5,$description);
// FARES
$pdf->SetXY(144,187);
if($farerect){
  $pdf->CheckedBox();
}else{
  $pdf->CheckBox();
}
$pdf->SetXY(165,187);
if($fares > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($fares,2),0,0,'R');
}
// MILES
$pdf->SetXY(76,197);
if($miles !== 0){
  $pdf->Cell(10,5,$miles);
}
// RATE
$pdf->SetX(144);
if($miles !== 0){
  $pdf->Cell(10,5,($rate * 100)."p");
}
// TRAVELCOST
$pdf->SetX(165);
if($miles > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($miles*$rate,2),0,0,'R');
}
// PARKING
$pdf->SetXY(144,207);
if($parkrect){
  $pdf->CheckedBox();
}else{
  $pdf->CheckBox();
}
$pdf->SetFont("Arial","B",10);
$pdf->setXY(165,207);
if($parking > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($parking,2),0,0,'R');
}
// ACCOMMODATION
$pdf->SetXY(165,218);
if($accommodation > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($accommodation,2),0,0,'R');
}
// FOOD
$pdf->SetXY(165,228);
if($food > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($food,2),0,0,'R');
}
// TOTAL
$pdf->SetXY(165,238);
$pdf->Cell(15,5,substr("£",1,1).number_format($total,2),0,0,'R');
// SIGNATURE
$pdf->SetXY(100,252);
$pdf->MultiCell(80,5,"By submitting this claim the claimant has agreed to the statement hereon and declares that all amounts claimed were incurred for Council business.");

$pdf->SetTextColor(255);
$pdf->SetFont('','B',16);
$pdf->RotatedText(192,275,"verified userid ".$userid,90);
$pdf->SetTextColor(0);
 $a = explode(' ',$name);
$pdf->Code39(20,283,date('Ymd')."-".$a[0],1.0);

$pdf->Output();
?>

