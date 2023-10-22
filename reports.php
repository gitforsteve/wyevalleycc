<?PHP
/* NOT FOR RELEASE
Report on Budgets, payments to councillors, accounting 
*/
printf("<p style='text-align:center;font-weight:bold;font-family:'sans-serif;'>BUDGET</p>");
$totals = [0,0,0,0];
require_once "steveCSV.php";
require_once "steveTable.php";
$csv = new steveCSV('data/budget.csv');
// id, type, text, budget1, spend1, budget2, spend2
$csv->sortfield = 'item';
$csv->sort();

$table = new steveTable('{
    "tableWidth": "80%",
    "tableCenter": true,
    "widths": ["40%","15%","15%","15%","15%"],
    "heading": ["Item","Last budget","Last spend","This budget","This spend"],
    "headingBackground": "darkgray",
    "headingColor": "#fff",
    "border": "b",
    "border-color": "lightgray",
    "tableFontSize": "1vw",
    "aligns": ["L","R","R","R","R"],
    "currency": [0,1,1,1,1],
    "currencySymbol": "&pound;",
	"noSymbolOnZero": true
}');
$table->heading();

foreach($csv->data as $budget){
	$table->setColors(['black','black','black','black','black']);
	if($budget->spend2>$budget->budget2){
		$table->setColors(['black','black','black','black','red']);
	}		$table->row([$budget->item,$budget->budget1,$budget->spend1,$budget->budget2,$budget->spend2]);
	$totals[0] += $budget->budget1;
	$totals[1] += $budget->spend1;
	$totals[2] += $budget->budget2;
	$totals[3] += $budget->spend2;

}
$table->setStyles['b'];
$table->row(["TOTAL",$totals[0],$totals[1],$totals[2],$totals[3]]);
$table->print();
echo "<p style='page-break-after;text-align:center;'>ASSETS</p>";
/**************** ASSETS ***************/
/* id, item, qty,location, value */
$csv = new steveCSV('data/assets.csv');
usort($csv->data, function ($a, $b) {
    if ( $a->item == $b->item ) {  
       return $a->location <=> $b->location;
    }
    return $a->item <=> $b->item;
});
$subtotal = $total = 0;
$key = "";
$table = new steveTable('{
    "tableWidth": "60%",
    "tableCenter": true,
    "widths": ["45%","5%","45%","5%"],
    "heading": ["Item","Qty","Location","Value"],
    "headingBackground": "darkgray",
    "headingColor": "#fff",
    "border": "b",
    "border-color": "lightgray",
    "tableFontSize": "1vw",
    "aligns": ["L","C","L","R"],
    "currency": [0,0,0,1],
    "currencySymbol": "&pound;",
    "skipFields": [1,0,0,0]
}');
$table->heading();
foreach($csv->data as $item){
	$total += $item->value;
	$table->row([$item->item,$item->qty,$item->location,$item->value]);
}
$table->row(["TOTAL","","",$total]);
$table->print();
?>