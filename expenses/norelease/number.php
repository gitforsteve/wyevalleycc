<?PHP
$file = "../data/assets.csv";
$s = file($file);
for($i = 1; $i < count($s); $i++){
  if(strlen($s[$i]) > 0){
    $s[$i] = $i.",".$s[$i];
  }
}
$output = implode('',$s);
file_put_contents($file,$output);
?>