<?PHP
session_start();
if(!isset($_SESSION['userid']) AND strpos($_SERVER['PHP_SELF'],"index") === false){
    header("location: index.php");
}
include_once "../classes.php";
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$user = $_SESSION['userid'];
$proposal = $_POST['propno'];
$comment = test_input($_POST['com']);
$q = new Database();
$q->query("insert into comment values (null,:prop,:user,:dt,:com)");
$q->bind(':prop',$proposal);
$q->bind(':user',$user);
$q->bind(':dt',date('Y-m-d'));
$q->bind(':com',$comment);

$q->execute();
echo "Comment added";
?>
