<?PHP
require "classes.php";
require "stevetable.php";
function highlight_words( $text, $keywords ){
    $text = preg_replace( "/($keywords)/i", '<span style="background-color:yellow;">$1</span>', $text );
    return( $text );
}
if(isset($_REQUEST['search'])){
    $txt = $_REQUEST['search'];
    $sql = "select * from planning where CONCAT(reason,status) like '%".$txt."%'";
}else{
    $type = $_REQUEST['type'];
    switch($type){
        case "active":
            $sql = "select * from planning where status = 'Current' order by number"; break;
        case "approved":
            $sql = "select * from planning where status in ('Approved','Acceptable','Discharged') order by number"; break;
        case "refused":
            $sql = "select * from planning where status = 'Refused' order by number"; break;
        default:
            $sql = "select * from planning where SUBSTRING(number,4,4) = '".$type."' order by number"; break;
        }
}

$q = new Database("Application");
$result = $q->getData($sql);
$table = new steveTable('{
    "ID": "plantable",
    "tableWidth": "100%",
    "widths": ["10%","67%","20%","3%"],
    "tableFontSize": "1.2vw",
    "styles": ["","","","b"]
}');
foreach($result as $application){
    $table->setColors(['black','black','black','black']);
    if(!validateDate($application->appdate)){
        $date = "";
    }else{
        $date = date("jS F Y",strtotime($application->appdate));
    }
    $sign = "";
    if($application->status == 'Approved' || $application->status == 'Acceptable' || $application->status == 'Discharged'){
        $sign = "&check;";
        $table->setColors(['black','black','black','rgb(74,196,77)']);
    }
    if($application->status == 'Refused' ){
        $sign = "&#215";
        $table->setColors(['black','black','black','red']);
    }
    if($application->status == 'Withdrawn' ){
        $sign = "&#8594";
    }
    $table->row([highlight_words($application->number,$txt),highlight_words($application->reason,$txt),highlight_words($date,$txt),$sign],$application->number);
}
$table->print();
?>
<style>
    .selected {
        border: 2px solid black;
    }
</style>
<script src="js/jquery-3.1.1.min.js"></script>
<script>
    $('#plantable').on("click","td",function(e){
        $('#plantable tr').each(function(){$(this).removeClass('selected')});
        $(this).parent("tr").addClass('selected');
        var pos = $(this).closest('tr').position();
        var ht = $(this).closest('tr').css('height');
        var tp = pos.top + parseInt(ht) + 10;
        $('#popup').css("top",tp);
        $('#popup').load("getapp.php?plan="+$(this).closest("tr").attr("id"));
        $('#popup').show();
    });
</script>