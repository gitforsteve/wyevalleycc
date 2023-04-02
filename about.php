<?PHP
// cSpell:disable
function mysort($a,$b){
  return $a->surname <=> $b->surname;
}
require "steveCSV.php";
$title = "Councillors and wards";
$desc = "Find out who your Councillors are and the wards they represent";
$keywords = "contact Tintern Llandogo community councillors, wards, represent";
require 'top.html';
/******************************* */
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
$csv = new steveCSV('data/councillor.csv');
$csv->sortfield = "ward";
$csv->sort();
/**** GROUP INTO WARDS */
$wards = [];
foreach($csv->data as $councillor){
  $wards[$councillor->ward][] = $councillor;
}

usort($wards['Llandogo'],"mysort");
usort($wards['Tintern'],"mysort");
$councillors = [];
foreach($wards['Tintern'] as $item){
  $councillors[] = $item;
}

foreach($wards['Llandogo'] as $item){
  $councillors[] = $item;
}
$councillors[] = $wards['Clerk to the Council'][0];
$councillors[] = $wards['County Councillor'][0];
/******************************** */
if(!isset($_GET['ward'])){
?>
<div class="nine columns" style="padding-left:10px;">
  <h1 class="limit-min-max">About us</h1>
  <p>The Wye Valley CC consists of two wards, the villages of Tintern and Llandogo. Each of these wards has a number of Community Councillors (4 in Tintern and 3 in Llandogo) representing the interests of their ward but all representing both villages. The Councillors are shown below but, don't forget, you can contact any one of them regardless of the ward in which you live.</p>
 <?PHP
  }
  $thisward = "";
  foreach($councillors as $councillor){
    //while($councillor = $councillors->each()){
    $address = implode("<br />",explode(',',$councillor->address));
    if($thisward !== $councillor->ward){
 	    printf("<div class='row u-full-width reversed 
    center'>%s</div>",$councillor->ward);
      $thisward = $councillor->ward;
    }
	  switch(substr($councillor->phone,0,2)){
	    case '01': $phone = "<img src='images/phone.png' style='display:in-line;' alt='landline phone' role='presentation' />"; break;
	    case '07': $phone = "<img src='images/mobile.png' style='display:in-line;' alt='mobile phone' role='presentation' />"; break;
	    default: $phone = "";
	  }
	  if($councillor->surname === "ZZZ"){
	    print("<div class='row councillor u-full-width' style='text-align:center;'><strong>VACANCY</strong><p>If you would like information on becoming<br />a Community Councillor please contact the Clerk</p></div>");
	  }else{
  ?>
	    <div class='row councillor' style="display:flex">
	      <div class='four columns'>
	        <img class="u-full-width" style="padding-right:10px;" src="images/<?=$councillor->photo?>" alt="Photo of Councillor <?=$councillor->name?> <?=$councillor->surname?>" />
	      </div>
	      <div class="eight columns">
	        <span><?=$councillor->name?> <?=$councillor->surname?> </span><?=$stat?><br /><?=$address?><br /><?=$phone?> <?=$councillor->phone?><br /><br />
          <button class='email shadow' style='text-align:center;font-weight:bold;width:30vw;font-size:1.2vw;' type='button' id="<?=$councillor->code?>">Send email to <?=$councillor->name?></button>
          <br />
          <?PHP
              if($councillor->responsibility > ''){
              printf("<span style='font-size:80%%;font-weight:normal;'>Responsibility: %s</span><br /><br />",$councillor->responsibility);
            }
          ?>
	      </div>
	      <br />
	    </div>
	  <?PHP
	  }
  }
  if(isset($_GET['ward'])){
    if($database->rowcount()==0){
	    print("<div class='row councillor u-full-width' style='text-align:center;'><strong>VACANCY</strong><p>If you would like information on becoming a Community Councillor please contact the Clerk</p></div>");
    }
     print("<br /><div class='row'><button class='showall' style='font-weight:bold;' type='button'>Show All</button></div>");
  }
  ?>
  <!--endtext-->
  <div style="visibility:hidden;">
    <form id="idform" action="contact.php" method="POST">
      <label for='id'>Id</label>
      <input type="text" id="id" name="id" value=<?=$id?>/>
    </form>
  </div>
</div> 
<?PHP
require 'bottom.html';
?>
<script type='text/javascript' src='js/jquery-3.1.1.min.js'></script>
<script type='text/javascript'>
  handleMenu($('#about'));
  $('button.email').on("click",function(){
    $('#id').val($(this).attr('id'));
    var id = $(this).attr('id');
    //$(location).attr('href','contact.php?id='+id);
    $('#idform').submit();
  });
  $('button.showall').on("click",function(){
    $('#content').load('about.php');
  });
</script>
