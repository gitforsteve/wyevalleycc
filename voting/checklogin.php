<?PHP
session_start();
include_once "../classes.php";
$q = new Database('User');
$q->query("select * from user where username = :name");
$q->bind(':name', $_POST['name']);
$q->execute();
if($q->rowCount() !== 1){
    echo "Access denied";
    exit;
}
$user = $q->single();

if(password_verify($_POST['pword'],$user['userhash'])){
    $_SESSION['user'] = $user['realname'];
    $_SESSION['userid'] = $user['userid'];
    echo "You are in";
}else{
    echo "Access denied";
}
?>