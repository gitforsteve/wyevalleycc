<?PHP
//cSpell:disable
require_once "MyCSV.class.php";
require_once "sfpdf.php";
class PDF extends SFPDF {
  function Header(){
    $this->SetFont("","b",16);
    $this->Cell(0,5,"TINTERN COMMUNITY COUNCIL",0,1,"C");
    $this->SetXY(20, 20);
    $this->SetFont("","",11);
  }
}
$pdf = new PDF;
$pdf->SetLeftMargin(20);
$pdf->SetRightMargin(20);
$pdf->setFont("helvetica","",11);
$pdf->setTextColor(0,0,0);
$councillors = new MyCSV('noemails.csv');
while($row = $councillors->each()){
  $pdf->AddPage();
  $pdf->Ln(10);
  $pdf->Cell(0,5,date('jS F Y'),0,1);
  $pdf->Ln();
  extract($row);
  $pdf->Cell(0,5,$name." ".$surname,0,1);
  $addr = implode("\r\n",explode(",",$address));
  $pdf->MultiCell(0,5,$addr);
  $pdf->Ln(10);
  $nme = explode(" ",$name);
  $pdf->Cell(0,5,"Dear ".$nme[0]);
  $pdf->Ln(10);
  $pdf->setFontWeight("b");
  $pdf->Cell(0,5,"Your Community Council email address",0,0,"C");
  $pdf->setFontWeight("");
  $pdf->Ln(20);
  $pdf->WriteText("As you will cease to be a Councillor on the Tintern Community Council following its replacement on 5th May 2022 you will no longer have access to your TCC email.");
  $pdf->Ln(10);
  $pdf->WriteText("Your email account will be changed to be redirected to that of the Clerk and you are asked to <remove all of the emails> held on your own computer or other devices as soon as possible after the 5th May.");
  $pdf->Ln(20);
  $pdf->MultiCell(0,5,"Best wishes\nSteve\n07879815561");
  $pdf->Ln(10);
  
}

$pdf->OutPut();
?>