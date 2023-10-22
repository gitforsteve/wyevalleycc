<style>
    div {
        box-shadow: 10px 10px 20px #888888;
        padding: 10px 0 10px 0;
        width: 90%;
        margin: auto;
    }
</style>
<?PHP
error_reporting(E_ALL);
require "steveCSV.php";
require "stevetable.php";
$table = new steveTable('{
    "tableWidth": "90%",
    "tableCenter": true,
    "widths": ["25%","15%","60%"],
    "heading": ["Date","Time","Event"],
    "tableFontSize": "1.3vw",
    "border": "b"
}');
$csv = new steveCSV("data/vhevents.csv");
// date location event description time
$csv->sort('Date');
//$table->heading();
$today = date('Y-m-d');
$csv->data = $csv->gt('Date',$today);
$c = clone $csv;
$table->setStyles(["b"]);
$table->text("TINTERN VILLAGE HALL");
$table->setStyles([""]);
$c->data = $c->find("Location","Tintern");
foreach($c->data as $event){
    $date = date("jS F Y",strtotime($event->Date));
    if($event->Description){ $event->Description = " - ".$event->Description;}
    $table->row([$date,$event->Time,$event->Event." ".$event->Description]);
}
$table->border = "";
$table->text("");
$table->setBorder("b");
$table->setStyles(["b"]);
$table->text("LLANDOGO VILLAGE HALL");
$table->setStyles([""]);
$c = clone $csv;
$c->data = $c->find("Location","LLANDOGO");
foreach($c->data as $event){
    $date = date("jS F Y",strtotime($event->Date));
    if($event->Description){ $event->Description = " - ".$event->Description;}
    $table->row([$date,$event->Time,$event->Event." ".$event->Description]);
}

?>
<div>
    <?PHP
    $table->print();
    ?>
</div>