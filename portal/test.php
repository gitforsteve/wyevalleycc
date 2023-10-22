<?PHP
require "classes.php";
require "stevetable.php";
$table = new steveTable('{
    "tableWidth": "100%",
    "widths": ["15%","85%"],
    "skipFields": [1,0],
    "tableFontSize": "1.2vw",
    "border": "b"
}');
$files = glob("../minutes/*.txt");
foreach($files as $file){
    $content = file($file);
    foreach($content as $line){
        $line = str_replace("<br />","\r\n",$line);
        if(str_contains(strtoupper($line),"PARVA")){
            $yr = substr(basename($file),0,4);
            $mh = substr(basename($file),4,2);
            $dy = substr(basename($file),6,2);
            $dt = new DateTime($yr."-".$mh."-".$dy);
            $table->row([$dt->format("jS F Y"),$line]);
        }
    }
}
$table->print();
?>