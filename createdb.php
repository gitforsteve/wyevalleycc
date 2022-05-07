<?PHP
//cSpell:disable;
include "MyCSV.class.php";
include "classes.php";
if(isset($_GET['tables'])){
  $l = $_GET['tables'];
  $tables = explode(",",$l);
}else{
  $tables = [];
}
$sql = "";
/**** ASSETS ****/
if(count($tables) === 0 OR in_array("asset",$tables)){
  $data = new MyCSV('data/assets.csv');
  $data->sort('item');
  $sql .= "USE `tinterncc`;\r\nDELETE FROM `asset`;\r\nALTER TABLE `asset` AUTO_INCREMENT = 1;\r\nINSERT INTO `asset` VALUES \r\n";
  while($row = $data->each()){
    $s = sprintf("(null,'%s','',%s,'%s',%s),",$row['item'],$row['qty'],$row['location'],$row['value']);
    $sql.=$s;
  }
  $sql = rtrim($sql,",").";";
}
/**** END ASSETS ****/
/**** COUNCILLOR ****/
if(count($tables) === 0 OR in_array("councillor",$tables)){
  $data = new MyCSV('data/councillor.csv');
  $data->sort('ward');
  $sql .= "USE `tinterncc`;\r\nDELETE FROM `councillor`;\r\nALTER TABLE `councillor` AUTO_INCREMENT = 1;\r\nINSERT INTO `councillor` VALUES \r\n";
  while($row = $data->each()){
    if(strlen($row['photo']) === 0){
      $row['photo'] = 'missing.jpg';
    }
    $s = sprintf("(null,'%s','%s','%s',%s,'%s','%s','%s','%s','','','',''),",$row['code'],$row['name'],$row['surname'],$row['ward'],$row['email'],$row['address'],$row['phone'],$row['photo'],$row['tccemail']);
    $sql.=$s;
  }
  $sql = rtrim($sql,",").";";
}
/**** END COUNCILLOR ****/
/**** LINKS  ****/
if(count($tables) === 0 OR in_array("link",$tables)){
  $data = new MyCSV('data/links.csv');
  $data->sort('linktitle');
  $sql .= "USE `tinterncc`;\r\nDELETE FROM `links`;\r\nALTER TABLE `links` AUTO_INCREMENT = 1;\r\nINSERT INTO `links` VALUES \r\n";
  while($row = $data->each()){
    $s = sprintf("(null,'%s','%s','%s','%s'),",$row['linktitle'],$row['linkdesc'],$row['linkurl'],$row['linkactive']);
    $sql.=$s;
  }
  $sql = rtrim($sql,",").";";
}
/**** END LINKS ****/
/**** EVENT (MEETINGS) ****/
if(count($tables) === 0 OR in_array("event",$tables)){
  $data = new MyCSV('data/event.csv');
  $data->sort('date');
  $sql .= "USE `tinterncc`;\r\nDELETE FROM `event`;\r\nALTER TABLE `event` AUTO_INCREMENT = 1;\r\nINSERT INTO `event` VALUES \r\n";
  while($row = $data->each()){
    $s = sprintf("('%s','%s','%s','%s','%s'),",$row['dtcode'],$row['title'],$row['date'],$row['time'],$row['location']);
    $sql.=$s;
  }
  $sql = rtrim($sql,",").";";
}

/**** END EVENT  ****/
$q = new Database();
$q->upDate($sql);
echo "Tables updated (".$l.")";

?>