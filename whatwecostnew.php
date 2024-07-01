<?PHP
require "steveCSV.php";
require "stevetable.php";
$table = new steveTable('{
    "tableWidth" : "50%",
    "tableCenter": true,
    "widths": ["10%","80%","10%"],
    "aligns": ["L","L","R"],
    "tableFontSize": "10pt",
    "border" : "b",
    "borderColour": "lightgray",
    "sum" : [0,0,1],
    "totalLabel" : "TOTAL",
    "heading" : ["Description","","Budget"],
    "headingBackground": "black",
    "headingColor": "white",
    "currency" : [0,0,1],
    "decimals": 0
}');
$data = new steveCSV("data/whatwecostdata.csv");
$csv = $data->copy();
$csv->sort("section");
$headings = $csv->unique("section");
$table->heading();
foreach($headings as $k=>$v){
    $section = $csv->find("section",$k);
    $table->fontWeight("b");
    $table->backgrounds = ["lightgray"];
    $table->text($k);
    $table->fontWeight("");
    $table->backgrounds = ["white"];
    foreach($section as $item){
        $table->row(["",$item->item,$item->budget]);
    }
}
$table->total();
$table->print();
?>