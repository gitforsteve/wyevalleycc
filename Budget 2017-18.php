<?PHP
require 'classes.php';
$years = array("2016","2017","2018");
$salary = array(4000,3551,3500,3421);
$allowance = array(350,350,350,350);
$clerkexp = array(500,444,400,407);
$training = array(50,0,0,55);
$cllrexp = array(100,0,100,0);
$chair = array(300,300,300,300);
$hire = array(200,100,150,130);
$ins = array(1100,307,320,1346);
$subs = array(250,254,250,186);
$audit = array(300,331,400,409);
$elect = array(0,0,0,183);
$safety = array(100,92,100,92);
$maint = array(750,2186,1000,534);
$revtot = array(8000,7915,6870,7413);
$hall = array(0,1399,1000,817);
$church = array(500,500,500,500);
$news = array(300,300,300,300);
$website = array(200,150,60,100);
$brigade = array(200,500,200,500);
$toddlers = array(200,200,200,200);
$charity = array(100,150,100,100);
$proj = array(8000,9080,7500,5900);
$school = array(0,250,250,250);
$captot = array(9500,12529,10110,8667);
$totexp = array(17500,20444,16980,16080);
$sum = 7.57;
$roll = "642 on electoral roll";
$projects = "Quayside Path &pound;3704.38<br />Japanese knotweed removal &pound;700<br />As Wharf legal costs of &pound;2,000 &amp; Toilet of &pound;2,500 were not claimed in 2016-17 these will come into 2017-18<br /><br />VAT refund to Jan 2018 - &pound;1,032.12";

$title = "Annual Budget 2017-18";
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

