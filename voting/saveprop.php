<?PHP
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
session_start();

if(!isset($_SESSION['userid']) AND strpos($_SERVER['PHP_SELF'],"index") === false){
  header("location: index.php");
}
include_once "../classes.php";

$proposer = test_input($_POST['proposer']);
$seconder = test_input($_POST['seconder']);
$tdt = strtr(test_input($_POST['date']),'/','-');
$date = date('Y-m-d',strtotime($tdt));
$tdt = strtr(test_input($_POST['closingdate']),'/','-');
$closingdate = date('Y-m-d',strtotime($tdt));
$proposal = test_input($_POST['proposal']);
$vstring = $_SESSION['user'].',';
$vote = isset($_POST['vote']) ? 1 : 0;
if($vote === 0){
  $vstring = "";
}
if($_SESSION['userid'] === '6'){
    $vstring = "";
}
//printf("insert into proposal values (null,'%s','%s','%s','%s','%s',%s,0,0)",$date,$closingdate,$proposal,$proposer,$vstring,$vote);
//exit;
$q = new Database();
$q->query("insert into proposal values (null,:dt,:cldt,:item,:person,:seconder,:voted,:vt,0,0,0)");
$q->bind(':dt',$date);
$q->bind(':cldt',$closingdate);
$q->bind(':item',$proposal);
$q->bind(':person',$proposer);
$q->bind(':seconder',$seconder);
$q->bind(':voted',$vstring);
$q->bind(':vt',$vote);
$q->execute();
echo "Proposal added";
?>