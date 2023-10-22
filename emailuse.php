<?PHP
//cSpell:disable
require_once "stevetable.php";
require_once "steveCSV.php";
$csv = new steveCSV("data/emailusage.csv");
$count = count($csv->fields);
$heading=$csv->fields;
$table = new steveTable('{
    "ID": "emailtable",
    "tableWidth": "30%",
    "tableCenter": true,
    "tableFontSize": "1.5vw",
    "border": "b",
    "borderColor": "lightgray",
    "widths": ["60%","20%","20%"],
    "aligns": ["L","R","R"],
    "heading": ["Name","Use","Percent"]
}');
$table->heading();
foreach($csv->data as $user){
    switch(true){
        case $user->Usage < 500: $table->setColors(['black','black','black']); break;
        case $user->Usage < 1000: $table->setColors(['#f9a825','#f9a825','#f9a825']); break;
        default: $table->setColors(['red','red','red']);
    }
    $table->row([$user->Name,number_format($user->Usage,2),number_format(($user->Usage/2048)*100,0,'.',',')."%"]);
    $table->setColors(['#000000','#000000','#000000']);
}
$table->print();
?>