<?PHP
ini_set('display_errors', 1); 
define('FDPF_FONTPATH','font');
require_once("fpdf.php");
$pdf=new FPDF();
$pdf->setFont("helvetica","",12);
$pdf->AddPage();
$pdf->Cell(0,5,"HELLO");
$pdf->Output();
?>