<?PHP
// cSpell:disable
$title = "Dates of Council meetings";
$desc = "Our upcoming meetings have a public forum. Find the date of our next meeting here";
$keywords = "Council meetings date of meetings public forum";
require "top.html";
require "stevetable.php";
require "steveCSV.php";
$table = new steveTable('{
  "id": "meetings",
  "tableWidth": "100%",
  "widths": ["60%","35%","5%"],
  "tableFontSize": "1.8vw",
  "border": "b",
  "borderColor": "lightgray",
  "heading": ["Date","Location","Time"],
  "headingBackground": "lightgray"
}');
class Meeting {
  public $dtcode;
  public $title;
  public $date;
  public $time;
  public $location;
}
?>
<div class="nine columns" style="padding-left:10px;">
<?PHP
// get agenda
$docs = array();
$files = glob("agenda/*.txt");
foreach($files as $filename){
  $docs[] = substr(basename($filename),0,-4);
}
$meetings = [];
$csv = new steveCSV('data/event.csv');
$today = new DateTime();
foreach($csv->data as $item){
  $thisdate = new DateTime($item->date);
  if($thisdate >= $today){
    $meetings[] = $item;
  }
}
if(count($meetings) > 0){
  print("<h1>Meetings</h1>");
  print("<p>Council meetings are held at the time shown in either of the Tintern or Llandogo Village Halls</p><p>There is a short time allocated to members of the public who wish to attend who are asked to notify the Clerk as soon as possible before the proposed attendance.</p>");
  $table->heading();
  foreach($meetings as $meeting){
    $agenda = in_array($meeting->dtcode, $docs)?sprintf("<a href='showagenda.php?%s'> Agenda",$meeting->dtcode):"";
    $dt = date('l, jS F Y',strtotime($meeting->date));
    $table->row([$dt." ".$meeting->title." ".$agenda,$meeting->location." Village Hall ",$meeting->time]);
  }
  $table->print();
  //print("</table>");
}else{
  $year = date('Y',strtotime('+1 years'));
  printf("<h3>Wye Valley Community Council wishes you a very happy Christmas and a happy %s when meetings will recommence",$year);
}
?>
</div>

<script type="text/javascript">
  handleMenu($('#meetings'));
  //$('#current').html("Meetings");
</script>
<?PHP
require 'bottom.html';
?>
