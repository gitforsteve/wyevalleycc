<?PHP
session_start();
if(!isset($_SESSION['userid']) AND strpos($_SERVER['PHP_SELF'],"index") === false){
    header("location: index.php");
}
include_once "../classes.php";
include_once "../sfpdf.php";
include_once "../mc_table.php";
class PDF extends PDF_MC_Table {
    function Header(){
        $this->SetFont("Arial","",12);
        $this->Cell(0,7,"TINTERN COMMUNITY COUNCIL");
        $this->SetX(10);
        $this->SetWeight("B");
        $this->Cell(0,7,"PROPOSAL LIST",0,0,"C");
        $this->SetWeight("");
        $this->Cell(0,7,"VOTING SYSTEM",0,1,"R");
        $this->hLine(10,$this->GetY(),190,0,1);
        $this->Ln(10);
        $this->SetFont("Arial","",12);
    }
    function Footer(){
        $this->SetXY(10,-15);
        $this->hLine(10,$this->GetY(),190,0,1);
        $this->SetFontSize(10);
        $this->Cell(170,7,"PRODUCED FOR ".strtoupper($_SESSION['user'])." ON ".strtoupper(date('jS F Y',strtotime('today')))." AT ".date('H:i',strtotime('now')));
        $this->Cell(37,7,"PAGE ".$this->PageNo()." of {noofpages}",0,0,"R");
    }
}
$q = new Database("Proposal");
$q->query("select * from proposal");
$q->execute();
$props = $q->resultset();
$q->setClass("Comment");
foreach($props as $prop){
    $q->query("select c.*,u.realname from comment c join user u on c.user = u.userid where c.propid = :id");
    $q->bind(":id",$prop->propid);
    $q->execute();
    $prop->comments = $q->resultset();
}
$pdf = new PDF();
$pdf->AliasNbPages("{noofpages}");
$pdf->SetFont("Arial","",12);
$pdf->SetDrawColorS("#000000");
foreach($props as $prop){
    $pdf->AddPage();
    $pdf->Cell(40,7,"PROPOSAL:");
    $pdf->SetWeight("B");
    $pdf->MultiCell(150,7,$prop->item);
    $pdf->SetWeight("");
    $pdf->Cell(40,7,"PROPOSED BY:");
    $pdf->Cell(160,7,$prop->proposer,0,1);
    $pdf->Cell(40,7,"DATE:");
    $pdf->Cell(0,7,date("jS F Y",strtotime($prop->date)),0,1);
    $pdf->Cell(40,7,"CLOSING DATE:");
    $pdf->Cell(0,7,date("jS F Y",strtotime($prop->closingdate)),0,1);
    $pdf->Cell(40,7,"VOTES FOR:");
    $pdf->Cell(0,7,$prop->agree,0,1);
    $pdf->Cell(40,7,"VOTES AGAINST:");
    $pdf->Cell(0,7,$prop->against,0,1);
    $pdf->Cell(40,7,"ABSTENTIONS:");
    $pdf->Cell(0,7,$prop->abstain,0,1);
    if($prop->withdrawn){
        $pdf->SetWeight("B");
        $pdf->Cell(0,7,"This proposal was withdrawn by the proposer",0,1);
        $pdf->SetWeight("");
    }elseif(strtotime($proposal->closingdate) < strtotime("today")){
        if($prop->agree > $prop->against){
            $pdf->SetWeight("B");
            $pdf->Cell(0,7,"This proposal was CARRIED");
        }
        if($prop->against > $prop->agree){
            $pdf->SetWeight("B");
            $pdf->Cell(0,7,"This proposal was REJECTED");
        }
    }
    $pdf->SetWeight("");
    $pdf->Ln();
    $pdf->hLine(10,$pdf->GetY(),190,0,1);
    $pdf->Ln();
    $pdf->Cell(0,7,"COMMENTS",0,1,"C");
    if(count($prop->comments) === 0){
        $pdf->Cell(0,7,"No comments made",0,1,"C");
    }else{
        $pdf->SetWidths([40,40,110]);
        $pdf->Row(["Date","Councillor","Comment"]);
        foreach($prop->comments as $com){
            $pdf->Row([date("jS F Y",strtotime($com->date)),$com->realname,$com->comment]);
        }
    }
}
$pdf->Output();

?>