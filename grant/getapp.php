<?PHP
ini_set('display_errors', 1); 
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
require "fpdf.php";
if(isset($_POST)){
  $orgname = test_input($_POST['orgname']);
  $orgcontact = test_input($_POST['orgcontact']);
  $orgaddress = test_input($_POST['orgaddress']);
  $contactphone = test_input($_POST['contactphone']);
  $contactemail = test_input($_POST['contactemail']);
  $objectives = test_input($_POST['objectives']);
  $howlong = test_input($_POST['howlong']);
  $where = test_input($_POST['where']);
  $project = test_input($_POST['project']);
  $inarea = test_input($_POST['inarea']);
  $notinarea = test_input($_POST['notinarea']);
  $finances = test_input($_POST['finances']);
  $upcoming = test_input($_POST['upcoming']);
  $orgcontact = test_input($_POST['orgcontact']);
  $before = test_input($_POST['before']);
  $cost = test_input($_POST['cost']);
  $howmuch = test_input($_POST['howmuch']);
  $difference = test_input($_POST['difference']);
  $accountname = test_input($_POST['accountname']);
  $accaddress = test_input($_POST['accaddress']);
  // test for pound signs
  if(strpos($cost,'£') !== false){
    $cost = substr($cost,1);
  }
  if(strpos($howmuch,'£') !== false){
    $howmuch = substr($howmuch,1);
  }
}
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image("wvcclogomono.png",95,10,20,20,"png");
$pdf->SetY(30);
$pdf->SetFont('Arial',"",14);
$pdf->Cell(0,5,"WYE VALLEY COMMUNITY COUNCIL",0,1,"C");
$pdf->Cell(0,5,"GRANT FUNDING APPLICATION FORM",0,0,"C");
$pdf->Ln(10);
$pdf->SetFont('','',12);
$pdf->Cell(0,5,"SECTION 1 ORGANISATION CONTACT DETAILS");
$pdf->Ln(10);
$pdf->Cell(80,5,"Name of organisation",1);
//orgname
$pdf->Cell(0,5,$orgname,1,1);
//$pdf->Ln();
//contactname
$pdf->Cell(80,5,"Organisation contact name",1);
$pdf->Cell(0,5,$orgcontact,1,1);
//$pdf->Ln();
//contactaddress
$pdf->Cell(80,5,"Contact address",1);
$pdf->MultiCell(0,5,$orgaddress,1,1);
//$pdf->Ln();
//phone number
$pdf->Cell(80,5,"Daytime phone number",1);
$pdf->Cell(0,5,$contactphone,1,1);
//$pdf->Ln();
//contactemail
$pdf->Cell(80,5,"Contact email address",1);
$pdf->Cell(0,5,$contactemail,1,1);
$pdf->Ln(10);
$pdf->Cell(0,5,"SECTION 2 ORGANISATION ACTIVITY DETAILS");
$pdf->Ln(10);
//contactaddress
$pdf->Cell(80,5,"Organsiation's activities and objectives",1);
$pdf->MultiCell(0,5,$objectives,1,1);
//$pdf->Ln();
//how long
$pdf->Cell(80,5,"How long operating",1);
$pdf->Cell(0,5,$howlong,1,1);
//$pdf->Ln();
//where
$pdf->Cell(80,5,"When and where meetings take place",1);
$pdf->MultiCell(0,5,$where,1);
$pdf->Ln(10);

$pdf->Cell(0,5,"SECTION 3 PROJECT DETAILS");

// project
$pdf->Ln(10);
$pdf->Cell(80,5,"Details of project or item",1);
$pdf->MultiCell(0,5,$project,1,1);
//$pdf->Ln();
//inarea
$pdf->Cell(80,5,"Beneficiaries in Council area",1);
$pdf->MultiCell(0,5,$inarea,1,1);
//notinarea
//$pdf->Ln();
$pdf->Cell(80,5,"Beneficiaries outside Council area",1);
$pdf->MultiCell(0,5,$notinarea,1);
$pdf->Ln(10);

$pdf->Cell(0,5,"SECTION 4 FINANCE");
$pdf->Ln(10);

$pdf->Cell(80,5,"Finance sources and main expenditure",1);
$pdf->MultiCell(0,5,$finances,1,1);
//$pdf->Ln();
$pdf->Cell(80,5,"Upcoming and planned fund raising",1);
$pdf->MultiCell(0,5,$upcoming,1,1);
//$pdf->Ln();

$pdf->Cell(80,5,"Previous application",1);
$pdf->MultiCell(0,5,$before,1,);
//$pdf->Ln();
$pdf->Cell(80,5,"Total costs of project or item",1);
$pdf->MultiCell(0,5,$cost,1,1);

//$pdf->Ln();
$pdf->Cell(80,5,"Amount being requested",1);
$pdf->MultiCell(0,5,$howmuch,1,1);
//$pdf->Ln();

$pdf->Cell(80,5,"Difference raised by",1);
$pdf->MultiCell(0,5,$difference,1,);

//$pdf->Ln();

$pdf->Cell(80,5,"Bank account name",1);
$pdf->Cell(0,5,$accountname,1,1);
//$pdf->Ln();
$pdf->Cell(80,5,"Address for cheque",1);
$pdf->MultiCell(0,5,$accaddress,1);

$pdf->Ln(10);
$pdf->Cell(0,5,"SECTION 5 AGREEMENT");
$pdf->Ln(10);

$pdf->Write(5,"I confirm that the organisation named in section 1 has authorised me to sign this agreement on its behalf. To the best of my knowledge and belief, all of the information provided in this application is true and correct. If this application is successful, in full or in part, both, the organisation and myself agree to keep to the following terms and conditions. I unserstand that this is an agreement between the orhanisation and Wye Valley Community Council.");
$pdf->Ln(10);
$pdf->Cell(0,5,"I/We understand and agree to the following:");
$pdf->Ln(10);
$pdf->Cell(10,5,"1");
$pdf->MultiCell(0,5,"To use the grant awarded for exactly the purpose set out in this application.",0,1);
$pdf->Cell(10,5,"2");
$pdf->MultiCell(0,5,"Not to sell or dispose of anu equipment or assets which were purchased with the grant without the Council's agreement in writing.",0,1);
$pdf->Cell(10,5,"3");
$pdf->MultiCell(0,5,"To acknowledge the contribution of the Council in any publicity materials produced for the project and, where applicable, in our annual report of secretary's report",0,1);
$pdf->Cell(10,5,"4");
$pdf->MultiCell(0,5,"Wye Valley Community Council may use our name and make reference to the purpose for which the grant will be used in its own publicity materials subject to any uissues of confidentiality as advised by us.",0,1);
$pdf->Cell(10,5,"5");
$pdf->MultiCell(0,5,"Should the entire grant not be spent we will promptly return the unspent amount to the Community Council.",0,1);
$pdf->cell(10,5,"6");
$pdf->MultiCell(0,5,"To monitor the success of the project and be prepared to report on it if required by the Council.",0,1);
$pdf->Cell(10,5,"7");
$pdf->MultiCell(0,5,"Where equipment or services are being purchased we will provide copy receipts to the Council.");

$pdf->Ln(20);

$pdf->Cell(0,5,"Signature ...................................................");
$pdf->Ln(20);
$pdf->Cell(0,5,"Name.........................................................");
$pdf->Ln(20);
$pdf->Cell(0,5,"Position.........................................");
$pdf->Ln(20);
$pdf->Cell(0,5,"Date..................................");
$pdf->Ln(20);
$pdf->Cell(0,5,"This document consists of {nb} pages");
$pdf->output();
?>