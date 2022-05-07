<?PHP
//cSpell:disable
require 'classes.php';
$title = "Wye Valley Community Council";
$desc = "The home page of the Wye Valley Community Council";
$keywords = "Wye Valley Community Council representing people of Tintern and Llandogo";
include "top.html";
?>
<div class="six columns" style="background:white; padding-left:10px;" id="content">
    <h1>Welcome</h1>
    <p>Welcome to the web site of your local Community Council. In May 2022 part of the wards of Tintern Community Council and Trellech United Community Council were merged to form your new Council.</p>
    <p>Your Community Council is here to help you and our fellow villagers enjoy the wonderful surroundings with which we are blessed.</p>
    <p>While the Councillors are elected to represent their particular ward (Tintern Ward and Llandogo Ward) they are, of course, able to represent anyone in either ward. Your Councillors are <a href="about.php" title="Link to list of Councillors">listed here</a>. Monthly meetings are held to which villagers are invited and all minutes are recorded.</p>
    <p class="center">For any concerns regarding this site<br />please <a href="contact.php?id=se">contact Steve Evans</a></p>
    <p class="blue">We encourage you to use the contact page on this site to contact your Councillors. Any email sent via this site will be copied to the Clerk who will be able to respond in the event of holiday or sickness.</p>
    <div class="rounded shadow" id="popup" style="position:absolute;top:300px;left:100px;width:600px;border:1px solid #336699;background:white;display:none;"></div>
    <script type="text/javascript">
        handleMenu($('#home'));
        $('#popup').on('click',function(){
            $(this).hide();
        });
    </script>
</div>
<aside class="three columns">
    <h2 class="u-full-width" style="color:white;background:#336699;text-align:center;font-weight:bold;font-size: 2rem;letter-spacing:1px;">NOTICES</h2>
    <div>
        <br />
        <?PHP
        $q = new Database('Notice');
        $q->query("select count(noticeid) as count from notice where date >= CURDATE() order by start");
        $q->execute();
        $result = $q->single();
        $count = $result['count'];
        printf("<p style='font-weight:bold;'><a href='notices.php' title='Link to view all notices'>");
        switch($count){
            case 0: print("No new items"); break;
            case 1: print("There is 1 active notice"); break;
            default: printf("There are %s active notices, the latest shown here</a></p>",$count); break;
        }
        print("</p>");
        $q->query("SELECT * FROM notice WHERE (start <= CURDATE() AND date >= CURDATE()) OR (start = '0000-00-00' and date >= CURDATE()) order by noticeid desc");
        $q->execute();
        $items = $q->resultset();
        if($q->rowCount()===0){
            print("No new items");
        }else{
            $counter = 0;
            foreach($items as $item){
                $dt = substr($item->date,8,2)."/".substr($item->date,5,2)."/".substr($item->date,0,4);
                if($counter < 3){
                    printf("<a title='See the full notice' class='newshead' href=\"singlenotice.php?item=%s');\">",$item->noticeid);
                    echo $item->headline;
                    echo "</a><br />";
                    echo "<span class='para'>".substr(strip_tags($item->notice),0,50)."...</span>";
                    if($item->start !== '0000-00-00'){
                        $now = new DateTime();
                        $start = new DateTime($item->start);
                        $end = new DateTime($item->date);
                        date_add($end,date_interval_create_from_date_string("1 day"));
                    }
                    echo "<hr>";
                }
                $counter += 1;
            }
        }
        ?>
    </div>
</aside>
<?PHP
include 'bottom.html';
?>
<script type="text/javascript">
    $.ajax('visits.php');
</script>
