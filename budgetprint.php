<?PHP
error_reporting(E_ERROR);
require_once "stevetable.php";
require_once "steveCSV.php";
echo "<p style='text-align:center'>BUDGET AS AT AUGUST 2023</p>";
$d = new steveCSV("data/budget.csv");
$table = new steveTable('{
    "tableWidth": "90%",
    "tableCenter": true,
    "widths": ["25%","18%","18%","20%","30%"],
    "tableFontSize": "0.85rem",
    "heading": ["Item","Budget\n2022-23","Spend\n2022-23","Budget\n2023-24","Spend\n2023-24"],
    "currency": [0,1,1,1,1],
    "border": "b",
    "borderColor": "lightgray",
    "headingBackground": "darkgray",
    "headingColor": "white"
}');
$totals = [0.00,0.00,0.00,0.00];
$table->setAligns(["L","R","R","R","R"]);
$table->heading();
foreach($d->data as $item){
    $totals[0]+=$item->budget1;
    $totals[1]+=$item->spend1;
    $totals[2]+=$item->budget2;
    $totals[3]+=$item->spend2;
    $colours = ["black","black","black","black","black"];
    $table->setColors($colours);
    if($item->spend2 > $item->budget2){
        $colours[4] = "red";
    }
    if($item->spend1 > $item->budget1){
        $colours[2] = "red";
    }
    $table->setColors($colours);
    $table->row([$item->item,$item->budget1,$item->spend1,$item->budget2,$item->spend2]);
}
$colours = ["black","black","black","black","black"];
$table->setColors($colours);
$table->sort(1);
$table->row(["TOTALS",$totals[0],$totals[1],$totals[2],$totals[3]]);
$table->print();

?>