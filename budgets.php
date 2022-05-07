<?PHP
//cSpell:disable
$title = "Finance - Annual budgets";
$desc = "See how we handle our finances in our annual budgets";
/******* YEARS FOR BUDGET CHANGE EACH YEAR ****/
$years = "2022-23";
/******************************************** */
require "stevetable.php";
require 'top.html';
require 'MyCSV.class.php';
$data = new MyCSV('data/budget.csv');
$revenue = $capital = [];
while($row = $data->each()){
  switch($row['type']){
    case 'capital': array_push($capital,$row); break;
    case 'revenue': array_push($revenue,$row); break;
  }
}
$revtotals = $captotals = [0,0,0,0];
?>
<div class='nine columns' id='content'>
<?PHP

$table = new steveTable('{
  "widths": ["40%","15%","15%","15%","15%"],
  "heading": ["&nbsp;ITEM","Budget 2021-22","Spent 2021-22","Budget 2022-23","Spent&nbsp;<br />2022-23&nbsp;"],
  "headingColor": "white",
  "headingBackground": "gray",
  "border": "b",
  "borderColor": "lightgray",
  "currency": [0,1,1,1,1],
  "currencySymbol": "&pound;",
  "aligns": ["L","R","R","R","R"],
  "sum": [0,1,1,1,1,1],
  "emptyFields": true
}');
?>
<!--div class="nine columns" id="content"-->
<h1>BUDGET <?=$years?></h1>
<?
$table->heading();
$table->fontWeight('b');
$table->text("REVENUE");
$table->fontWeight('');
$table->setSubTotalLabel("REVENUE TOTAL");
foreach($revenue as $data){
  $table->row([$data['text'],$data['budget1'],$data['spend1'],$data['budget2'],$data['spend2']]);
  if($data['budget1'] > ''){$revtotals[0] += $data['budget1'];}
  if($data['spend1'] > ''){$revtotals[1] += $data['spend1'];}
  if($data['budget2'] > ''){$revtotals[2] += $data['budget2'];}
  if($data['spend2'] > ''){$revtotals[3] += $data['spend2'];}
}
$table->row(["REVENUE TOTALS",$revtotals[0],$revtotals[1],$revtotals[2],$revtotals[3]]);
$table->fontWeight('b');
$table->text("\nCAPITAL");
$table->fontWeight('');
$table->setSubTotalLabel("CAPITAL TOTAL");
//$table->sums = [];
foreach($capital as $data){
  $table->row([$data['text'],$data['budget1'],$data['spend1'],$data['budget2'],$data['spend2']]);
  if($data['budget1'] > ''){$captotals[0] += $data['budget1'];}
  if($data['spend1'] > ''){$captotals[1] += $data['spend1'];}
  if($data['budget2'] > ''){$captotals[2] += $data['budget2'];}
  if($data['spend2'] > ''){$captotals[3] += $data['spend2'];}
}
//$captotals = $table->sums;
$table->row(["CAPITAL TOTALS",$captotals[0],$captotals[1],$captotals[2],$captotals[3]]);
$table->text("\n");
$table->row(["TOTAL EXPENDITURE",$revtotals[0]+$captotals[0],$revtotals[1]+$captotals[1],$revtotals[2]+$captotals[2],$revtotals[3]+$captotals[3]]);
$table->sums = [];
$table->print();
echo "<p>Appropriate sum for 2022/23 &pound;8.82 per elector.<br />Tintern Ward: 555 electors Llandogo Ward: 399 electors Total: 954 electors</p>";
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

$table->text("* Projects for 2022 - 23");
$table->row(["Business map",2500,"(Paid)"]);
$table->row(["Radio station",500,""]);
$table->row(["Clerk's laptop",500,"(Paid)"]);
$table->row(["Llandogo projects",4000,""]);
$table->row(["Queen's Platinum Jubilee",1000,""]);
$table->total();
$table->print();
?>

</div>
<?
require "bottom.html";
?>
<script type="text/javascript">
handleMenu('#financial');
</script>
