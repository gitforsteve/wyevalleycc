<?PHP

require 'classes.php';
require 'fpdf.php';
require 'fpdi.php';
$rate = 0.45;
$name = $_POST['name'];
$userid = $_POST['userid'];
$date = $_POST['date'];
$description = $_POST['description'];
$fares = $_POST['fares'];
$farerect = isset($_POST['farerect']);
$parkrect = isset($_POST['parkrect']);
if(!is_numeric($fares)){
  $fares = 0;
}
$miles = $_POST['miles'];
if(!is_numeric($miles)){
  $miles = 0;
}
$parking = $_POST['parking'];
if(!is_numeric($parking)){
  $parking = 0;
}
$accommodation = $_POST['accommodation'];
if(!is_numeric($accommodation)){
  $accommodation = 0;
}
$food = $_POST['food'];
if(!is_numeric($food)){
  $food = 0;
}

$pdf = new FPDI();
$pdf->AddPage();
$pdf->setSourceFile('tccexpensesa4.pdf');
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
if($fares !== 0){
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
if($miles !== 0){
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
if($parking !== 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($parking,2),0,0,'R');
}
// ACCOMMODATION
$pdf->SetXY(165,218);
if($accommodation !== 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($accommodation,2),0,0,'R');
}
// FOOD
$pdf->SetXY(165,228);
if($food !== 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($food,2),0,0,'R');
}
// TOTAL
$total = $fares + ($miles * $rate) + $accomodation + $food+ $parking;
$pdf->SetXY(165,238);
$pdf->Cell(15,5,substr("£",1,1).number_format($total,2),0,0,'R');
// SIGNATURE
$pdf->SetXY(100,252);
$pdf->MultiCell(80,5,"This claim was submitted by the claimant using a personal password in lieu of a physical signature. The claimant has agreed to the statement hereon.");

$pdf->SetTextColor(255);
$pdf->SetFont('','B',16);
$pdf->RotatedText(192,275,"verified userid ".$userid,90);
$pdf->SetTextColor(0);
 $a = explode(' ',$name);
$pdf->Code39(20,283,$userid."-".$a[0],1.0);

$pdf->Output();
?>
