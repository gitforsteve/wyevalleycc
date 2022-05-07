<?PHP
//cSpell:disable
require_once "MyCSV.class.php";
require_once "stevetable.php";
$table = new steveTable('{
  "ID": "table",
  "tableWidth": "95%",
  "widths": ["15%","85%"],
  "headingBackground": "black",
  "headingColor": "white"
}');
$db = new MyCSV('councillor.dat');
$wards = new MyCSV('ward.dat');
$wards->join($db,"ward");
$db->sort('ward,surname');
$thisward = 1;
while($row = $db->each()){
  extract($row);
  if($ward !== $thisward){
    $r = $wards->data($ward);
    $table->setHeading([$r['wardname']]);
    $table->heading();
    $thisward = $ward;
  }
  $table->row(["<img src='images/".$photo."' style='width:95%;'/><strong>",$name." ".$surname."</strong><br />".$address."<br />".$phone."<br />Responsibility: ".$responsibility]);
}
$table->print();
?>