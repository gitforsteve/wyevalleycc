<?PHP
$tinterndata = $llandogodata = false;
$title = "Village Hall events";
$desc = "Events in our local Village Halls";
$keywords = "tintern, events, village hall";
require 'top.html';
require 'classes.php';
require "steveCSV.php";
require "stevetable.php";
?>
<div class='nine columns' style='padding-right: 10px; border-radius:0 0 15px 0; ' id='content'>
<h1>Village Hall Events</h1>
<p>Upcoming events for Tintern and Llandogo Village Halls</p>
<?
$today = date("Y-m-d");
$csv = new steveCSV("./data/vhevents.csv");
$tintern = $csv->copy();
$tintern->data = $csv->gt('Date',$today);
$tintern->data = $tintern->find("Location","Tintern");
if($tintern->data === "Not found"){
    echo "<p>We await further events for Tintern Village Hall</p>";
    $tinterndata = false;
}else{
    $tinterndata = true;
    $tintern->sort("Date");
}
$llandogo = $csv->copy();
$llandogo->data = $csv->gt('Date',$today);
$llandogo->data = $llandogo->find("Location","Llandogo");
if($llandogo->data === "Not found"){
    $llandogodata = false;
    echo "<p>We await further events for Llandogo Village Hall</p>";
}else{
    $llandogodata = true;
    $llandogo->sort("Date");
}
$table = new steveTable('{
    "tableWidth": "100%",
    "tableCenter": true,
    "widths": ["25%","18%","57%"],
    "heading": ["Date","Time","Event"],
    "tableFontSize": "1.5vw",
    "border": "b",
    "borderColor": "lightgray",
    "backgroundColor": "white"
}');

if($tinterndata){
    $table->styles = "b";
    $table->aligns = ["C"];
    $table->text("EVENTS IN TINTERN VILLAGE HALL");
    $table->styles = "";
    $table->aligns = ["L"];
    $table->heading();
    foreach($tintern->data as $event){
        $table->row([date("jS F Y",strtotime($event->Date)),$event->Time,"<strong>".$event->Event."</strong> ".$event->Description]);
    }
    $table->text("");
}
if($llandogodata){
    $table->styles = "b";  
    $table->aligns = ["C"];
    $table->text("EVENTS IN LLANDOGO VILLAGE HALL");
    $table->styles = "";
    $table->aligns = ["L"];
    $table->heading();
    foreach($llandogo->data as $event){
        $table->row([date("jS F Y",strtotime($event->Date)),$event->Time,"<strong>".$event->Event."</strong> ".$event->Description]);
    }
}
$table->print();
echo "</div>";
require 'bottom.html';
?>
<script type="text/javascript" src="js/clipboard.min.js"></script>
<script type="text/javascript">
  handleMenu($('#vhevents'));
 </script>