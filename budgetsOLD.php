<?PHP
//cSpell:disable
$title = "Finance - Annual budgets";
$desc = "See how we handle our finances in our annual budgets";
/******* YEARS FOR BUDGET CHANGE EACH YEAR ****/
$years = "2023-24";
/******************************************** */
require "stevetable.php";
require 'top.html';
require "steveCSV.php";
/*class Budget {
  public $id;
  public $type;
  public $text;
  public $budget1;
  public $spend1;
  public $budget2;
  public $spend2;
}
$f = fopen('data/budget.csv','r');
$budgets = [];
while($line = fgetcsv($f)){
  $b = new Budget();
  $b->id = $line[0];
  $b->type = $line[1];
  $b->text = $line[2];
  $b->budget1 = $line[3];
  $b->spend1 = $line[4];
  $b->budget2 = $line[5];
  $b->spend2 = $line[6];
  $budgets[] = $b;
}*/
$budgets = new steveCSV('data/budget.csv');
$revenue = $capital = [];
foreach($budgets->data as $row){
  switch($row->type){
    case 'capital': array_push($capital,$row); break;
    case 'revenue': array_push($revenue,$row); break;
  }
}

$revtotals = $captotals = [0,0,0,0];
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

$table = new steveTable('{
  "widths": ["40%","15%","15%","15%","15%"],
  "heading": ["&nbsp;ITEM","Budget 2022-23","Spent 2022-23","Budget 2023-24","Spent&nbsp;<br />2023-24&nbsp;"],
  "headingColor": "white",
  "headingBackground": "gray",
  "border": "b",
  "borderColor": "lightgray",
  "currency": [0,1,1,1,1],
  "currencySymbol": "&pound;",
  "aligns": ["L","R","R","R","R"],
  "emptyFields": true,
  "sum": [0,1,1,1]
}');
?>
<!--div class="nine columns" id="content"-->
<h1>BUDGET <?=$years?></h1>
<?PHP
$table->heading();
$table->fontWeight('b');
$table->text("REVENUE");
$table->fontWeight('');
$table->setSubTotalLabel("REVENUE TOTAL");
foreach($revenue as $data){
  $table->row([$data->text,$data->budget1,$data->spend1,$data->budget2,$data->spend2]);
  if($data->budget1 > ''){$revtotals[0] += $data->budget1;}
  if($data->spend1 > ''){$revtotals[1] += $data->spend1;}
  if($data->budget2 > ''){$revtotals[2] += $data->budget2;}
  if($data->spend2 > ''){$revtotals[3] += $data->spend2;}
}
//$table->total();
$table->row(["REVENUE TOTALS",$revtotals[0],$revtotals[1],$revtotals[2],$revtotals[3]]);
$table->fontWeight('b');
$table->text("\nCAPITAL");
$table->fontWeight('');
//$table->setSubTotalLabel("CAPITAL TOTAL");
//$table->sums = [];
foreach($capital as $data){
  $table->row([$data->text,$data->budget1,$data->spend1,$data->budget2,$data->spend2]);
  if($data->budget1 > ''){$captotals[0] += $data->budget1;}
  if($data->spend1 > ''){$captotals[1] += $data->spend1;}
  if($data->budget2 > ''){$captotals[2] += $data->budget2;}
  if($data->spend2 > ''){$captotals[3] += $data->spend2;}
}
//$captotals = $table->sums;
$table->row(["CAPITAL TOTALS",$captotals[0],$captotals[1],$captotals[2],$captotals[3]]);
$table->text("\n");
$table->row(["TOTAL EXPENDITURE",$revtotals[0]+$captotals[0],$revtotals[1]+$captotals[1],$revtotals[2]+$captotals[2],$revtotals[3]+$captotals[3]]);
$table->sums = [];
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
