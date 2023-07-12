<?PHP
//cSpell:disable
$title = "Annual Report - future plans";
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
<h1>Annual Report 2022/23</h1>
<a class="button" href="annualreport.php" title="annual report main page">What we do</a>  <a class="button" href="whatwecost.php" title="what we cost">What we cost</a> <a class="button" href="chairsreport.php" title="chair's report">Chair's report</a>
<h2>OUR PLANS FOR THE FUTURE</h2>
<p>We will continue to support the community's interests and facilitate a harmonious integration of Tintern and Llandogo now that the Wye Valley Community Council has come into being. We will continue to support community events to strengthen communities.
We will engage with members of the community and village groups to encourage activities and projects that are of benefit to residents. Our support for local business will continue with assistance in advertising.</p>
<p>Wye Valley Community Council has inherited the ownership of Tintern Village Hall and the liabilities associated with it and also Fryer's Wharf and the Village Pound.</p>
</div>
<?PHP
 require 'bottom.html';
 ?>
 <script type="text/javascript">
  handleMenu($('#report'));
</script>
