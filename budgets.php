<?PHP
//cSpell:disable
$title = "Finance - Annual budgets";
$desc = "See how we handle our finances in our annual budgets";
/******* YEARS FOR BUDGET CHANGE EACH YEAR ****/
$years = "2024-25";
/******************************************** */
require "stevetable.php";
require 'top.html';
require "steveCSV.php";
$totals = [0,0,0,0];
?>
<div class='nine columns' id='content'>
<div role="navigation">Our other financial pages:
    <ul>
      <li><a href="accounts.php">Accounting statement</a></li>
      <!--li><a href="budgets.php">Budgets</a></li-->
      <li><a href="assets.php">Tangible assets</a></li>
      <li><a href="paymenttomembers.php">Payments to members</a></li>
    </ul>
  </div>
<?PHP
$csv = new steveCSV("data/budget.csv");
$csv->sort('item');

$table = new steveTable('{
  "widths": ["40%","15%","15%","15%","15%"],
  "heading": ["&nbsp;ITEM","Budget 2022-23","Spent 2022-23","Budget 2023-24","Spent&nbsp;<br />2023-24&nbsp;"],
  "headingColor": "white",
  "headingBackground": "gray",
  "border": "b",
  "borderColor": "lightgray",
  "currency": [0,1,1,1,1],
  "currencySymbol": "&pound;",
  "emptyFields": true,
  "aligns": ["L","R","R","R","R"],
  "sum": [0,1,1,1,1],
  "totalLabel": "TOTALS"
}');
?>
<!--div class="nine columns" id="content"-->
<h1>BUDGET <?=$years?></h1>
<?PHP
$table->heading();
foreach($csv->data as $data){
  $table->row([$data->item,$data->budget1,$data->spend1,$data->budget2,$data->spend2]);
  if($data->budget1 > ''){$totals[0] += $data->budget1;}
  if($data->spend1 > ''){$totals[1] += $data->spend1;}
  if($data->budget2 > ''){$totals[2] += $data->budget2;}
  if($data->spend2 > ''){$totals[3] += $data->spend2;}
}
$table->setStyles(['b','b','b','b','b']);
$table->print();

echo "<p>Appropriate sum for 2023/24 &pound;9.93 per elector = &pound9,334<br />Tintern Ward: 548 electors, Llandogo Ward: 392 electors (as at Dec 2022)</p>";
$table = new steveTable('{
  "tableWidth": "75%",
  "widths": ["70%","15%","15%"],
  "aligns": ["L","R","C"],
  "currency": [0,1,0],
  "currencySymbol": "&pound;",
  "sum": [0,1,0],
  "totalLabel": "Totalling",
  "borderColor": "white"
}');

$table->text("* Projects for 2023 - 24");
$table->row(["Coronation event (&pound;500 each village)",1000,""]);
$table->row(["First Aid training for Church Lads Brigade",500,""]);
$table->row(["Film equipment for Llandogo Village Hall",4000,""]);
$table->total();
$table->print();
?>

</div>
<?PHP
require "bottom.html";
?>
<script type="text/javascript">
handleMenu('#financial');
</script>
