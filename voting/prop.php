<?PHP
include_once "header.php";
include_once "../stevetable.php";
if(!isset($_SESSION['user'])){
    exit;
}
print("<h1>Proposals</h1>");

$q = new Database('Proposal');
$q->query("select * from proposal");
$q->execute();
if($q->rowCount() === 0){
    echo "No proposals";
    exit;
}
$older = array();
$result = $q->resultset();


$table = new steveTable('{
    "widths": ["30%","20%","20%",
}');

?>