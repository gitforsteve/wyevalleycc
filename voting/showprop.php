<?PHP
include_once "header.php";
$old = isset($_POST['old']);
$q = new Database('Proposal');
$q->query("select * from proposal where propid = ".$_POST['id']);
$q->execute();
$result = $q->single();
$voters = explode(",",$result['voted']);

$voted = in_array($_SESSION['userid'],$voters);
$q->setClass('Comment');
$q->query("SELECT c.*, u.realname FROM `comment` c join user u on c.user=u.userid where c.propid = ".$_POST['id']);
$q->execute();
$comments = $q->resultset();
?>
<div style="width:50vw;background-color:lightgray;margin:0 auto;padding:30px;">
     <p>Proposal:<br /><span style='font-weight:bold;'><?=$result['item']?></span></p>
    <p>Proposed by <?=$result['proposer']?> on <?=date('jS F Y',strtotime($result['date']))?></p>
    <p>Seconded by <?=$result['seconder']?></p>
    <p>Closes on <?=date('jS F Y',strtotime($result['closingdate']))?></p>
    <?PHP
    if($result['withdrawn']){
        echo "<p style='font-weight:bold;'>THIS PROPOSAL HAS BEEN WITHDRAWN</p>";
    }else{
        printf("<p>Agreed %s Against %s Abstained %s</p>",$result['agree'],$result['against'],$result['abstain']);
    }
    ?>
    <form id="voteform">
        <input type="hidden" name="propid" value="<?=$_POST['id']?>">
        <?PHP
        if($voted){
            echo("<p style='font-weight:bold;'>You have voted on this proposal</p>");
        }
        if(!$voted AND $result['withdrawn'] === "0" AND !$old){
            ?>
            <input type="radio" name="vote" value="agree"> Agree <input type="radio" name="vote" value="against"> Against <input type="radio" name="vote" value="abstain"> Abstain<br /><br />
            <input type="submit" value="VOTE">
            <?PHP
        }
        if($old){
            if($result['agree'] > $result['against']){
                print("<br />This proposal was <span style='font-weight:bold;'>passed</span>");
            }else{
                print("<br />This proposal was <span style='font-weight:bold;'>rejected</span>");
            }
        }
        ?>
        <br /><button onclick="window.location='proposals.php'">BACK</button>
    </form>
    <?PHP
        if(!$old AND $result['proposer'] === $_SESSION['user'] AND !isset($_GET['old']) AND $result['withdrawn'] === '0'){
            ?>
            <form id="withdrawfrm">
                <input type="hidden" name="currentId" value="<?=$_GET['id']?>">
                <br /><input type="submit" value="WITHDRAW PROPOSAL">
            </form>
            <?PHP
        }
        if(count($comments) > 0){
            print("<p style='font-weight:bold;'>Comments</p>");
            foreach($comments as $comment){
                $comment->display();
            }
        }
    ?>
</div>

<?PHP
include_once "footer.php";
?>