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
$file = "agenda/".$f.".txt";
require "classes.php";
include "top.html";
if(file_exists($file)){
  $text = file_get_contents($file);
  ?>
  <div class="nine columns" id="content">
    <h1 style="font-size:3vw;">Agenda for meeting on <?=$date?></h1>
    <br />
    <?PHP
      $txt = explode("\n",$text);
      foreach($txt as $line){
	printLine($line);
      }
      ?>
      <!--?=nl2br($text);?-->
  </div>
  <?PHP
}else{
  ?>
<div class="nine columns" id="content">
  <p>Sorry, no agenda exists for that meeting</p>
</div>
  <?PHP
}
include "bottom.html";
?>
<script type="text/javascript">
  handleMenu($('#agenda'));
  //$('#current').html("Meeting Agenda");
</script>
