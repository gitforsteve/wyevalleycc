<?PHP

if(!isset($_GET['3233'])){
  exit;
}
require 'classes.php';

$database = new Database('Application');
$database->query("select * from planning where appdate BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() OR appdate = '0000-00-00' and status = 'Current' order by number desc");
$database->execute();
$applications = $database->resultset();

print("<table class='u-full-width'><thead><tr style='border-top:1px solid cadetblue;border-bottom:1px solid cadetblue;'><th>Application Number</th><th>Description</th><th>Status</th></tr></thead><tbody>");
foreach($applications as $application){
  $application->output();
}
print("</tbody></table>");

?>
