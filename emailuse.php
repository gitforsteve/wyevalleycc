<?PHP
//cSpell:disable
require_once "stevetable.php";
require_once "MyCSV.class.php";
$rawdata = new MyCSV("data/emailusage.csv");
$data = $rawdata->toObj();
$table = new steveTable('{
    "ID": "emailtable",
    "tableWidth": "30%",
    "tableCenter": true,
    "tableFontSize": "1.5vw",
    "border": "b",
    "borderColor": "lightgray",
    "widths": ["80%","20%"],
    "heading": ["Councillor","Useage"],
    "aligns": ["L","R"]
}');
$table->heading();
foreach($data as $user){
    $table->row([$user->Name,number_format(($user->Usage/2048)*100,0,'.',',')."%"]);
}
$table->print();
?>