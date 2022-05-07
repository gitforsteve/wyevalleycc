<?PHP
session_start();
if(!isset($_SESSION['userid'])){
    exit;
}
include_once "../classes.php";
$q = new Database();
$q->query("update proposal set withdrawn = 1 where propid = :id");
$q->bind(':id',$_POST['currentId']);
$q->execute();
echo "THIS PROPOSAL HAS BEEN WITHDRAWN";
?>