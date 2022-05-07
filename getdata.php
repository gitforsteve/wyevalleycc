<?PHP
session_start();
require 'classes.php';

$t = explode(' ',$_REQUEST['code']);
$fn = strtoupper($t[0]);
if($fn === 'QE'){
  $val = "";
  array_shift($t);
  while(count($t)>0){
    $val.=" ".array_shift($t);
  }
}else{
  $val = $t[1];
  $val2 = $t[2];
}
echo $val;
$sql = "";
switch($fn){
  case 'AS': $sql = "select * from asset where assetid REGEXP '".$val."' or item REGEXP '".$val."' or subitem REGEXP '".$val."' or location REGEXP '".$val."'"; $n = "ASSET"; break;
  case 'CO': $sql = "select * from councillor c left join ward w on w.wardid=c.ward where name REGEXP '".$val."' or surname REGEXP '".$val."' or email REGEXP '".$val."' or wardname REGEXP '".$val."'"; $n = "COUNCILLOR"; break;
  case 'LK': $sql = "select * from links where linktitle REGEXP '".$val."' or linkdesc REGEXP '".$val."' or linkurl REGEXP '".$val."'"; $n = "LINK"; break;
  case 'NO' : $sql = "select * from notice where date REGEXP '".$val."' or start REGEXP '".$val."' or headline REGEXP '".$val."' or notice REGEXP '".$val."'"; $n = "NOTICE"; break;
  case 'ND' : $sql = "select * from notice where date REGEXP '".$val."' or start REGEXP '".$val."'"; $n = "NOTICE DATE"; break;
  case 'PL' : $sql = "select * from planning where number REGEXP '".$val."' or reason REGEXP '".$val."' or status REGEXP '".$val."' or appdate REGEXP '%s%'"; $n = "PLANNING"; break;
  case 'QE' : $sql = $val; $n = "QUERY"; break;
  default : echo $fn." DOES NOT EXIST"; exit();
}
$_SESSION['sql'] = $sql;
if($fn === 'QE' and trim($val)===""){
  echo "? NO QUERY";
  exit();
}
if($sql !== ''){
  $q = new Database();
  $q->query($sql);
  $q->execute();
  $result = $q->resultset();
}else{
  echo "? NO INPUT";
  exit();
}
if($q->rowcount() === 0){
  echo "NO RECORDS MATCHING";
  exit();
}
if($q->rowCount() > 1){
  printf("%s RECORDS %s<br />",$q->rowCount(),$n);
}
$header = 0;
$w = 0;
$titles = array_keys($result[0]);
$displaytitles = [];
for($i=0;$i<count($titles);$i++){
  $displaytitles[] = strtoupper($titles[$i]);
}
print("<table><tr>");
for($i=0;$i<count($titles);$i++){
  printf("<td>%s</td>",$displaytitles[$i]);
}
print("</tr>");
foreach($result as $vehicle){
  print("<tr>");
  for($i=0;$i<count($titles);$i++){
    printf("<td valign='top'>%s</td>",$vehicle[$titles[$i]]);
  }
  print("</tr>");
}
print("</table>");
?>
