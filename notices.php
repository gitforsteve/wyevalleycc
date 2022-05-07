<?PHP
//cSpell:disable
$title = "Notices relating to Tintern and Llandogo Wards";
$desc = "What's happening in Tintern, Llandogo and the surrounding area";
require 'classes.php';
function sortobj ($a, $b){
    return $a->headline > $b->headline;
}
function displayBetween($s,$e){
    $today = date('Ymd');
    if (($today >= $s) && ($today <= $e)){
        return 1;
    }else{
        return 0;
    }
}
require 'top.html';
?>
<div class="nine columns" id="content" style="border-radius:0 0 15px 0; ">
     <h1>Notices</h1>
    <p style="font-weight: bold;">Notices which expired over 60 days ago are not shown. Notices are shown in order of expiry date, earliest first.</p>
    <form action="noticesrch.php" method="POST">
        <label for="srch" style="display:inline;">Search notices</label><input type="text" size="35" id="srch" name="srch" placeholder="Search all notices (including out of date)" onkeyup="$(this).val()===''?$('#srchbtn').prop('disabled',true):$('#srchbtn').prop('disabled',false)" /> <input class="shadow" title="Search button" id="srchbtn" disabled type="submit" style="width:70px;text-align:center;padding:0;" value="Search" />
    </form>
    <?PHP
    $q = new Database('Notice');
    $q->query("select * from notice where date >= CURDATE() order by date");
    $q->execute();
    $result = $q->resultset();
    $count = $q->rowcount();
    print("<h3>");
    switch($count){
        case 0: echo "Sorry, no active notices at present"; break;
        case 1: echo "There is 1 active notice"; break;
        default: printf("There are %s active notices",$count); break;
    }
    print("</h3>");
    $temp = $result;
    usort($temp,'sortobj');
    print("<ul style=\"list-style-image:url('images/pin.png')\">");
    foreach($temp as $item){
        printf("<li><a href='#N%s'>%s</a></li>",$item->noticeid,$item->headline);
    }
    print("</ul>");
    foreach($result as $notice){
        $notice->output();
        echo "<a href='#top' title='Return to top of page'>Return to top</a><hr>";
    }
    $q->query("select * from notice where  date > DATE_SUB(CURDATE(), INTERVAL 90 DAY) order by date desc" );
    $q->execute();
    $items = $q->resultset();
    for($i=0;$i<$count;$i++){
        array_shift($items);
    }
    print("<h3 style='text-align:center;'>Older notices</h3>");
    $counter = 0;
    $now = strtotime(date("Y-m-d"));
    foreach($items as $notice){
        $notice->outputold();
        echo "<a href='#top' title='Return to top of page'>Return to top</a><hr>";
        $counter += 1;
    }
    echo "</div>";
    require 'bottom.html';
    ?>
    <script type="text/javascript">
        $('#srch').on('keyup',function(e){
            if(e.keyCode == 13){
                $('#srchbtn').trigger('click');
            }
        });
        //var text = "From time to time your Community Council is advised of events or circumstances relevent to the village. The current notices will be displayed here for your information. Note that notices not yet active will not appear in the side bar but can be viewed as all notices.";
        //$('#current').html("<p style='cursor:help;' onclick=\"$('#help').html(text);$('#help').show();\" onmouseleave=\"$('#help').hide();\">Notices<br /><br />What is this? <img src='images/help.png' /></p>");
        handleMenu($('#notices'));
    </script>
