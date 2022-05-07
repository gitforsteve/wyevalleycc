<?PHP
//cSpell:disable
require "MyCSV.class.php";
require "stevetable.php";
$data = new MyCSV("welshnames.csv");

$table = new steveTable('{
  "tableWidth": "60%",
  "tableCenter": true,
  "heading": ["Name","Alternative","English"],
  "widths": ["33%","33%","34%"],
  "tableFontSize": "20rem",
  "border": "b",
  "borderColor": "lightgray"
}');
$table->heading();
$thisname = "";
while($row = $data->each()){
  if($row['standard']!==$thisname){
    $table->row([$row['standard'],$row['alternative'],$row['english']]);
    $thisname = $row['standard'];
  }
}
$table->print();
?>