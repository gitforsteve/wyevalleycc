<?PHP
//EXCLUDE//
$title = "Notices relating to Tintern and surrounding area";
$desc = "What's happening in Tintern and the surrounding area";
require 'classes.php';

function displayBetween($s,$e){
  $today = date('Ymd');
  if (($today >= $s) && ($today <= $e)){
    return 1;
  }else{
    return 0;
  }
}
require 'top.html';
?>
<div class="nine columns" id="content" style="border-radius:0 0 15px 0; ">
    <h1>Notices</h1>
    <p style="font-weight: bold;">Notices are listed in reverse date order. Notices which expired over 60 days ago are not shown.</p>
    <input type="text" size="35" id="srch" placeholder="Search all notices (including out of date)" onkeyup="$(this).val()===''?$('#srchbtn').prop('disabled',true):$('#srchbtn').prop('disabled',false)" /> <input title="Search button" id="srchbtn" disabled type="button" style="width:55px;text-align:left;padding:0;" onclick="$('#content').load('noticesrch.php?srch='+encodeURIComponent($('#srch').val()))" value="Search" />
<?PHP
$q = new Database('Notice');
$q->query("select * from notice where noticeid = :id");
$q->bind(':id',$_GET['item']);
$q->execute();
$items = $q->resultset();

if($q->rowCount()===0){
  print("<h3>Sorry, no new notices at present</h3>");
  exit;
}else{
  $counter = 0;
  foreach($items as $item){
    $dt = substr($item->date,8,2)."/".substr($item->date,5,2)."/".substr($item->date,0,4);
    printf("<h2 class='newshead'>%s</h2>",$item->headline);
    echo "</p>";
    echo nl2br($item->notice);
    printf("<p style='font-size:0.8em;color:#336699;padding-top:10px;'>This notice will expire on %s</p>", $dt);
    echo "<hr>";
    $counter += 1;
  }
}
require 'bottom.html';
?>
  <script type="text/javascript">
    $('#srch').on('keyup',function(e){
      if(e.keyCode == 13){
	$('#srchbtn').trigger('click');
      }
    });
    //var text = "From time to time your Community Council is advised of events or circumstances relevent to the village. The current notices will be displayed here for your information. Note that notices not yet active will not appear in the side bar but can be viewed as all notices.";
    //$('#current').html("<p style='cursor:help;' onclick=\"$('#help').html(text);$('#help').show();\" onmouseleave=\"$('#help').hide();\">Notices<br /><br />What is this? <img src='images/help.png' /></p>");
  handleMenu($('#notices'));
</script>
