<?PHP
// cSpell:disable
$title = "Accounting Statement";
$desc = "our latest accounting statement";
require 'top.html';
if(!class_exists('Database')){
  require 'classes.php';
}
require "stevetable.php";
include "data/accstatement.php";

?>
<div class='nine columns' id='content'>
<div role="navigation">Our other financial pages:
    <ul>
      <!--li><a href="accounts.php">Accounting statement</a></li-->
      <li><a href="budgets.php">Budgets</a></li>
      <li><a href="assets.php">Tangible assets</a></li>
      <li><a href="paymenttomembers.php">Payments to members</a></li>
    </ul>
  </div>
<h1>Accounting statement</h1>
<?

$table = new steveTable('{
  "widths": ["5%","50%","22%","21%","2%"],
  "border": "b",
  "tableBorder": true,
  "borderColor": "gray",
  "sum": [0,0,0,0],
  "currency": [0,0,0,0],
  "currencySymbol": "&pound;",
  "decimals": 0,
  "brackets": [0,0,1,1]
}');
$table->reset('{ "aligns": ["L","L","R","L"] }');
$table->row(["","","Year","Ending"]);
$table->reset('{ "aligns": ["L","L","C","C"] }');
$table->row(["","",$dates[0],$dates[1]]);
$table->reset('{ "aligns": ["C","L","R","R"], "currency": [0,0,1,1], "sum": [0,0,1,1] }');
$table->fontWeight("b");
$table->text("Statement of income and expenditure/receipts and payments");
$table->fontWeight();
$count = 1;
foreach($income as $data){
  $table->row([$count,$data[0],$data[1],$data[2]]);
  $count++;
}
$incometotals = $table->getTotals(true);
$table->row([$count,"(=) Balances carried forward",$incometotals[2],$incometotals[3]]);
$count++;
$table->fontWeight("b");
$table->center();
$table->text("Statement of balances");
$table->fontWeight();
$table->reset('{ "aligns": ["C","L","R","R"] }');
foreach($balances as $data){
  for($i=0;$i<count($data);$i++){
    if(substr($data[$i],0,6) === "income"){
      preg_match_all('!\d+!', $data[$i], $matches);
      $number = implode(' ', $matches[0]);
      $data[$i] = $incometotals[$number];
    }
  }
  $table->row([$count,$data[0],$data[1],$data[2]]);
  $count++;
}
$table->text("Trust funds disclosure note N/A");
$table->sums = [];
$table->print();



?>
</div>
<?
require 'bottom.html';
?>
<script type="text/javascript">
  handleMenu($('#financial'));
</script>
