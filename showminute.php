<?PHP
// *EXCLUDE*
$draft ='';
$f = strip_tags($_SERVER['QUERY_STRING']);
$dt = strtotime(substr($f,0,4)."-".substr($f,4,2)."-".substr($f,6,2));
$date = date("jS M Y",$dt);
$title = "Minutes of meeting held on ".$date;
$file = "minutes/".$f.".txt";
require "classes.php";
include "top.html";
if(str_contains($f,'draft')){
  $draft = "<p style='font-weight:bold;font-size:1.2em;text-align:center;margin:0;padding:0;letter-spacing:5px;'>DRAFT</p>" ;
}
if(file_exists($file)){
  $text = file_get_contents($file);
  $txt = nl2br($text);
  $txt = $draft.$txt;
  ?>
  <div class="nine columns" id="content">
    <?=$txt?>;
  </div>
  <?
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
