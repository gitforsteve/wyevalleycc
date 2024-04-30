<?PHP
require "steveCSV.php";
require "stevetable.php";

$csv = new steveCSV("data/riskassessment.csv");
$data = $csv->data;
$table = new steveTable('{
    "tableWidth": "95%",
    "tableCenter": true,
    "heading": ["No.","Potential Risk","Severity","Likelihood","Risk","Procedure in place","Action"],
    "widths": ["5%","20%","5%","5%","5%","30","30%"],
    "tableFontSize": "9pt",
    "border": "a",
    "borderColor": "lightgray"
}');
?>
<div style="font-family:arial;text-align:center;font-weight:bold;">WYE VALLEY COMMUNITY COUNCIL<br />Risk Assessment 2024/2025</div>
<?
$table->heading();
foreach($data as $item){
    $table->row([$item->no,$item->risk,$item->severity,$item->likelihood,$item->riskscore,$item->procedure,$item->action]);
}
$table->print();
?>
<div style="font-family:arial;padding-left:2em;padding-right:2em;page-break-before-always;">
    <p style="font-weight:bold;">NB = See also notes below. These include re-checking frequency<p>
</div>
<div style="font-family:arial;padding-left:2em;padding-right:2em;">
    <p>The above assessment carried out by Finance Committee</p>
    <p style="padding-top:1.5em;">Chairman</p>
    <p style="padding-top:1.5em;">Clerk</p>
    <p style="padding-top:1.5em;">Dated</p>
</div>
