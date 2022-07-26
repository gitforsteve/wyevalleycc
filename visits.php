<?PHP

require 'classes.php';
$date = date('F Y');
$ip = $_SERVER['REMOTE_ADDR'];
if($ip !== '109.151.231.200'){
  $database = new Database();
  $data = $database->getSingle("select * from newvisits where id = '".$date."'");
  if(is_null($data['visits'])){
    // create new entry
    $cmd = $database->upDate("insert into newvisits values ($date, 1)");
  }else{
    // update entry
    $cmd = $database->upDate("update newvisits set visits = visits + 1 where id = '".$date."'");
  }
  //$q = sprintf("insert into newvisits (id, visits) values ('%s', 1) ON DUPLICATE KEY update visits = visits + 1",$date);
  //$database->query($q);
  //$database->execute();
}
?>
