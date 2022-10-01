<?PHP
// cSpell:disable
$title = "Agenda for meetings";
$desc = "Agenda for our meetings";
$keywords = "council meeting agenda";
require 'top.html';
if(!class_exists('Database')){
  require 'classes.php';
}
?>
<div class="nine columns" id="content">
<h1>Agenda</h1>
<br />
<?PHP
print("<p>Council meetings are held in either of the Tintern or Llandogo Village Halls at the times shown on the <a href='meetings.php' title='Link to meetings page'>meetings page</a></p><p>There is a short time allocated to members of the public who wish to attend who are asked to notify the Clerk as soon as possible before the proposed attendance.</p><p>Each entry links to a copy of the agenda which will load into this page. Agenda for meetings more than three months ago will not be displayed.</p><ul>");

$files = glob("agenda/*.txt");
foreach($files as $filename){
  $doc = basename($filename);
  $filepart = substr(basename($filename),0,-4);
  $datepart = strtotime(substr(basename($filename),0,-4));
  $date = date("jS M Y",$datepart);
  if(strtotime($date) > strtotime('-90 days')){
    $agenda = new Agenda();
    $agenda->date = $date;
    $agenda->filepart = $filepart;
    $agenda->file = $datepart;
    $agendas[$doc] = $agenda;
  }
}
$agendas = array_reverse($agendas);

foreach($agendas as $agenda){
  $note = "";
  $filesearch = $agenda->filepart;
  $files = glob("minutes/".$filesearch."*.txt");
  if(count($files) > 0) {
    $note = sprintf(" ... %s<a href='showminute.php?%s' title='View minutes for this meeting'>Minutes are available</a>",$space,$agenda->filepart);
  }
  printf("<li><a href='showagenda.php?%s' title='Get the agenda for %s'>%s</a> %s</li>",$agenda->filepart,$agenda->date,$agenda->date,$note);
}
print("</ul>")
?>
</div>
<script type="text/javascript">
  handleMenu($('#agenda'));
  //$('#current').html("Meeting Agenda");
</script>
<?PHP
require 'bottom.html';
?>