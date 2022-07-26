<?PHP
// *EXCLUDE*
//cSpell:disable
$title = "Planning search results";
require 'classes.php';
require "top.html";
$needle = addslashes(strip_tags($_POST['srch']));
?>
<div class="nine columns" id="content" style="border-radius:0 0 15px 0; ">
<h1>Planning</h1>
<p>For direct access to Monmouthshire CC Planning click for <a title='External link to Monmouthshire Planning weekly page' href='https://planningonline.monmouthshire.gov.uk/online-applications/search.do?action=weeklyList' target='new'>weekly list</a> or <a title='External link to Monmouthshire Planning monthly list' href='https://planningonline.monmouthshire.gov.uk/online-applications/search.do?action=monthlyList' target='new'>monthly list</a></p>
<?PHP
$database = new Database('application');
$sql = "select * from planning where number REGEXP '".$needle."' OR reason REGEXP '".$needle."' or status REGEXP '".$needle."' or DATE_FORMAT(appdate,'%d/%m/%Y') REGEXP '".$needle."' order by number desc";
$database->query($sql);
$database->execute();
$applications = $database->resultset();
printf("<h2>Planning search for '%s'</h2>",$needle);
?>
<form action="planningsearch.php" method="POST" onsubmit="return $('#srch').val() > ''">
<label for="srch" style="display:inline;">Search planning again</label> <input size="25" id="srch" name="srch" type="text" placeholder="Search all of our records" />&nbsp;<input title="Search button" id="srchbtn" type="submit" style="width:55px;text-align:left;padding:0;" value="SEARCH"><br />
</form>  
  <a href='planning.php'>Click here to return to Planning</a>
<?
if($database->rowCount() > 0){
  print("<table class='u-full-width'><thead><tr style='border-top:1px solid #336699;border-bottom:1px solid #336699;background:lightgray;'><th>Application Number</th><th>Description</th><th>Status</th></tr></thead><tbody>");
  foreach($applications as $match){
    $match->matchoutput($match,$needle);
  }
  print("</table>");
}else{
  printf("<p>Oops! Sorry nothing matches '%s'<br />",$needle);
  //print("<p style='cursor:pointer;' onclick=\"$('#content').load('planning.php');\" role='link'>Click here to return to Planning</p>");
}
print "</div>";
require "bottom.html";
?>
<script type="text/javascript">
  $('#plansearch').on('keyup',function(e){
    if(e.keyCode == 13){
      $('#srchbtn').trigger('click');
    }
  });
  handleMenu($('#planning'));
</script>