<?PHP
date_default_timezone_set('Europe/London');
$demo = array('localhost','127.0.0.1','::1');
if(in_array($_SERVER['REMOTE_ADDR'], $demo)){
  // demo
  define("DB_HOST","localhost");
  define("DB_USER","root");
  define("DB_PASS","mysql");
  define("DB_NAME","tinterncc");
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
}
 // CONTAINS CLASSES FOR TINTERNCC SITE
 // COUNCILLOR
 class Councillor {
   public $id;
   public $name;
   public $surname;
   public $ward;
   public $email;
   public $address;
   public $phone;
   public $photo;
   public $responsibility;
   public $tccemail;
   public $email_password;
   public $wardname;
   function __construct(){
     if($this->photo===''){$this->photo = 'missing.jpg';}
     if($this->responsibility!=''){$this->responsibility = 'Responsibility: '.$this->responsibility;}
   }
   public function output(){
       if(strcmp($this->ward,$GLOBALS['ward'])!=0){
	printf("<div class='row u-full-width reversed center'>%s</div>",$councillor->wardname);
	$GLOBALS['ward'] = $this->ward;
      }
      printf("<div class='row councillor'><div class='three columns'><img src='images/%s' /></div><div class='nine columns'><span>%s %s</span></div></div>",$councillor->photo,$councillor->name,$councillor->surname);
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
   public $id;
   public $title;
   public $start;
   public $end;
   public $time;
   public $location;
   public $text;
   function __construct(){
     if($this->end === '0000-00-00'){$this->end = "";}
   }
 }
 //MINUTE
 class Minute {
   public $date;
   public $doc;
   public function output(){
     printf("<li><a class='nofancy' href='javascript:$(\"#content\").load(\"showpdf.php\",\"file=minutes/%s\")'>%s</a></li>",$this->doc,date('jS F Y',strtotime($this->date)));
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
   public $notice;
   public $start;
 }
 // PLANNING APPLICATION
 class Application {
   public $number;
   public $reason;
   public $status;
   public $appdate;
   public $color;
   function __construct(){
     switch($this->status){
       case 'Current' : $this->color = '#ffbf00'; break;
       case 'Appeal' : $this->color = '#ffbf00'; break;
       case 'Refused' : $this->color = 'red'; break;
       case 'Approved' : $this->color = '#3adf00'; break;
       case 'Discharged' : $this->color = '#3adf00'; break;
     }
   }
   public function output(){
      if($this->status === 'Approved' OR $this->status === 'Discharged'){
	$ad = date('d/m/Y',strtotime($this->appdate));
	printf("<tr style='border-bottom:1px solid cadetblue;'><td style='vertical-align:top;'><a style='text-decoration:none;' href='http://idox.monmouthshire.gov.uk/WAM/findCaseFile.do?appNumber=%s&appType=planning&action=Search' target='blank'>%s</td><td>%s</td><td style='vertical-align:top;color:%s' >%s</td></tr>",$this->number,$this->number,$this->reason,$this->color,$ad,$this->appdate);	
      }elseif($this->status === 'Refused'){
	$ad = date('d/m/Y',strtotime($this->appdate));
	printf("<tr style='border-bottom:1px solid cadetblue;'><td style='vertical-align:top;'><a style='text-decoration:none;' href='http://idox.monmouthshire.gov.uk/WAM/findCaseFile.do?appNumber=%s&appType=planning&action=Search' target='blank'>%s</td><td>%s</td><td style='vertical-align:top;color:%s' >%s</td></tr>",$this->number,$this->number,$this->reason,$this->color,$ad,$this->appdate);	
      }else{
	printf("<tr style='border-bottom:1px solid cadetblue;'><td style='vertical-align:top;'><a style='text-decoration:none;' href='http://idox.monmouthshire.gov.uk/WAM/findCaseFile.do?appNumber=%s&appType=planning&action=Search' target='blank'>%s</td><td>%s</td><td style='vertical-align:top;color:%s'>%s</td></tr>",$this->number,$this->number,$this->reason,$this->color,$this->status);
      }
   }
  }
  // AGENDA
  class Agenda {
    public $date;
    public $file;
    public function output(){
      printf("<li><a class='nofancy' href=\"javascript:$('#content').load('showpdf.php','file=agenda/%s');\">%s</a></li>",$this->file,date('jS F Y',strtotime($this->date)));
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
?>
