<?PHP
require 'classes.php';
$years = array("2015","2016","2017");
$salary = array(4200,3528,4000,3551);
$allowance = array(350,350,350,350);
$clerkexp = array(500,415,500,444);
$training = array(100,0,50,0);
$cllrexp = array(100,64,100,0);
$chair = array(300,300,300,300);
$hire = array(150,152,200,100);
$ins = array(1000,1044,1100,307);
$subs = array(220,149,250,254);
$audit = array(300,301,300,331);
$elect = array(100,0,0,0);
$safety = array(100,89,100,92);
$maint = array(750,1178,750,2186);
$revtot = array(8170,7570,8000,7915);
$hall = array(1000,0,0,1399);
$church = array(500,500,500,500);
$news = array(300,300,300,300);
$website = array(200,60,200,150);
$brigade = array(200,200,200,500);
$toddlers = array(200,200,200,200);
$charity = array(100,100,100,150);
$proj = array(6000,7695,8000,9080);
$school = array(0,250,0,250);
$captot = array(8500,9305,9500,12529);
$totexp = array(16670,16875,17500,20444);
$sum = 7.42;
$roll = "645 on electoral roll";
$projects = "Wharf legal costs &pound;2,000<br />Fetes &pound;500<br />Film equipment &pound;3,000<br />Toilet at churchyard &pound;2,500<br />Actually spent: MCC Rd repairs &pound;2,500, Fete &pound;500, Map &pound;1,909, Acoustics &pound;2,500";

$title = "Annual Budget 2016-17";
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

