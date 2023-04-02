<?PHP
//cSpell:disable
require_once "../classes.php";
$q = new Database('Asset');
$assets = $q->getData("select *, r.severity*r.likelihood as score from asset a left join assetrisk r on a.assetid=r.assetid");
$fields = ['id'];
foreach($assets[0] as $key=>$v){
  $fields[] = $key;
}
$s = implode(",",$fields)."\n";
for($i=0;$i<count($assets);$i++){
  $vals = [$i+1];
  foreach($assets[$i] as $key=>$v){
    $vals[] = $v;
  }
  $s .= implode(",",$vals)."\n";
}
file_put_contents("asstrisk.csv",$s);
?>