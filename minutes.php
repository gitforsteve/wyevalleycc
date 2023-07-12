<?PHP
$title = "Minutes of Council meetings";
$desc = "The published minutes of our meetings";
require 'classes.php';
require 'top.html';
print("<div class='nine columns' id='content' style='border-radius:0 0 15px 0;' >");
print("<h1>Minutes of Meetings</h1>");
print("<p>Each entry links to a copy of the signed off minutes which will load into this page. Note that minutes over a year old will not be displayed</p><ul>");

$files = glob("minutes/*.txt");

foreach($files as $filename){
  $agm = false;
  $doc = basename($filename);
  $draft = str_contains($doc,'draft') ? 1 : 0;
  $filepart = substr($doc,0,-4);
  $datepart = substr($doc,0,4)."-".substr($doc,4,2)."-".substr($doc,6,2);
  $date = date("jS M Y",strtotime($datepart));
  if(strtotime($date) > strtotime('-360 days')){
    $minute = new Minute();
    if($agm){
      $minute->agm = true;
    }
    $minute->date = $date;
    $minute->filepart = $filepart;
    $minute->file = $datepart;
    $minute->draft = $draft;
    $minutes[$doc] = $minute;
  }
}

$minutes = array_reverse($minutes);
foreach($minutes as $minute){
  $draft_msg = $minute->draft === 1 ? " DRAFT" : "";
  printf("<li><a href='showminute.php?%s' title='Read the minutes for %s'>%s</a> %s</li>",$minute->filepart,$minute->date,$minute->date,$draft_msg);
}
print("</ul>")
?>
<br />
<form action="searchminutes.php" method="POST">
  <label for="srch" style="font-weight:normal;">Search minutes for last two years <input type="text" id="srch" name="srch" autocomplete='off' placeholder='At least 4 characters' > <button class="shadow" id="srchbtn" disabled>SEARCH</button></label>
</form>
</div>
<script type="text/javascript">
  handleMenu($('#minutes'));
  $('#srchbtn').attr("disabled",true);
  $('#srch').on("keyup",function(){
    if($('#srch').val().length > 3){
      $('#srchbtn').attr("disabled",false);
    }else{
      $('#srchbtn').attr("disabled",true);
    }
  });
</script>
<?PHP
require 'bottom.html';
?>
