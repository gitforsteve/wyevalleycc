<?PHP
// cSpell:disable
require 'classes.php';
require 'fpdf.php';
require 'fpdi.php';
function test_input($data) {
  $data = trim($data,"£");
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$rate = 0.45;
$name = test_input($_POST['name']);
$date = test_input($_POST['date']);
$description = test_input($_POST['description']);
$farerect = isset($_POST['farerec']);
$parkrect = isset($_POST['parkingrec']);
$accomrect = isset($_POST['accomrec']);
$foodrect = isset($_POST['foodrec']);
$fares = floatval(test_input($_POST['fares']));
$miles = floatval(test_input($_POST['mileage']));
$parking = floatval(test_input($_POST['parking']));
$accommodation = floatval(test_input($_POST['accom']));
$food = floatval(test_input($_POST['food']));
$otherdesc = test_input($_POST['otherdesc']);
$other = floatval(test_input($_POST['other']));
$otherrect = isset($_POST['otherrec']);
$total = $fares + ($miles*$rate) + $parking + $accommodation + $food + $other;
$pdf = new FPDI();
$pdf->AddPage();
$pdf->setSourceFile('wvccexpenses.pdf');
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx);
$pdf->SetFont("Arial","B",10);
// NAME
$pdf->SetXY(70,40);
$pdf->Cell(0,5,$name);
// DATE
$pdf->SetXY(70,54);
$pdf->Cell(0,5,$date);
// DESCRIPTION
$pdf->SetXY(30,75);
$pdf->MultiCell(150,5,$description);
// FARES
$pdf->SetXY(144,130);
if($farerect){
  $pdf->CheckedBox();
}else{
  $pdf->CheckBox();
}
$pdf->SetXY(165,130);
if($fares > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($fares,2),0,0,'R');
}
// MILES
$pdf->SetXY(76,140);
if($miles > 0){
  $pdf->Cell(10,5,$miles);
}
// RATE
$pdf->SetX(144);
$pdf->Cell(10,5,($rate * 100)."p");

// TRAVELCOST
$pdf->SetX(165);
if($miles > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($miles*$rate,2),0,0,'R');
}
// PARKING
$pdf->SetXY(144,150);
if($parkrect){
  $pdf->CheckedBox();
}else{
  $pdf->CheckBox();
}
$pdf->SetFont("Arial","B",10);
$pdf->setXY(165,150);
if($parking > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($parking,2),0,0,'R');
}
// ACCOMMODATION
$pdf->SetXY(165,161);
if($accommodation > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($accommodation,2),0,0,'R');
}
// FOOD
$pdf->SetXY(165,172);
if($food > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($food,2),0,0,'R');
}
// OTHER
$pdf->SetXY(144,185);
if($otherrect){
  $pdf->CheckedBox();
}else{
  $pdf->CheckBox();
}
$pdf->SetXY(30,192);
if($other > 0){
  $pdf->MultiCell(110,5,$otherdesc,0,'L',false);
  $pdf->SetXY(165,202);
  $pdf->Cell(15,5,substr("£",1,1).number_format($other,2),0,0,"R");
}
// TOTAL
$pdf->SetXY(165,229);
$pdf->Cell(15,5,substr("£",1,1).number_format($total,2),0,0,'R');
// SIGNATURE
$pdf->SetXY(100,249);
$pdf->MultiCell(80,5,"By submitting this claim the claimant has agreed to the statement hereon and declares that all amounts claimed were incurred for Council business.");

$pdf->SetTextColor(255);
$pdf->SetFont('','B',16);
$pdf->RotatedText(192,275,"verified userid ".$userid,90);
$pdf->SetTextColor(0);
 $a = explode(' ',$name);
$pdf->Code39(20,283,date('Ymd')."-".$a[0],1.0);

$pdf->Output();
?>

