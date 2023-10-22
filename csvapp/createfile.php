<?PHP
if(file_exists('csvpath')){
    $path = file_get_contents('csvpath');
}else{
    $path = "";
}
$filename = $_REQUEST['fname'];
$fields = $_REQUEST['fields'];
$noofrows = $_REQUEST['noofrows'];
$s = $blank = "";
$arr = explode(",",$fields);
for($i=1;$i<count($arr);$i++){
    $blank .= ",";
}
$s = $fields."\n";
for($i=0;$i<$noofrows;$i++){
    $s.=$blank."\n";
}
if(file_put_contents($path.$filename,$s)){
    echo "File ".$path.$filename." created";
}

?>