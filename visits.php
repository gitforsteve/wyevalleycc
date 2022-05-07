<?PHP

require 'classes.php';
$date = date('F Y');
$ip = $_SERVER['REMOTE_ADDR'];
if($ip !== '109.151.231.200'){
  $database = new Database();
  $q = sprintf("insert into newvisits (id, visits) values ('%s', 1) ON DUPLICATE KEY update visits = visits + 1",$date);
  $database->query($q);
  $database->execute();
}
?>
