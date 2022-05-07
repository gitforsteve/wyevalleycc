<?PHP
//cSpell:disable
$source = fopen("source.csv","r");
$target = fopen("welshnames.csv","w");
$count = 1;
$line = fgetcsv($source);
array_unshift($line,"id");
fputcsv($target,$line);
while(!feof($source)){
  $line = fgetcsv($source);
  if($line){
    array_unshift($line,$count);
    fputcsv($target,$line);
    $count++;
  }
}
fclose($source);
fclose($target);
?>