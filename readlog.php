<?PHP
header('X-Robots-Tag: noindex');
$hash = '$2y$10$MiMvBQjAA8ufm44O/2Y9muqU1GN0noSd/d/VCtZwAd4sJ0CXHdFiC';
if(isset($_SERVER['QUERY_STRING'])){
  if(!password_verify($_SERVER['QUERY_STRING'], $hash)){
    exit;
  }
}
require "fpdf.php";
class Msg {
  public $date;
  public $time;
  public $from;
  public $to;
  public $subject;
  function __construct($txt) {
    $l = explode(" ",$txt);
    $this->date = "";
    for($i=0;$i<4;$i++){
      $this->date.= array_shift($l)." ";
    }
    $this->time = array_shift($l);
    $this->from = array_shift($l);
    array_shift($l); // get rid of the word to
    $this->to = array_shift($l);
    array_shift($l); // get rid of re
    $this->subject = "";
    while(count($l)>0){
      $this->subject.=array_shift($l)." ";
    }
  }
}
class PDF extends FPDF {
  function Header(){
    $this->SetFont("Arial",'B',50);
    $this->SetTextColor(240,240,240);
    $this->RotatedText(65,170,"C O N F I D E N T I A L",45);
    $this->SetFont('Arial','b',11);
    $this->SetTextColor(0);
    $this->Cell(0,5,"TINTERN COMMUNITY COUNCIL",0,1,'C');
    $this->Cell(0,5,"Analysing Email Log at ".date('H:i')." on ".date('jS F Y'),0,1,'C');
    $this->Ln();
    $this->SetFont('Arial','',11);
  }
  function Footer(){
    $this->hLine(10, 200, 277);
    $this->SetFont('Arial','',6);
    $this->SetY(-8);
    $this->Cell(0,5,"Analysis of emails received via the web site only");
    $this->Cell(0,5,"Page ".$this->PageNo()." of {nb}",0,0,'R');
  }
}
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->SetDrawColor(0);
    $pdf->AddPage('L');
     $f = fopen('email_log.txt','r');
    while(!feof($f)){
      $lines[] = fgets($f);
    }
    $lines = array_reverse($lines);
    //print_r($lines);
    $messages = array();
    for($c=0;$c<count($lines);$c++){
      $line = $lines[$c];
      if(trim($line)!==''){
	$msg = new Msg($line);
	$messages[] = $msg;
      }
    }
    $w = array('date'=>0,'time'=>0,'from'=>0,'to'=>0,'subject'=>0);
    foreach($messages as $msg){
      if($pdf->GetStringWidth($msg->date)>$w['date']){$w['date']=$pdf->GetStringWidth($msg->date);}
      if($pdf->GetStringWidth($msg->time)>$w['time']){$w['time']=$pdf->GetStringWidth($msg->time);}
      if($pdf->GetStringWidth($msg->from)>$w['from']){$w['from']=$pdf->GetStringWidth($msg->from);}
      if($pdf->GetStringWidth($msg->date)>$w['to']){$w['to']=$pdf->GetStringWidth($msg->to);}
      $w['subject'] = 257 - ($w['date']+$w['time']+$w['from']+$w['to']);
    }
    $pdf->Cell($w['date']+5,5,"Date");
    $pdf->Cell($w['time']+5,5,"Time");
    $pdf->Cell($w['from']+5,5,"From");
    $pdf->Cell($w['to']+5,5,"To");
    $pdf->Cell($w['subject'],5,"Subject",0,1);
    foreach($messages as $msg){
	$pdf->Cell($w['date']+5,6,$msg->date);
	$pdf->Cell($w['time']+5,6,$msg->time);
	$pdf->Cell($w['from']+5,6,$msg->from);
	$pdf->Cell($w['to']+5,6,$msg->to);
	$pdf->Cell($w['subject'],6,$msg->subject,0,1);
    }
    
    $pdf->Output();
    ?>
