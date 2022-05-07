<?PHP
session_start();
if(!isset($_SESSION['userid']) AND strpos($_SERVER['PHP_SELF'],"index") === false){
    header("location: index.php");
}
include_once "../classes.php";
$id = $_POST['propid'];
$user = $_SESSION['userid'];
$vote = $_POST['vote'];
switch($vote){
    case 'agree':
        $add = " agree = agree + 1"; break;
    case 'against':
        $add = "against = against + 1"; break;
    case 'abstain':
        $add = "abstain = abstain + 1"; break;
}
$vstring = $user.",";
$q = new Database();
$sql = "update proposal set voted = CONCAT(voted,'".$vstring."'),".$add." where propid = ".$id;
echo $sql;
$q->query($sql);
$q->execute();
// check for seconder
$q->setClass('Proposal');
$q->query("select agree from proposal where propid = ".$id);
$q->execute();
$result = $q->single();
if($result['agree'] === 1){
    $q->query("update proposal set seconder = '".$_SESSION['user']."' where propid = ".$id);
}
?>
