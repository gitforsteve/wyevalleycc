<?PHP
// cSpell:disable
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$title = "Accounting Statement";
$desc = "our latest accounting statement";
require 'top.html';
if(!class_exists('Database')){
  require 'classes.php';
}
require "stevetable.php";
require "steveCSV.php";
/// SET DATES
$dates = ["31 March 2023","31 March 2024"];
///
$csv = new steveCSV("data/accounts.csv");
$data = $csv->data;

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
<?PHP
$table = new steveTable('{
  "widths": ["52%","21%","21%","3%"],
  "border": "b",
  "tableBorder": true,
  "borderColor": "gray",
  "currency": [0,0,0,0],
  "currencySymbol": "&pound;",
  "noSymbolOnZero": true,
  "decimals": 0,
  "brackets": [0,1,1,0]
}');
$table->version();
$table->reset('{ "aligns": ["L","C","C","L"] }');
$table->row(["","Year","Ending",""]);
$table->reset('{ "aligns": ["L","C","C","L"] }');
$table->row(["",$dates[0],$dates[1],""]);
$table->reset('{ "aligns": ["L","L","L","L"], "currency": [0,1,1,0] }');
$table->fontWeight("b");
$table->text("Statement of income and expenditure/receipts and payments");
$table->fontWeight();
//INCOME
  $row = $csv->find("text","Balances brought forward");
  $table->row([$row[0]->text,$row[0]->year1,$row[0]->year2,""]);
  $row = $csv->find("text","Income from local taxation/levy");
  $table->row([$row[0]->text,$row[0]->year1,$row[0]->year2,""]);
 $row = $csv->find("text","Total other receipts");
  $table->row([$row[0]->text,$row[0]->year1,$row[0]->year2,""]);
 $row = $csv->find("text","Staff costs");
$table->row([$row[0]->text,$row[0]->year1,$row[0]->year2,""]);
$row = $csv->find("text","Loan interest/capital repayments");
$table->row([$row[0]->text,$row[0]->year1,$row[0]->year2,""]);
$row = $csv->find("text","Total other payments");
$table->row([$row[0]->text,$row[0]->year1,$row[0]->year2,""]);
$table->fontWeight('b');
$table->row([$row[0]->text,$row[0]->year1,$row[0]->year2,""]);
$row = $csv->find("text","Balance carried forward");
$table->row([$row[0]->text,$row[0]->year1,$row[0]->year2,""]);
$table->print(true);
$table->fontWeight("b");
$table->center();
$table->text("Statement of balances");
$table->fontWeight();
$table->reset('{ "aligns": ["L","R","R","L"] }');
$totals = [0,0];

$row = $csv->find("text","Debtors and stock balances");
$table->row([$row[0]->text,$row[0]->year1,$row[0]->year2,""]);

$row = $csv->find("text","Total cash and investments");
$table->row([$row[0]->text,$row[0]->year1,$row[0]->year2,""]);

$row = $csv->find("text","Creditors");
$table->row([$row[0]->text,$row[0]->year1,$row[0]->year2,""]);
$row = $csv->find("text","Balances carried forward");
$table->fontWeight("b");
$table->row([$row[0]->text,$row[0]->year1,$row[0]->year2,""]);
$table->fontWeight();
$row = $csv->find("text","Total fixed assets");
$table->row(["Total fixed assets",$row[0]->year1,$row[0]->year2]);
$table->setAligns(['C']);
$table->text("Trust funds disclosure note N/A");
$table->version();
$table->print();
printf("<p>%s</p>",$ver);



?>
</div>
<?PHP
require 'bottom.html';
?>
<script type="text/javascript">
  handleMenu($('#financial'));
</script>
