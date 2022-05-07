<?PHP
//cSpell:disable
require_once "MyCSV.class.php";
require_once "../sfpdf.php";
class PDF extends SFPDF {
  function Header(){
    $this->Image('../images/wyevalleylogomono.jpg',90,10,20,0,'jpg');
    $this->SetXY(20, 20);
  }
  function Footer(){
    $this->SetY(-10);
    $this->SetFontSize(8);
    $this->Cell(0,5,"WYE VALLEY COMMUNITY COUNCIL",0,0,"C");
    $this->SetFontSize(11);
  }
}
function describe($pw){
  $trans = array("A"=>"upper case a","B"=>"upper case B","C"=>"upper case C","D"=>"upper case D","E"=>"upper case E","F"=>"upper case F","G"=>"upper case G","H"=>"upper case H","I"=>"upper case I","J"=>"upper case J","K"=>"upper case K","L"=>"upper case L","M"=>"upper case M","N"=>"upper case N","O"=>"upper case O","P"=>"upper case P","Q"=>"upper case Q","R"=>"upper case R","S"=>"upper case S","T"=>"upper case T","U"=>"upper case U","V"=>"upper case V","W"=>"upper case W","X"=>"upper case X","Y"=>"upper case Y","Z"=>"upper case Z","a"=>"lower case A","b"=>"lower case B","c"=>"lower case C","d"=>"lower case D","e"=>"lower case E","f"=>"lower case F","g"=>"lower case G","h"=>"lower case H","i"=>"lower case I","j"=>"lower case J","k"=>"lower case K","l"=>"lower case L","m"=>"lower case M","n"=>"lower case N","o"=>"lower case O","p"=>"lower case P","q"=>"lower case Q","r"=>"lower case R","s"=>"lower case S","t"=>"lower case T","u"=>"lower case U","v"=>"lower case V","w"=>"lower case W","x"=>"lower case X","y"=>"lower case Y","z"=>"lower case Z","0"=>"zero","1"=>"one","2"=>"two","3"=>"three","4"=>"four","5"=>"five","6"=>"six","7"=>"seven","8"=>"eight","9"=>"nine","!"=>"exclamation mark","_"=>"underscore");
  $s = "";
  $chars = str_split($pw);
  foreach($chars as $char){
    $s .= $trans[$char] . ", ";
  }
  return $s;
}
$pdf = new PDF;
$pdf->SetLeftMargin(20);
$pdf->SetRightMargin(20);
$pdf->setFont("helvetica","",11);
$pdf->setTextColor(0,0,0);
$councillors = new MyCSV('emails.csv');
while($row = $councillors->each()){
  if($row['ward'] > "0"){
    $pdf->AddPage();
    $pdf->Ln(10);
    $pdf->Cell(0,5,date('jS F Y'),0,1);
    $pdf->Ln();
    extract($row);
    $pdf->Cell(0,5,$name,0,1);
    $addr = implode("\r\n",explode(",",$address));
    $pdf->MultiCell(0,5,$addr);
    $pdf->Ln(10);
    $nme = explode(" ",$name);
    $pdf->Cell(0,5,"Dear ".$nme[0]);
    $pdf->Ln(10);
    $pdf->setFontWeight("b");
    $pdf->Cell(0,5,"Your new Community Council email address",0,0,"C");
    $pdf->setFontWeight("");
    $pdf->Ln(10);
    $pdf->MultiCell(0,5,"As a Councillor in the ".$ward." Ward of the new Wye Valley Community Council you have been assigned a new email address on the hosting site of wyevalleycc.co.uk. In the interest of confidentiality and security you should not use any other email address for Council business.");
    $pdf->Ln();
    $pdf->SetLeftMargin(50);
    //$pdf->setFontWeight("b");
    $pdf->WriteText("Your email address is <".$email."@wyevalleycc.co.uk>");
    $pdf->Ln();
    $pdf->WriteText("Your password has been set as <".$password.">");
    $pdf->Ln();
    $d = describe($password);
    $d = substr($d,0,-2);
    $pdf->SetFont('','i',10);
    $pdf->MultiCell(0,5,"(".$d.")");
    $pdf->SetFont('','',12);
    $pdf->SetLeftMargin(20);
    $pdf->Ln();
    $pdf->WriteText("Your email account has a fixed limit of 2gb storage <which includes inbox, sent, deleted and junk> and you should monitor your usage and empty the deleted box often to ensure that you do not exceed this allowance or you will not be able to receive important emails. I can help if you are unsure how you can use local folders (on an email client such as Thunderbird which is free and which I highly recommend for its ease of use) to store emails.");
    $pdf->Ln(10);
    $pdf->WriteText("You will be able to access your email either through the web mail page <mail.ionos.co.uk> or, preferably, set up an email client on your computer, tablet or phone. This latter method makes maintaining your account much simpler. The settings are given below and, again, help is available if required.");
    $pdf->Ln(10);
    $pdf->SetLeftMargin(70);
    $pdf->WriteText("The method used is <IMAP>, not POP\nIncoming server <imap.1and1.co.uk>\nPort <993>\nProtocol <SSL/TLS>\n\nOutgoing server <auth.smtp.1and1.co.uk>\nPort <587>\nNormal password",0,"C");
    $pdf->SetLeftMargin(20);
    $pdf->Ln(10);
    //$pdf->Image('images/signature.jpg',20,242,75);
    //$pdf->Ln(20);
    $pdf->MultiCell(0,5,"Best wishes\nSteve\n07879815561");
    $pdf->Ln(10);
    $pdf->SetFontSize(8);
    $pdf->Cell(0,5,"Further information about your email system is overleaf.");
    $pdf->SetFontSize(11);
    $pdf->AddPage();
    $pdf->SetY(40);
    $pdf->setFontWeight('b');
    $pdf->Cell(0,5,"ABOUT THE WYEVALLEYCC EMAIL SYSTEM",0,0,"C");
    $pdf->SetFontWeight('');
    $pdf->Ln(10);
    $pdf->Cell(0,5,$name,0,1);
    $pdf->Ln(10);
    $pdf->WriteText("<The hosting package>");
    $pdf->Ln(10);
    $pdf->WriteText("Our web site is hosted by a company in Europe, subject to the GDPR regulations. Our emails are held on a secure server and each email address is limited to a fixed storage of 2gb with a warning email received by the administrator (that's me) if any address nears this limit.");
    $pdf->Ln(10);
    $pdf->WriteText("Try not to increase the storage unnecessarily by sending large emails or attachments to all other Councillors. Please check the distribution list on the email and only send a copy if the Councillor has <not> already received it. Before sending an email to every Councillor please consider if he or she really needs to see it. This will make your maintenance of your emails much easier.");
    $pdf->Ln(10);
    $pdf->WriteText("<Security of our email addresses>");
    $pdf->Ln(10);
    $pdf->WriteText("Our email address are never published on our web site and a site visitor is required to contact a Councillor, in the first instance, via the form provided on the site. This form requires the sender to confirm that they are not a robot (a computer program designed to scan and send emails to addresses) before the message is sent. Messages sent via this form are <automatically> copied to the Clerk in case of illness or holiday.");
    $pdf->Ln(10);
    $pdf->WriteText("Of course, once correspondence starts then email are exchanged outside of the site and this does tend to 'release' the address into the wild. We have had some instances of phishing attempts even through the web site so care <must> be taken when opening emails and a link in an email, no matter how genuine it may seem, must <never> be clicked until it has been thoroughly checked. Check for incorrect English, mis-spelling and the address where the email is supposed to come from. Right click a link and check the address. It might say Lloydsbanl.com at the start but check further to see what follows (and if you read Lloydsbank above look again).");
    $pdf->Ln(10);
    $pdf->WriteText("If you have <any> doubt about an email please give me a call and I can explain the checks which you can carry out. There is even a utility on our host's site which will allow a check of a saved email which appears to come from our host (IONOS). This is https://phishing-contact.ionos.co.uk");
    $pdf->Ln(10);
    $pdf->WriteText("<Never use your wyevallycc email address for anything other than Council business including using it to sign up to any on-line services or social media.>");
    $pdf->Ln(20);
    $pdf->WriteText("All this will make <my> job easier and protect you from anything nasty");
  }
}
$pdf->OutPut();
?>