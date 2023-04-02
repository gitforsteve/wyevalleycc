<?PHP
//cSpell:disable
require "../mc_table.php";
require "../MyCSV.class.php";
$assets = new MyCSV('../data/assets.csv');
$pdf = new PDF_MC_Table();
$pdf->SetWidths([60,100,10,20]);
$pdf->SetAligns(['L','L','C','R']);
$pdf->SetFont("arial","B",11);
$pdf->AddPage();
$pdf->Image('../images/wyevalleylogomono.jpg',90,10,30,0,'JPG');
$pdf->SetY(45);
$pdf->Cell(0,5,"LIST OF ASSETS",0,1,"C");
$pdf->Ln();
$pdf->Row(["Item","Location","Qty","Value"]);
$pdf->SetFont("","");
$total = 0;
while($asset = $assets->each()){
  $pdf->Row([$asset['item'],$asset['location'],$asset['qty'],substr("£",1,1).number_format($asset['value']*$asset['qty'],0,'.',',')]);
  $total += $asset['value']*$asset['qty'];
}
$pdf->Row(["","TOTAL","",substr("£",1,1).number_format($total,0,'.',',')]);
$pdf->Output();
?>