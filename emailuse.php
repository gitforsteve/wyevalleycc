<?PHP
//cSpell:disable
require_once "stevetable.php";
require_once "steveCSV.php";
$csv = new steveCSV("data/emailusage.csv");
$table = new steveTable('{
    "ID": "emailtable",
    "tableWidth": "30%",
    "tableCenter": true,
    "tableFontSize": "1.5vw",
    "border": "b",
    "borderColor": "lightgray",
    "widths": ["60%","20%","20%"],
    "heading": ["Councillor","Used Mb","Useage %"],
    "aligns": ["L","R","R"]
}');
$table->heading();
foreach($csv->data as $user){
    $table->row([$user->Name,number_format($user->Usage,2),number_format(($user->Usage/2048)*100,0,'.',',')."%"]);
}
$table->print();
?>