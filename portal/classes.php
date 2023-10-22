<?PHP
// *EXCLUDE* cSpell:disable
date_default_timezone_set('Europe/London');  
function highlight($text_highlight, $text_search) {
    $str = preg_replace('#'. preg_quote($text_highlight) .'#i', '<span style="background-color:#FFFF66;font-weight:bold;">\\0</span>', $text_search);
    //$str = str_ireplace($text_highlight, '<span style="background-color:#ffff66;font-weight:bold;">'.$text_highlight."</span>",$text_search);
    return $str;
}
function showuntil($date){
    $today = date_create(date("Y-m-d"));
    $testdate = date_create($date);
    $diff = date_diff($testdate,$today);
    return $diff->d > 0 ? true : false;
}
function showbetween($start,$end){
    $today = date_create(date("Y-m-d"));
    $sdate = date_create($start);
    $edate = date_create($end);
    return $today >= $sdate && $today <= $edate ? true : false;
}
if (!function_exists('str_contains')) {
  function str_contains($haystack, $needle) {
      return $needle !== '' && mb_strpos($haystack, $needle) !== false;
  }
}
$demo = array('localhost','127.0.0.1','::1');
if(in_array($_SERVER['REMOTE_ADDR'], $demo)){
    // development
    define("DB_HOST","localhost");
    define("DB_USER","root");
    define("DB_PASS","mysql");
    define("DB_NAME","wyevalleycc");
}else{
    // live
    define("DB_HOST","db701010966.db.1and1.com");
    define("DB_NAME","db701010966");
    define("DB_USER","dbo701010966");
    define("DB_PASS","TCCdb!_1");
}
class Database{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $dbh;
    private $error;
    private $stmt;
    private $class;

