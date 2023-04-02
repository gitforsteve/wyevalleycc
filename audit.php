<?PHP
//cSpell:disable
echo "<h2>BUDGET AUDIT SHEET</h2>";
require "stevetable.php";
require 'MyCSV.class.php';
$budgets = new MyCSV('data/budget.csv');
$budgetdata = $budgets->toObj();
$revenue = $capital = [];
$revtotals = $captotals = [0.00,0.00,0.00,0.00];
foreach($budgetdata as $row){
  switch($row->type){
    case 'capital': 
      array_push($capital,$row);
      break;
    case 'revenue': 
      array_push($revenue,$row); 
      break;
  }
}
$table = new steveTable('{
  "tableWidth": "80%",
  "widths": ["40%","15%","15%","15%","15%"],
  "tableFontSize": "15px",
  "aligns": ["L","R","R","R","R"],
  "currency": [0,1,1,1,1],
  "sum": [0,1,1,1,1],
  "totalLabel": "TOTAL REVENUE"
}');
$table->text("REVENUE");
foreach($revenue as $data){
  $revtotals[0] += $data->budget1;
  $revtotals[1] += $data->spend1;
  $revtotals[2] += $data->budget2;
  $revtotals[3] += $data->spend2;
  $table->row([$data->text,$data->budget1,$data->spend1,$data->budget2,$data->spend2]);
}
$table->boldtotal();
$table->print();
$table->empty();
$table->text("");
$table->text("CAPITAL");
$table->setTotalLabel("TOTAL CAPITAL");
foreach($capital as $data){
  $captotals[0] += $data->budget1;
  $captotals[1] += $data->spend1;
  $captotals[2] += $data->budget2;
  $captotals[3] += $data->spend2;
  $table->row([$data->text,$data->budget1,$data->spend1,$data->budget2,$data->spend2]);
}
$table->boldtotal();
$table->print();
?>