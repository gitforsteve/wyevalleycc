<?PHP
include_once "header.php";
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
foreach($result as $proposal){
    if(strtotime($proposal->closingdate) >= strtotime("today")){
        $proposal->display();
    }else{
        $older[] = $proposal;
    }
}
print("<h1>Older Proposals</h1>");
if(count($older) > 0){
    foreach($older as $proposal){
        $proposal->displayold();
    }
}else{
    print("NONE");
}

include_once "footer.php";
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <body>
        <form style='display:none;' id='frm' action='showprop.php' method='POST'>
            <input id='frmid' name='id'></input>
            <input type='checkbox' id='frmold' name='old' />    
        </form>
    </body>
</html>