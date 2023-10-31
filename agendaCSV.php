<?PHP
require_once "steveCSV.php";
require_once "stevetable.php";
$d = new steveCSV('./data/20231030.csv',"id,text");

$data = $d->data;
$table = new steveTable('{
    "tableWidth": "90%",
    "widths": ["8%","92%"],
    "tableFontSize": "1.2rem",
    "tableCenter": true
}');
foreach($data as $item){
    $table->row([$item->id,$item->text]);
}
$table->print();
?>