<?PHP
// *EXCLUDE*
$f = strip_tags($_SERVER['QUERY_STRING']);
$dt = strtotime(substr($f,0,4)."-".substr($f,4,2)."-".substr($f,6,2));
$date = date("jS M Y",$dt);
$title = "Minutes of meeting held on ".$date;
$file = "minutes/".$f.".txt";
require "classes.php";
include "top.html";
if(file_exists($file)){
  $text = file_get_contents($file);
  $txt = nl2br($text);

  //$arr = explode('\n',$text);
  //$text = implode("<hr style='height:10px;;visibility:hidden;' />",explode("<br />",$txt));
  ?>
  <div class="nine columns" id="content">
    <h3>Minutes of meeting held on <?=$date?></h3>
    <?=$txt?>
  </div>
  <?PHP
}else{
  ?>
<div class="nine columns" id="content">
  <p>Sorry, no minutes exist for that meeting</p>
</div>
  <?PHP
}
include "bottom.html";
?>
<script type="text/javascript">
  handleMenu($('#minutes'));
  //$('#current').html("Meeting Agenda");
</script>
