<?PHP
require "steveCSV.php";
$today = date("Y-m-d");
$data = new steveCSV("./data/vhevents.csv");
$events = $data->gt('Date',$today);
// find Tintern
$tevent = null;
foreach($events as $event){
    if(is_null($tevent) && $event->Location === "Tintern"){
        $tevent = $event;
    }
}
// find Llandogo
$levent = null;
foreach($events as $event){
    if(is_null($levent) && $event->Location === "Llandogo"){
        $levent = $event;
    }
}

$yr = substr($tevent->Date,0,4);
$mh = substr($tevent->Date,5,2);
$dy = substr($tevent->Date,8,2);
$t = new DateTime($yr."-".$mh."-".$dy);
$tevent->Date = $t->format("jS F Y");
$yr = substr($levent->Date,0,4);
$mh = substr($levent->Date,5,2);
$dy = substr($levent->Date,8,2);
$t = new DateTime($yr."-".$mh."-".$dy);
$levent->Date = $t->format("jS F Y");
?>
<div class="u-full-width" style="border:1px solid black;text-align:center;box-shadow:5px 5px 20px;">
    <p style="font-weight:bold;">TINTERN VILLAGE HALL</p>
    <p style="font-size:1.3rem;"><?=$tevent->Event?></p>
    <p><?=$tevent->Date?><br /><?=$tevent->Time?></p>
</div>
<br />
<div class="u-full-width" style="border:1px solid black;text-align:center;box-shadow:5px 5px 20px;">
    <p style="font-weight:bold;">LLANDOGO VILLAGE HALL</p>
    <p style="font-size:1.3rem;"><?=$levent->Event?></p>
    <p><?=$levent->Date?><br /><?=$levent->Time?></p>
</div>