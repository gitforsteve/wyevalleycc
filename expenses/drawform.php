<?PHP
// draw claim form
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
//define('FPDF_FONTPATH','/font');
require_once "fpdf.php";
require "classes.php";
function test_input($data) {
  $data = trim($data,"£");
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$rate = 0.45;
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetDrawColor(0,0,0);
$pdf->SetFillColor(230,230,230);
$pdf->RoundedRect(15,25,180,260,5,'F');
$pdf->SetFillColor(255,255,255);
$pdf->RoundedRect(25,30,160,10,2,'F');
$pdf->RoundedRect(25,45,160,10,2,'F');
$pdf->RoundedRect(25,60,160,50,3,'F');
$pdf->RoundedRect(25,115,160,50,3,'F');
$pdf->RoundedRect(25,170,160,32,3,'F');
$pdf->RoundedRect(25,208,160,15,3,'F');
$pdf->RoundedRect(25,230,160,30,3,'F');
$pdf->RoundedRect(25,265,160,15,3,'B');
$pdf->SetFont('Arial','',16);
$pdf->SetXY(10,10);
$pdf->Cell(0,5,"WYE VALLEY COMMUNITY COUNCIL",0,1,'C');
$pdf->SetFont('','b',20);
$pdf->Cell(0,9,"CLAIM FOR REIMBURSEMENT OF EXPENSES",0,0,'C');
$pdf->SetFont('','b',12);
$pdf->SetTextColor(230,230,230);
$pdf->SetXY(25,32);
$pdf->Cell(0,5,"Name",0,0);
$pdf->SetXY(25,47);
$pdf->Cell(0,5,"Date / Date range",0,0);
$pdf->SetXY(25,62);
$pdf->Cell(0,5,"Reason for claim",0,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('','b',10);
$pdf->SetXY(25,118);
$pdf->Cell(65,5,"FARES-COACH, BUS, TRAIN OR TAXI",0,0);
$pdf->SetX(95);
$pdf->SetFont('','',10);
$pdf->Cell(0,5,"Tickets / receipts attached");
$pdf->SetXY(25,128);
$pdf->SetFontWeight('b');
$pdf->Cell(60,5,"USE OF PRIVATE VEHICLE",0,0);
$pdf->SetX($pdf->GetX()+10);
$pdf->SetFontWeight('');
$pdf->Cell(0,5,"miles @ agreed rate of 45p per mile");
$pdf->SetXY(25,138);
$pdf->SetFontWeight('b');
$pdf->Cell(70,5,"PARKING FEES",0,0);
$pdf->SetFontWeight('');
$pdf->Cell(0,5,"Receipts attached");
$pdf->SetXY(25,148);
$pdf->SetFontWeight('b');
$pdf->Cell(70,5,"ACCOMMODATION",0,0);
$pdf->SetXY(25,158);
$pdf->Cell(0,5,"FOOD & DRINK");
$pdf->SetXY(25,173);
$pdf->Cell(70,5,"OTHER EXPENSE");
$pdf->SetFontWeight('');
$pdf->Cell(0,5,"Receipts attached");
$pdf->SetXY(25,213);
$pdf->SetFontWeight('b');
$pdf->Cell(0,5,"TOTAL AMOUNT CLAIMED");
$pdf->SetXY(25,233);
$pdf->SetFontWeight('');
$pdf->MultiCell(65,5,"I certify that the amounts shown were expended while on Wye Valley Community Council business.");
$pdf->SetXY(95,233);
$pdf->Cell(0,5,"SIGNATURE");
$pdf->SetXY(25,270);
$pdf->Cell(90,5,"FOR OFFICE USE ONLY");
$pdf->Cell(0,5,"Cheque Number");
$pdf->Rect(145,267,35,10,'F');
// LINES
$pdf->SetDrawColor(230,230,230);
$pdf->Vline(155,115,108,0,1,0.2,1);
$pdf->Hline(20,125,170,10,4,0.2,1);

// DATA
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


//$name = "Steve Evans":
//$description = "description";
//$farerect = 1;
//$parkrect = 1;
//$accomrect = 1;
//$foodrect = 1;
//$fares = "1";
//$miles = "2";
//$parking = "3";
//$accommodation = "4";
//$food = "5";
//$otherdesc = "Other";
//$otherrect = 1;
//$total = $fares + ($miles*$rate) + $parking + $accommodation + $food + $other;

// NAME
$pdf->SetXY(70,33);
$pdf->Cell(0,5,$name);
// DATE
$pdf->SetXY(70,47);
$pdf->Cell(0,5,$date);
// DESCRIPTION
$pdf->SetXY(30,65);
$pdf->MultiCell(150,5,$description);
// FARES
$pdf->SetXY(144,117);
if($farerect){
  $pdf->CheckedBox();
}else{
  $pdf->CheckBox();
}
$pdf->SetXY(165,117);
if($fares > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($fares,2),0,0,'R');
}
// MILES
$pdf->SetXY(86,128);
if($miles > 0){
  $pdf->Cell(10,5,$miles);
}
// RATE
//$pdf->SetX(144);
//$pdf->Cell(10,5,($rate * 100)."p");

// TRAVELCOST
$pdf->SetX(165);
if($miles > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($miles*$rate,2),0,0,'R');
}
// PARKING
$pdf->SetXY(144,137);
if($parkrect){
  $pdf->CheckedBox();
}else{
  $pdf->CheckBox();
}
$pdf->SetFont("Arial","B",10);
$pdf->setXY(165,137);
if($parking > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($parking,2),0,0,'R');
}
// ACCOMMODATION
$pdf->SetXY(165,147);
if($accommodation > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($accommodation,2),0,0,'R');
}
// FOOD
$pdf->SetXY(165,157);
if($food > 0){
  $pdf->Cell(15,5,substr("£",1,1).number_format($food,2),0,0,'R');
}
// OTHER
$pdf->SetXY(144,173);
if($otherrect){
  $pdf->CheckedBox();
}else{
  $pdf->CheckBox();
}
$pdf->SetXY(30,179);
if($other > 0){
  $pdf->MultiCell(110,5,$otherdesc,0,'L',false);
  $pdf->SetXY(165,173);
  $pdf->Cell(15,5,substr("£",1,1).number_format($other,2),0,0,"R");
}
// TOTAL
$pdf->SetXY(165,214);
$pdf->Cell(15,5,substr("£",1,1).number_format($total,2),0,0,'R');
// SIGNATURE
$pdf->SetXY(100,239);
// remove for non live
//$pdf->MultiCell(80,5,"By submitting this claim the claimant has agreed to the statement hereon and declares that all amounts claimed were incurred for Council business.");

$pdf->SetTextColor(255);
$pdf->SetFont('','B',16);
$pdf->RotatedText(192,275,"verified userid ".$userid,90);
$pdf->SetTextColor(0);
// $a = explode(' ',$name);
//$pdf->Code39(20,286,date('Ymd')."-".$a[0],1.0);

//

$pdf->Output();
?>