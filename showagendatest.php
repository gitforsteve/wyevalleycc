<?PHP
// *EXCLUDE*
function printLine($s){
  if(substr($s,0,1) === " "){
    $s = "&nbsp;&nbsp;".$s;
  }
  print($s."<br />");
}
$f = $_SERVER['QUERY_STRING'];
$dt = strtotime(substr($f,0,4)."-".substr($f,4,2)."-".substr($f,6,2));
$date = date("jS M Y",$dt);
$title = "Meeting agenda ".$date;
$file = "agenda/".$f.".csv";
require_once "MyCSV.class.php";
require_once "stevetable.php";
include "top.html";
?>
<div class="nine columns" id="content">
<h1>Agenda</h1>
<p>Council meetings are held in either of the Tintern or Llandogo Village Halls at the times shown on the <a href='meetings.php' title='Link to meetings page'>meetings page</a></p><p>There is a short time allocated to members of the public who wish to attend who are asked to notify the Clerk as soon as possible before the proposed attendance.</p><p>Each entry links to a copy of the agenda which will load into this page. Agenda for meetings more than three months ago will not be displayed.</p><p class='bluebold'>Agenda prior to May 2022 relate to Tintern Community Council</p>
<?
 if(file_exists($file)){
  $table = new steveTable('{
    "tableWidth": "100%",
    "tableCenter": true,
    "widths": ["10%","90%"]
  }');
  $data = new MyCSV($file);
  while($item = $data->each()){
    $table->row([$item['id'],implode("<br />",explode('\n',$item['text']))]);
  }
  $table->print();
}else{
  echo "Sorry, the requested agenda file cannot be found";
}
?>
</div>
<script type="text/javascript">
  handleMenu($('#agenda'));
  //$('#current').html("Meeting Agenda");
</script>
<?
require "bottom.html";
?>