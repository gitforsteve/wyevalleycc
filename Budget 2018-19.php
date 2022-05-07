<?PHP
require 'classes.php';
$years = array("2017","2018","2019");
$salary = array(3500,3421,3500);
$allowance = array(350,350,350);
$clerkexp = array(400,407,400);
$training = array(0,55,50);
$cllrexp = array(100,0,0);
$chair = array(300,300,300);
$hire = array(150,130,150);
$ins = array(320,1346,1400);
$subs = array(250,186,200);
$audit = array(400,409,400);
$elect = array(0,183,0);
$safety = array(100,92,100);
$maint = array(1000,534,600);
$revtot = array(6870,7413,7450);
$hall = array(1000,817,1000);
$church = array(500,500,500);
$news = array(300,300,300);
$website = array(60,100,100);
$brigade = array(200,500,200);
$toddlers = array(200,200,200);
$charity = array(100,100,100);
$proj = array(7500,5900,5000);
$school = array(250,250,250);
$captot = array(10110,8667,7650);
$totexp = array(16980,16080,15100);
$sum = 7.96;
$roll = "683 on electoral roll";
$projects = "Benches - &pound;750<br />Sports Pavilion Lean-to - &pound;1,500<br />Angiddy Trail Leaflet - &pound;1,000<br />Sacred Sight &amp; Sound Festival - &pound;500";

$title = "Annual Budget 2018-19";
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

