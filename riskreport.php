<?PHP
require_once "steveCSV.php";
require_once "stevetable.php";
$data = new steveCSV('assetrisk.csv');
$table = new steveTable('{
    "tableWidth": "90%",
    "tableCenter": true,
    "widths": ["20%","20%","20%","15%","15%","10%"],
    "tableFontSize": "1rem",
    "heading": ["Item","Location","Risk","Severity","Likelihood","Score"]
}');
$table->heading();
foreach($data->data as $rec){
     $table->row([$rec->item,$rec->location,$rec->risk,$rec->severity,$rec->likelihood,$rec->score]);
}
$table->print();
?>