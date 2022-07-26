<?PHP
//cSpell:disable
$title = "Planning applications";
$desc = "Check out the planning applications for the Tintern area";
$keywords = "tintern, planning applications, Monmouthshire planning";
require 'top.html';
require 'classes.php';
if(isset($_POST['display'])){
  $display = $_POST['display'];
}else{
  $display = "all";
}
function plansort($a,$b){
  if($a->number===$b->number) return 0;
  return ($a->number<$b->number)?1:-1;
}
if (!function_exists('str_contains')) {
  function str_contains($haystack, $needle) {
      return $needle !== '' && mb_strpos($haystack, $needle) !== false;
  }
}
?>
<div class='nine columns' style='padding-right: 10px; border-radius:0 0 15px 0; ' id='content'>
<h1>Planning</h1>
<p>Local planning applications may be listed here when details become available. For direct access to Monmouthshire CC Planning click for <a class="button shadow" title="External link to Monmouthshire Planning weekly page" href="https://planningonline.monmouthshire.gov.uk/online-applications/search.do?action=weeklyList" target="new">weekly list</a> or <a class="button shadow" title="External link to Monmouthshire Planning monthly list" href="https://planningonline.monmouthshire.gov.uk/online-applications/search.do?action=monthlyList" target="new">monthly list</a></p>

<form action="planningsearch.php" method="POST" onsubmit="return $('#srch').val() > ''">
<label for="srch" style="display:inline;">Search our planning records</label> <input size="25" id="srch" name="srch" type="text" placeholder="Search all of our records" />&nbsp;<input class="shadow" title="Search button" id="srchbtn" type="submit" style="width:80px;text-align:center;padding:0;" value="SEARCH"><br />
</form>
<p>Our search selects matching records where your entry in the search box matches any part of the application number, description, status or decision date on the application.</p>
<form action="planning.php" method="POST">
<fieldset style="border:1px solid gray;padding-left:10px;">
  <legend>Select what to display</legend>
  <input style="float:left;clear:none;" type="radio" name="display" id="all" value="all" <?=$display === 'all' ? 'checked' : ''?>  > <label style="float:left;clear:none;display:block;padding:0 10px 0 10px;" for="all">All</label>
  <input style="float:left;clear:none;" type="radio" name="display" id="active" value="active" <?=$display === 'active' ? 'checked' : ''?> > <label style="float:left;clear:none;display:block;;padding:0 10px 0 10px;" for="active">Current only</label>
  <input style="float:left;clear:none;" type="radio" name="display" id="complete" value="complete" <?=$display === 'complete' ? 'checked' : ''?> > <label style="float:left;clear:none;display:block;;padding:0 10px 0 10px;" for="complete">Processed only</label>
  <input class="shadow" style="float:left;" type="submit" value="Select" />
</fieldset>
</form>
<div id="hover" style="position:absolute;display:none;background:white;color:#336699;padding:5px;font-size:80%;box-shadow:2px 2px 2px 2px gray;">Click to copy to clipboard</div>

<?PHP
$q = new Database('Application');
switch($display){
  case "active" : $sql = "select * from planning where status = 'Current' and (appdate BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() OR appdate = '0000-00-00')  order by number desc";
  $caption = "<caption>Displaying current applications only</caption>";
  break;
  case "complete" : $sql = "select * from planning where status <> 'Current' and (appdate BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() OR appdate = '0000-00-00')  order by number desc"; 
   $caption = "<caption>Displaying processed applications only</caption>";
   break;
  default : $sql = "select * from planning where appdate BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() OR appdate = '0000-00-00' OR status = 'Current'  order by number desc"; 
  $caption = "";
  break;
}
$q->query($sql);
$q->execute();
$applications = $q->resultset();
if(count($applications) > 0){
  printf("<div class='u-full-width' style='text-align:center;background:black;color:white;'>%s</div>",$caption);
  usort($applications,"plansort");
  print("<table class='u-full-width'><thead><tr style='border-top:1px solid #336699;border-bottom:1px solid #336699;background:lightgray;'><th>Application Number</th><th>Description</th><th>Status</th></tr></thead><tbody>");
  foreach($applications as $application){
    $application->output();
  }
  print("</tbody></table></div>");
}
require 'bottom.html';
?>
<script type="text/javascript" src="js/clipboard.min.js"></script>
<script type="text/javascript">
  handleMenu($('#planning'));
  var clipboard = new ClipboardJS('.appno');
  clipboard.on('success', function(e){
    window.open("https://planningonline.monmouthshire.gov.uk/online-applications/","zam");   
  });
  clipboard.on('error', function(e) {
    alert("Sorry could not copy to clipboard");
  })
  $('#plansearch').on('keyup',function(e){
    if(e.keyCode == 13){
      $('#srchbtn').trigger('click');
    }
  });
  $('.appno').hover(function(e){
    var offset = $(this).parent().offset();
    $('#hover').html("Click to copy "+$(this).attr('data-clipboard-text')+" to clipboard<br />and load MCC search page");
    $('#hover').css({
      left: e.pageX - offset.left/4,
      top: e.pageY + 15
    }).stop().show(100);
  }, function() {
    $('#hover').hide();
  });
</script>
