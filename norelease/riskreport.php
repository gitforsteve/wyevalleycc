<?PHP
//cSpell:disable
require_once "../MyCSV.class.php";
require_once "../stevetable.php";
$rawdata = new MyCSV('../assetrisk.csv');
$rawdata->sort('item');
$assets = $rawdata->toObj();
$table = new steveTable('{
  "ID": "assettable",
  "tableWidth": "60%",
  "tableCenter": true,
  "heading": ["Item","Location","Risk","Severity"],
  "widths": ["10%","40%","40%","10%"],
  "tableFontSize": "1.2vw",
  "border": "b",
  "borderColor": "lightgray",
  "stripe": "rgba(128,128,128,0.2)",
  "skipFields": [1,0,0,0]
}');
$table->heading();
foreach($assets as $asset){
  $table->row([$asset->item,$asset->location,$asset->risk,$asset->score]);
}
$table->print();
?>