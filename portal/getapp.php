<?PHP
require "classes.php";
require "stevetable.php";
$planno = $_REQUEST['plan'];
$q = new Database("Application");
$data = $q->getSingle("select * from planning where number = '".$planno."'");

$table = new steveTable('{
    "tableWidth": "100%",
    "widths": ["20%","80%"]
}');
$table->row(["Record ID",$data->planid]);
$table->row(["Application number",$data->number]);
$table->row(["Details",$data->reason]);
$table->row(["Status",$data->status]);

if(validateDate($data->appdate)){
    $date = date("jS F Y",strtotime($data->appdate));
}else{
    $date = "";
}
$table->row(["Last action date",$date]);
if($data->code === "TCC"){
    $s = "Tintern Community Council";
}else{
    $s = "Wye Valley Community Council";
}
$table->row(["Minor authority",$s]);

$table->print();
?>