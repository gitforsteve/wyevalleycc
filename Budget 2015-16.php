<?PHP
require 'classes.php';
$years = array("2014","2015","2016");
$salary = array(4200,3687,4200,3528);
$allowance = array(350,350,350,350);
$clerkexp = array(500,341,500,415);
$training = array(100,0,100,0);
$cllrexp = array(100,68,100,64);
$chair = array(300,300,300,300);
$hire = array(150,72,150,152);
$ins = array(1000,979,1000,1044);
$subs = array(220,348,220,149);
$audit = array(250,301,300,301);
$elect = array(100,0,100,0);
$safety = array(100,89,100,89);
$maint = array(600,553,750,1178);
$revtot = array(7970,7088,8170,7570);
$hall = array(0,0,1000,0);
$church = array(500,500,500,500);
$news = array(500,500,300,300);
$website = array(250,60,200,60);
$brigade = array(200,200,200,200);
$toddlers = array(100,100,200,200);
$charity = array(100,150,100,100);
$proj = array(6000,7695,8000,9080);
$school = array(0,0,0,250);
$captot = array(7400,8139,8500,9305);
$totexp = array(15370,15227,16670,16875);
$sum = 7.36;
$roll = "652 on electoral roll";
$projects = " (actual spend)<br />Defibrillator &pound;326<br />Planters &pound;2,573<br />Film equipment &pound;2,624<br />MCC signage (Welcome sign) &pound;1,422<br />Tintern Festivals Association &pound;750";

$title = "Annual Budget 20115-16";
include "top.html";
include "annualbudgets.html";
include "bottom.html";
?>
<script type="text/javascript">
  $('.cash').css("text-align","center");
  handleMenu('#financial');
  //var text = "This shows the annual return for Tintern Community Council and the notice of conclusion of audit. The figures shown will be, by definition, for a past year. Accounts for the current year will be published when they are finalised after the end of the year.";
  //$('#current').html("<p style='cursor:help;' onclick=\"$('#help').html(text);$('#help').show();\" onmouseleave=\"$('#help').hide();\">Annual Returns<br /><br />What is this? <img src='images/help.png' /></p>");
</script>

