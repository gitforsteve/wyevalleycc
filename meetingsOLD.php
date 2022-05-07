<?PHP
// cSpell:disable
$title = "Dates of Council meetings";
$desc = "Our upcoming meetings have a public forum. Find the date of our next meeting here";
require "top.html";
if(!class_exists('Database')){
  require 'classes.php';
}
require "stevetable.php";
$table = new steveTable('{
  "id": "meetings",
  "tableWidth": "100%",
  "widths": ["60%","40%"],
  "tableFontSize": "13vw",
  "border": "b",
  "borderColor": "lightgray",
  "heading": ["Date","Location"],
  "headingBackground": "lightgray"
}');
?>
<div class="nine columns" style="padding-left:10px;">
<?PHP
// get agenda
$docs = array();
$files = glob("agenda/*.txt");
foreach($files as $filename){
  $docs[] = substr(basename($filename),0,-4);
}
$database = new Database('Event');
$database->query("select * from event where title REGEXP 'Council Meeting' and date >= now() order by date");
$database->execute();
$meetings = $database->resultset();
if($database->rowCount()>0){
  print("<h1>Meetings</h1>");
  print("<p>Council meetings are held at 7:00pm in either of the Tintern or Llandogo Village Halls</p><p>There is a short time allocated to members of the public who wish to attend who are asked to notify the Clerk as soon as possible before the proposed attendance.</p>");
  $table->heading();
  foreach($meetings as $meeting){
    $agenda = in_array($meeting->id, $docs)?sprintf("<a href='showagenda.php?%s'> (agenda available)",$meeting->dtcode):"";
    $dt = date('l, jS F Y',strtotime($meeting->date));
    $table->row([$dt,$meeting->location." Village Hall ".$agenda]);
    //printf("<tr><td>%s</td><td>Council Meeting %s</td></tr>",$dt,$agenda);     
  }
  $table->print();
  //print("</table>");
}else{
  print("<h3>Wye Valley Community Council wishes you a very happy Christmas and a happy ".date('Y',strtotime('+1 years'))." when meetings will recommence");
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
