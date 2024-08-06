<?PHP
//cSpell:disable
$title = "Annual Report - what we cost";
$desc = "Our annual report for 2022/23";
$keywords = "tintern, annual report, council report";
require 'top.html';
require 'classes.php';
require "stevetable.php";
require "steveCSV.php";
$table = new steveTable('{
    "tableWidth": "80%",
    "tableCenter": true,
    "widths": ["70%","15%","15%"],
    "heading": ["Expenditure","Budget","Spend"],
    "tableFontSize": "1.5vw",
    "aligns": ["L","R","R"],
    "currency": [0,1,1],
    "currencySybmbol": "",
    "border": "b",
    "borderColor": "lightgray",
    "sum": [0,1,1],
    "totalLabel": "Totals",
    "decimals": 0
}');

?>
<div class='nine columns' style='padding-right: 10px; border-radius:0 0 15px 0; ' id='content'>
<h1>Annual Report 2023/24</h1>
<div style="position:sticky;top:0;background:white;">
<a class="button" href="annualreport.php" title="annual report main page">What we do</a> <a class="button" href="chairsreport.php" title="chair's report">Chair's report</a>
</div>
<h2>WHAT WE COST</h2>
<p>Running a Community Council obviously costs money as well as the time and effort of your Community Councillors. The money we receive forms a very small part of your Council Tax (known as our precept) and our costs are shown below</p>
<?PHP
$csv = new steveCSV("data/whatwecost.csv");
$table->heading();
foreach($csv->data as $item){
  $table->row([$item->expense,$item->budget,$item->spend]);
}
$table->boldTotal();
$table->print();
?>
</div>
<?PHP
require 'bottom.html';
?>
 <script type="text/javascript">
  handleMenu($('#report'));
</script>?>
