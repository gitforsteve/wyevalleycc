<?PHP
//cSpell:disable
$title = "Annual Report - chair's report";
$desc = "Our annual report for 2022/23";
$keywords = "tintern, annual report, council report";
require 'top.html';
require 'classes.php';
require "stevetable.php";
$table = new steveTable('{
    "tableWidth": "100%",
    "widths": ["85%","15%"],
    "heading": ["Expenditure","Budget\n2021/22"],
    "tableFontSize": "1.5vw",
    "aligns": ["L","R"],
    "currency": [0,1],
    "currencySybmbol": ""
}');

?>
<div class='nine columns' style='padding-right: 10px; border-radius:0 0 15px 0; ' id='content'>
<h1>Annual Report 2023/24</h1>
<div style="position:sticky;top:0;background:white;">
<a class="button" href="annualreport.php" title="annual report main page">What we do</a> <a class="button" href="whatwecost.php" title="what we cost">What we cost</a> 
</div>
<h2>Chair's report</h2>
<p>During the second year of the Wye Valley Community Council we have endeavoured to ensure that all of our spending and grants are, wherever possible, equitable. We have found this to be interesting given the diversity between the two villages.</p>
<p>In the past the majority of the Councillors have elected not to receive an allowance but this year payment has become statutory and all Councillors must accept the payments as laid down. This cannot be avoided and has little impact (4%) on the total spend.</p>
<p>Once again, expenditure on the estate has been elevated by works being required on the Pound and other repair work. These works were required due to safety concerns and to avoid the possibility of traffic hazards.</p>
<p>This has been a particularly trying year for me, personally, and I would like to take this opportunity to thank my fellow Councillors, our County Councillor and our Clerk for the support given to me.</p>
<p>This has been a particularly trying year for me, personally, and I would like to take this opportunity to thank my fellow Councillors, our County Councillor and our Clerk for the support given to me.</p>
<p>Steve Evans Chair 2023/24</p>
</div>
<?PHP
require 'bottom.html';
?>
 <script type="text/javascript">
  handleMenu($('#report'));
</script>?>