    public function __construct($class = ""){
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION
        );
        $this->class = $class;
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        catch(PDOEXCEPTION $e){
            $this->error = $e->getMessage();
        }
    }
    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }
    public function bind($param, $value, $type = null){
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    public function execute(){
        return $this->stmt->execute();
    }
    public function resultset(){
        $this->execute();
        if($this->class !== ""){
            return $this->stmt->fetchAll(PDO::FETCH_CLASS,$this->class);
        }else{
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function rowCount(){
        return $this->stmt->rowCount();
    }
    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }
    public function beginTransaction(){
        return $this->dbh->beginTransaction();
    }
    public function endTransaction(){
        return $this->dbh->commit();
    }
    public function cancelTransaction(){
        return $this->dbh->rollBack();
    }
    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }
    public function setClass($class){
        $this->class = $class;
    }
    public function getData($query){
        $this->query($query);
        $this->execute();
        return $this->resultset();
    }
    public function getSingle($query){
      if($temp = $this->getData($query)){
          return $temp[0];
      }else{
          return false;
      }
  }
  public function upDate($query){
      $this->query($query);
      if(!$this->execute()){
          return false;
      }
      return true;
  }
}
// CONTAINS CLASSES FOR TINTERNCC SITE
// COUNCILLOR
class Councillor {
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
    function __construct(){
        if($this->photo===''){$this->photo = 'missing.jpg';}
        if($this->responsibility!=''){$this->responsibility = 'Responsibility: '.$this->responsibility;}
    }
    public function output(){
        if(strcmp($this->ward,$GLOBALS['ward'])!=0){
            printf("<div class='row u-full-width reversed center'>%s</div>",$this->wardname);
            $GLOBALS['ward'] = $this->ward;
        }
        printf("<div class='row councillor'><div class='three columns'><img src='images/%s' /></div><div class='nine columns'><span>%s %s</span></div></div>",$this->photo,$this->name,$this->surname);
    }
    public function displayforedit(){
        printf("<span style='width:200px;text-align:right'>Name</span><input type='text' size='30' name='name' value='%s' /><br />",$this->name);
        printf("<span style='width:200px;text-align:right'>SurName</span><input type='text' size='30' name='surname' value='%s' /><br />",$this->surname);
        print("<span style='width:200px;text-align:right'>Ward</span><select name='ward'>");
        printf("<option value=1 %s>Chapel Hill</option>",$this->ward==1?'selected':'');
        printf("<option value=2 %s>Clerk to the Council</option>",$this->ward==2?'selected':'');
        printf("<option value=3 %s>Penterry</option>",$this->ward==3?'selected':'');
        printf("<option value=4 %s>Tintern Parva</option>",$this->ward==4?'selected':'');
        printf("<option value=5 %s>Trellech Grange</option>",$this->ward==5?'selected':'');
        print("</select><br />");
        printf("<span style='width:200px;text-align:right'>email</span><input type='text' size='50' name='email' value='%s' /><br />",$this->email);
        printf("<span style='width:200px;text-align:right'>Address/span><input type='text' size='60' name='surname' value='%s' /><br />",$this->address);
        printf("<span style='width:200px;text-align:right'>Phone</span><input type='text' size='20' name='phone' value='%s' /><br />",$this->phone);
        printf("<span style='width:200px;text-align:right'>Photo</span><input type='text' size='30' name='photo' value='%s' /><br />",$this->photo);
        printf("<span style='width:200px;text-align:right'>Responsibility</span><input type='text' size='30' name='responsibility' value='%s' /><br />",$this->responsibility);
        print("<hr />");
    }
}
// EVENT
class Event {
    public $dtcode;
    public $title;
    public $date;
    public $location;
}
//MINUTE
class Minute {
    public $date;
    public $doc;
    public $agm = false;
    public function output(){
        printf("<li><a title='Show PDF of these minutes' class='nofancy' href='javascript:$(\"#content\").load(\"showpdf.php\",\"file=minutes/%s\")'>%s</a></li>",$this->doc,date('jS F Y',strtotime($this->date)));
    }
}
// BUDGET
class Budget {
    public $name;
    public $doc;
    public function output(){
        printf("<li><a class='nofancy' href='javascript:$(\"#content\").load(\"showpdf.php\",\"file=budgets/%s\")'>%s</a></li>",$this->doc,$this->name);
    }
}
// Account
class Account {
    public $name;
    public $doc;
    public function output(){
        printf("<li><a class='nofancy' href='javascript:$(\"#content\").load(\"showpdf.php\",\"file=accounts/%s\")'>%s</a></li>",$this->doc,$this->name);
    }
}
// Notice
class Notice {
    public $date;
    public $headline;
    public $noticeid;
    public $start;
    public function output(){
        $dt = substr($this->date,8,2)."/".substr($this->date,5,2)."/".substr($this->date,0,4);
        $ndate = strtotime($this->date);
        printf("<a id='N%s' title='target'><h3 class='newshead'>%s</h3></a>",$this->noticeid,$this->headline);
        if($ndate < strtotime("today")){
            echo "<span style='font-weight:bold;'>THIS NOTICE HAS EXPIRED</span><br />";
        }
        //echo "</p>";
        echo nl2br($this->notice);
        if($ndate < strtotime("today")){
            printf("<p style='font-size:0.8em;color:#336699;padding-top:10px;font-weight:bold;'>This notice expired on %s</p>", date("jS F Y", strtotime($this->date)));
        }else{
            printf("<p style='font-size:0.8em;color:#336699;padding-top:10px;'>This notice will expire on %s</p>", date("jS F Y", strtotime($this->date)));
        }
    }
    public function outputold(){
        $dt = substr($this->date,8,2)."/".substr($this->date,5,2)."/".substr($this->date,0,4);
        $ndate = strtotime($this->date);
        printf("<h3 class='newshead old'>%s</h3>",$this->headline);
        if($ndate < strtotime("today")){
            echo "<span class='old' style='font-weight:bold;'>THIS NOTICE HAS EXPIRED</span><br />";
        }
        //echo "</p>";
        echo "<span class='old'>".nl2br($this->notice)."</span>";
        if($ndate < strtotime("today")){
            printf("<p class='old' style='font-size:0.8em;padding-top:10px;font-weight:bold;'>This notice expired on %s</p>", date("jS F Y", strtotime($this->date)));
        }else{
            printf("<p class='old' style='font-size:0.8em;padding-top:10px;'>This notice will expire on %s</p>", date("jS F Y", strtotime($this->date)));
        }
    }
}
// PLANNING APPLICATION
class Application {
    public $number;
    public $reason;
    public $status;
    public $appdate;
    public $color;
    public $statuses;
    public $bground = '#ffffff';
    function __construct(){
      $this->statuses = array('Current'=>['#000000','#ffffff'],'Appeal'=>['#000000','#ffd9b3'],'Refused'=>['#ffffff','#cc0000'],'Approved'=>['#000000','#33ff00'],'Acceptable'=>['#000000','#33ff00'],'Discharged'=>['#000000','#33ff00'],'Withdrawn'=>['#000000','#dddddd'],'EIA  required'=>['#000000','#e5d0b5']);
      foreach($this->statuses as $key=>$value){
        if(str_contains($this->status,$key)){
          $this->color = $value[0];
          $this->bground = $value[1];
        }
      }
      /*switch($this->status){
            case 'Current' : $this->color = '#000000'; break;
            case 'Appeal' : $this->color = '#000000';
            $this->bground = '#ffd9b3'; break;
            case 'Refused' : $this->color = '#ffffff'; $this->bground = '#cc0000'; break;
            case 'Approved' : $this->color = '#000000'; $this->bground = '#33ff00'; break;
            case 'Acceptable' : $this->color = '#000000'; $this->bground = '#33ff00'; break; 
            case 'Discharged' : $this->color = '#000000'; $this->bground = '#33ff00'; break;
            case 'Withdrawn' : $this->color = '#000000'; $this->bground = '#dddddd'; break;
            case 'EIA required' : $this->color = '#000000'; $this->bground = '#e5d0b5';
        }*/
    }
    public function output(){
      if($this->code === 'TCC'){
        $code = "(Tintern CC)";
      }else{
        $code = "";
      }
        if($this->status === "EIA required"){
            $ad = date('d/m/Y',strtotime($this->appdate));
            printf("<tr style='border-bottom:1px solid #336699;'><td style='vertical-align:top;'>%s<br />%s</td><td>%s</td><td style='vertical-align:top;'><span style='color:%s;background:%s;' title='Environmental impact assessment required' >%s</span></td></tr>",$this->number,$code,$this->reason,$this->color,$this->bground,$ad,$this->appdate);
        }elseif($this->status === 'Approved' OR $this->status === 'Discharged' OR $this->status === "Acceptable"){
            $ad = date('d/m/Y',strtotime($this->appdate));
            printf("<tr style='border-bottom:1px solid #336699;'><td style='vertical-align:top;'>%s<br />%s</td><td>%s</td><td style='vertical-align:top;'><span style='color:%s;background:%s;' title='Application %s' >%s</span></td></tr>",$this->number,$code,$this->reason,$this->color,$this->bground,$this->status,$ad,$this->appdate);
        }elseif($this->status === 'Refused'){
            $ad = date('d/m/Y',strtotime($this->appdate));
            printf("<tr style='border-bottom:1px solid #336699;'><td style='vertical-align:top;'>%s<br />%s</td><td>%s</td><td style='vertical-align:top;'><span style='color:%s;background:%s;' title='Application refused' >%s</span></td></tr>",$this->number,$code,$this->reason,$this->color,$this->bground,$ad,$this->appdate);
        }elseif($this->status === 'Invalid'){
            printf("<tr style='border-bottom:1px solid #336699;'><td style='vertical-align:top;'>%s<br />%s</td><td>%s</td><td style='vertical-align:top;color:%s;background:%s' title='Application ruled as invalid'>%s</td></tr>",$this->number,$code,$this->reason,$this->color,$this->bground,$this->status);
        }elseif($this->status === 'Appeal'){
            $ad = date('d/m/Y',strtotime($this->appdate));
            printf("<tr style='border-bottom:1px solid #336699;'><td style='vertical-align:top;'>%s<br />%s</td><td>%s</td><td style='vertical-align:top;'><span style='color:%s;background:%s;' >%s</span></td></tr>",$this->number,$code,$this->reason,$this->color,$this->bground,$this->status);
        }elseif($this->status === 'Withdrawn'){
            printf("<tr style='border-bottom:1px solid #336699;'><td style='vertical-align:top;'>%s<br />%s</td><td>%s</td><td style='vertical-align:top;color:%s;background:%s' title='Application has been withdrawn'>%s</td></tr>",$this->number,$code,$this->reason,$this->color,$this->bground,$this->status);
        }else{printf("<tr style='border-bottom:1px solid #336699;'><td style='vertical-align:top;'>%s<br />%s</td><td>%s</td><td style='vertical-align:top;color:%s;background:%s' title='Application is being considered'>%s</td></tr>",$this->number,$code,$this->reason,$this->color,$this->bground,$this->status);
             }
    }
    public function matchoutput($match,$needle){
        if($this->status === 'Approved' OR $this->status === 'Discharged'){
            $ad = date('d/m/Y',strtotime($this->appdate));
            printf("<tr style='border-bottom:1px solid #336699;'><td style='vertical-align:top;'>%s</td><td>%s</td><td style='vertical-align:top;'><span style='color:%s;background:%s;' title='Application %s' >%s</span></td></tr>",highlight($needle,$this->number),highlight($needle,$this->reason),$this->color,$this->bground,$this->status,$ad,$this->appdate);
        }elseif($this->status === 'Refused'){
            $ad = date('d/m/Y',strtotime($this->appdate));
            printf("<tr style='border-bottom:1px solid #336699;'><td style='vertical-align:top;'>%s</td><td>%s</td><td style='vertical-align:top;'><span style='color:%s;background:%s;' title='Application refused' >%s</span></td></tr>",highlight($needle,$this->number),highlight($needle,$this->reason),$this->color,$this->bground,$ad,$this->appdate);
        }elseif($this->status === 'Invalid'){
            printf("<tr style='border-bottom:1px solid #336699;'><td style='vertical-align:top;'>%s</td><td>%s</td><td style='vertical-align:top;color:%s;background:%s' title='Application ruled as invalid'>%s</td></tr>",highlight($needle,$this->number),highlight($needle,$this->reason),$this->color,$this->bground,$this->status);
        }else{
            printf("<tr style='border-bottom:1px solid #336699;'><td style='vertical-align:top;'>%s</td><td>%s</td><td style='vertical-align:top;color:%s;background:%s' title='Application is being considered'>%s</td></tr>",highlight($needle,$this->number),highlight($needle,$this->reason),$this->color,$this->bground,$this->status);
        }
    }
}
// AGENDA
class Agenda {
    public $date;
    public $file;
    public function output(){
        printf("<li><a title='Show a PDF of this agendum' class='nofancy' href=\"javascript:$('#content').load('showpdf.php','file=agenda/%s');\">%s</a></li>",$this->file,date('jS F Y',strtotime($this->date)));
    }
    public function adminOutput(){
        printf("<tr><td>%s</td><td>%s</td><td>%s %s</td><tr>",$this->id,$this->date,$this->file,$this->fileok);
    }
}
// ASSET
class Asset {
    public $assetid;
    public $item;
    public $subitem;
    public $qty;
    public $location;
    public $value;
    public $total;
    public $risk;
    function __construct(){
        $this->total = $this->qty * $this->value;
    }
    public function output(){
        print("<tr>");
        if(strcmp($this->item,$GLOBALS['item'])!=0){
            printf("<td>%s</td>",$this->item);
            $GLOBALS['item'] = $this->item;
        }else{
            print("<td></td>");
        }
        printf("<td>%s</td><td>%s</td><td style='text-align:right;'>&pound;%s</td><td style='text-align:right;'>&pound;%s</td>",$this->location,$this->qty,number_format($this->value,2,'.',','),number_format($this->total,2,'.',','));
        print("</tr>");
    }
}
// ASSETRISK
class Assetrisk {
    public $riskid;
    public $assetid;
    public $risk;
    public $severity;
    public $likelihood;
}
// Menu items
class MenuItem {
    public $menuid;
    public $menutext;
    public $menupage;
    public function output(){
        $style = $this->menuid=='4'?"style='color:red;'":"";
        printf("<li %s id='%s'>%s</li>",$style,$this->menupage,$this->menutext);
    }
}
// User
class User {
    public $userid;
    public $username;
    public $realname;
    public $userhash;
}
// Ward
class Ward {
    public $wardid;
    public $wardname;
}
// Link
class Link {
    public $linkid;
    public $linktitle;
    public $linkdesc;
    public $linkurl;
    public $linkactive;
}
// visitor
class Visitor {
    public $id;
    public $visits;
}
// tinternnews
class Article {
    public $articleid;
    public $issue;
    public $headline;
    public $article;
}
// proposal
class Proposal {
    public $propid;
    public $date;
    public $closingdate;
    public $item;
    public $proposer;
    public $seconder;
    public $voted; // comma separated string of councillor ids
    public $agree;
    public $against;
    public $abstain;
    public $withdrawn;
    public $comments;
    public function display(){
        // make voters into array
        $voters = explode(",",$this->voted);
        print("<div style='border-bottom:1px solid black;'>");
        if(!in_array($_SESSION['userid'],$voters) && $this->withdrawn !== '1'){
            printf("Proposal: <a href=\"javascript:$('#frmid').val(%s);$('#frm').submit();\">%s</a><br />",$this->propid,$this->item);
           // printf("Proposal: <a href='showprop.php?id=%s'>%s</a><br />",$this->propid,$this->item);
        }else{
            printf("Proposal: %s <br /><span style='font-weight:bold;'>You have voted on this proposal</span><br />",$this->item);
        }
        printf("Proposed by: %s<br />",$this->proposer);
        printf("Seconded by: %s<br />",$this->seconder);
        printf("Date: %s<br />",date('jS F Y',strtotime($this->date)));
        printf("Closing date: %s<br />",date('jS F Y',strtotime($this->closingdate)));
        printf("<span style='color:green;'>For %s</span><br /><span style='color:red;'>Against %s</span><br /><span style='color:orange;'>Abstained %s</span>",$this->agree,$this->against,$this->abstain);
        if($this->withdrawn === '1'){
            print("<br />THIS PROPOSAL WAS WITHDRAWN BY THE PROPOSER");
        }elseif(strtotime("today") > strtotime($this->closingdate)){
            if($this->agree > $this->against){
                print("<br />This proposal was <span style='font-weight:bold;'>passed</span>");
            }else{
                print("<br />This proposal was <span style='font-weight:bold;'>rejected</span>");
            }
        }
        //printf("<br /><a href='showprop.php?id=%s&novote=1'>View full details</a>",$this->propid);
        printf("<br /><a href=\"javascript:$('#frmid').val(%s);$('#frm').submit();\">View full details</a>",$this->propid);
        print("</div><br />");
    }
    public function displayold(){
         // make voters into array
         $voters = explode(",",$this->voted);
         print("<div style='border-bottom:1px solid black;'>");
         if(!in_array($_SESSION['userid'],$voters)){
              printf("Proposal: %s<br />",$this->propid,$this->item);
         }else{
             printf("Proposal: %s <span style='font-weight:bold;'>You have voted on this proposal</span><br />",$this->item);
         }
         printf("Proposed by: %s<br />",$this->proposer);
         printf("Seconded by: %s<br />",$this->seconder);
         printf("Date: %s<br />",date('jS F Y',strtotime($this->date)));
         printf("Closing date: %s<br />",date('jS F Y',strtotime($this->closingdate)));
         printf("For %s<br />Against %s<br />Abstained %s",$this->agree,$this->against,$this->abstain);
         if($this->withdrawn === '1'){
            print("<br />THIS PROPOSAL WAS WITHDRAWN BY THE PROPOSER");
         }elseif($this->agree > $this->against){
             print("<br />This proposal was <span style='font-weight:bold;'>passed</span>");
         }else{
             print("<br />This proposal was <span style='font-weight:bold;'>rejected</span>");
         }
         //printf("<br /><a href='showprop.php?id=%s&novote=1&old=1'>View full details</a>",$this->propid);
         printf("<br /><a href=\"javascript:void(0);$('#frmid').val(%s);$('#frmold').prop('checked',true);$('#frm').submit();\">View full details</a>",$this->propid);
         print("</div><br />");
     }
}
// vote
class Vote {
    public $voteid;
    public $proposal;
    public $councillor;
    public $vote;
}
//comment
class Comment {
    public $commentid;
    public $propid;
    public $user;
    public $date;
    public $comment;
    public function display(){
        print("<div style='border-bottom:1px solid black;'>");
        printf("Entered by %s on %s<br />",$this->realname,date('jS F Y',strtotime($this->date)));
        printf("<p>%s</p>",$this->comment);
        print("</div>");
    }
}
?>
