<?PHP

require 'classes.php';
require 'mc_table.php';

class PDF extends PDF_MC_Table {
  function Footer() {
    $this->SetFont('Arial', '', 8);
    $this->hLine(10, 280, 190);
    $this->SetY(-15);
    $this->Cell(50,5,'TINTERN COMMUNITY COUNCIL');
    $this->SetX(10);
    $this->Cell(0,5,'VERSION 3 22ND MAY 2019',0,0,'C');
    $this->Cell(0,5,'Page '.$this->PageNo(),0,0,'R');
    $this->SetFontSize(12);
  }
  function Header() {
    $this->SetTextColor(230);
    $this->SetFont('Arial','B','60');
    $this->RotatedText(20, 220, "NOT FOR PUBLICATION", 45);
    $this->SetTextColor(0);
    $this->SetFont('Arial','',12);
  }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',16);
$pdf->SetTextColor(0);
$pdf->Cell(0,10,"TINTERN COMMUNITY COUNCIL",0,1,'C');
$pdf->SetTextColor(102,162,204);
$pdf->FontWeight('B');
$pdf->Cell(0,10,"A S S E T   R E P O R T   2 0 1 9",0,1,'C');
$pdf->Ln(10);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',12);
$pdf->Write(5,"This report relates to the physical assessment of the condition of the assets and, where relevant, of the likelihood of injury to any person or damage to the reputation of the Council caused by or attributed to the assets of the Council.\n\nScores are given to each of the assets based on the likelihood of such damage occurring and the severity of the resulting issues. These values are then multiplied to yield an overall risk factor for the asset.\n\nIn depth consideration is given to those assets scoring more than six points as a result of the above calculation while a summary of those upon which a lower score has been assigned is given later.\n\nNote that the asset ID relates to the record number on the database.\n\nAssessment carried on on 17th May 2019\by Cllr Evans and the Clerk to the Council");
$pdf->Ln(10);
$pdf->SetTextColor(102,162,204);
$pdf->FontWeight('B');
$pdf->Cell(0,5,"ASSETS WITH AN ASSESSMENT GREATER THAN FIVE",0,1);
$pdf->Ln(10);
$pdf->SetTextColor(0);
$pdf->FontWeight();
$pdf->SetDrawColor(150);
// GET ASSETS
$q = new Database();
$q->query("select *, r.severity*r.likelihood as score from asset a join assetrisk r on a.assetid=r.assetid where r.severity * r.likelihood > 5");
$q->execute();
$assets = $q->resultset();

$pdf->SetWidths(array(10,50,115,15));
$pdf->SetAligns(array('L','L','L','C'));
$pdf->Row(array('ID','Asset and Location','Issue','Score'));
foreach($assets as $asset){
  $pdf->Row(array($asset['assetid'],$asset['item']." ".$asset['location'],$asset['risk'],$asset['score']));
}
$pdf->Ln(10);
$pdf->SetTextColor(102,162,204);
$pdf->FontWeight('B');
$pdf->Cell(0,5,"ASSETS WITH AN ASSESSMENT UNDER 5",0,1);
$pdf->Ln(10);
$pdf->SetTextColor(0);
$pdf->FontWeight();

$q->query("select *, r.severity*r.likelihood as score from asset a join assetrisk r on a.assetid=r.assetid where r.severity * r.likelihood <= 5");
$q->execute();
$assets = $q->resultset();

$pdf->SetWidths(array(10,50,115,15));
$pdf->SetAligns(array('L','L','L','C'));
$pdf->Row(array('ID','Asset and Location','Issue','Score'));
foreach($assets as $asset){
  $pdf->Row(array($asset['assetid'],$asset['item']." ".$asset['location'],$asset['risk'],$asset['score']));
}
$pdf->Ln();
$pdf->Write(5,"Note that all other assets were considered to have an insignificant likelihood of causing injury or damage.");
$pdf->Ln(10);
$pdf->Write(5,"The following page lists all assets together with their value and the total for each based on the quantity and unit value.\n\nAll values given are the estimated replacement values for the asset based on the last purchase.");

$pdf->AddPage();
$pdf->SetTextColor(102,162,204);
$pdf->FontWeight('B');
$pdf->Cell(0,5,"ASSET VALUES",0,1);
$pdf->Ln();
$pdf->SetTextColor(0);
$pdf->FontWeight();
$pdf->SetFontSize(10);
$total = 0.00;

$q->query("select *, qty*value as price from asset order by item, location");
$q->execute();
$assets = $q->resultset();
$pdf->SetWidths(array(10,55,55,10,30,30));
$pdf->SetAligns(array('','','','C','R','R'));
$pdf->Row(array('ID','Item','Location','Qty','Each','Value'));
foreach($assets as $asset){
  if($asset['value'] > 0){
    $assetvalue = substr('£',1,1).number_format($asset['value'],2,'.',',');
    $assetprice = substr('£',1,1).number_format($asset['price'],2,'.',',');
  }else{
    $assetvalue = $assetprice = "0";
  }
  $pdf->Row(array($asset['assetid'],$asset['item'],$asset['location'],$asset['qty'],$assetvalue,$assetprice));  
  $total += $asset['price'];
}
$pdf->Row(array('','','','','TOTAL',substr('£',1,1).number_format($total,2,'.',',')));
$pdf->SetDrawColor(0);

$pdf->output();
?>
