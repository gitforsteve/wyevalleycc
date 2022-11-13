<?PHP
// *EXCLUDE*
//cSpell:disable
$title = "Notices search results";
require 'classes.php';
require "top.html";
$GLOBALS['findcount'] = 0;
$GLOBALS['links'] = "";
function highlight_words( $text, $keywords){
  $GLOBALS['findcount'] += 1;
  $link = "find".$GLOBALS['findcount'];
  $text = preg_replace( "/($keywords)/i", "<a name='".$link."'><span style='background-color:yellow;'>$1</span></a>", $text );
  $GLOBALS['links'] .= "<a href='#find".$GLOBALS['findcount']."'>[ ".$GLOBALS['findcount']." ]</a><br />";
  return( $text );
}
$atags = array();
function parseTags($s){
  while(strpos($s,'<a')){
    // find start and end of a tag
    $start = strpos($s,'<a');
    $end = strpos($s,'</a>');
    printf("%s %s<br />",$start,$end);
    print(substr($s,$start,$end+4));
    $s = substr($s,0,$start)."[A]".substr($s,$end+4);
  }
  return $s;
}
$foundtext = "";
$keywords = $_POST['srch'];
?>
<div class="nine columns" id="content" style="border-radius:0 0 15px 0; ">
  <h1>Notices</h1>
<?PHP
printf("<h2>Notices search for '%s'</h2><br />",$keywords);

$q = new Database('notice');
$query = "select * from notice where headline REGEXP '".$keywords."' OR notice REGEXP '".$keywords."' order by date desc";
$q->query($query);
$q->execute();
$result = $q->resultset();
?>
    <form action="noticesrch.php" method="POST">
        <label for="srch" style="display:inline;">Search notices again</label><input type="text" size="35" id="srch" name="srch" placeholder="Search all notices (including out of date)" onkeyup="$(this).val()===''?$('#srchbtn').prop('disabled',true):$('#srchbtn').prop('disabled',false)" /> <input title="Search button" id="srchbtn" disabled type="submit" style="width:55px;text-align:left;padding:0;" value="Search" />
    </form>
<?
if($q->rowCount()==0){
  print("Sorry, there are no matching notices<br /><a href='notices.php' title='Link back to notices'>Click here to return to notices</a>");
}else{
    echo "<a href='notices.php'>Click here to return to notices</a>";
    $noticecount = $q->rowcount()==1?"notice":"notices";
    printf("<p>%s matching %s</p>",$q->rowcount(),$noticecount);
    $now = strtotime(date("Y-m-d"));
    foreach($result as $notice){
      $dt = substr($notice->date,8,2)."/".substr($notice->date,5,2)."/".substr($notice->date,0,4);
      $ndate = strtotime($notice->date);
      $foundtext .= sprintf("<h3>%s</h3>",highlight_words($notice->headline,$keywords,0));
      //$GLOBALS['links'] .= "[ <a href='#find".$GLOBALS['findcount']."'>".$GLOBALS['findcount']."</a> ]<br />";
      if($now > $ndate){
        $foundtext .= "<span style='font-weight:bold;'>THIS NOTICE EXPIRED on ".date("jS F Y",$ndate)."</span><br />";
      }
      $foundtext .= sprintf("<p>%s</p>",highlight_words($notice->notice,$keywords));
      $foundtext .= "<hr />";
    }
  }
  $links = $GLOBALS['links'];
  if($links !== "" AND $q->rowCount() < 20){
$linkarea = <<<EOD
<div class="one columns" style="position:fixed;left:0px;bottom:10px;font-size:80%;background:white;border:1px solid black;">
<div style="background:black;color:white;">Go To:</div>
$links
<a href="#top">TOP<br /></a>
</div>
EOD;
    echo $linkarea;
  }
  echo $foundtext;

echo "</div>";
  
require "bottom.html";
?>
<script type="text/javascript">
        $('#srch').on('keyup',function(e){
            if(e.keyCode == 13){
                $('#srchbtn').trigger('click');
            }
        });
  handleMenu($('#notices'));
</script>