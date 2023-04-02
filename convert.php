<?PHP
//cSpell:disable
class Councillor {
  public $id;
  public $code;
  public $name;
  public $surname;
  public $ward;
  public $email;
  public $address;
  public $phone;
  public $photo;
  public $responsibility;
  public $status;
}
$f = fopen('data/councillor.csv','r');
$councillors = [];
$keys = fgetcsv($f);
while($line = fgetcsv($f)){
  $councillor = new Councillor();
  $councillor->id = $line[0];
  $councillor->code = $line[1];
  $councillor->name = $line[2];
  $councillor->surname = $line[3];
  $councillor->ward = $line[4] === '1' ? "Tintern" : "Landogo";
  $councillor->email = $line[5];
  $councillor->address = $line[6];
  $councillor->phone = $line[7];
  $councillor->photo = $line[8] > '' ? $line[8] : 'missing.jpg';
  $councillor->responsibility = $line[9];
  $councillors[] = $councillor;
}
fclose($f);
var_dump($councillors);
/*$separator = "\r\n";
$line = strtok($source, $separator);
while ($line !== false) {
    # do something with $line
    $line = strtok( $separator );
    $r = explode(',',$line);
    print_r($r);
    echo "<br />";
}*/
?>