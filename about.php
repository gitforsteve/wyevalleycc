<?PHP
// cSpell:disable
$title = "Councillors and wards";
$desc = "Find out who your Councillors are and the wards they represent";
$keywords = "Tintern Llandogo community councillors, wards, represent";
require 'top.html';
require 'MyCSV.class.php';
//if(!class_exists('Database')){
//  require 'classes.php';
//}
//<!--text-->

/*$database = new Database("Councillor");
if(isset($_GET['ward'])){
  $sql = sprintf("SELECT * FROM councillor c left join ward w on c.ward = w.wardid where c.ward=%s order by w.wardname, c.surname",$_GET['ward']);
  $councillors = $database->getData($sql);
  //$database->query("SELECT * FROM councillor c left join ward w on c.ward = w.wardid where c.ward=:ward order by w.wardname, c.surname");  
  //$database->bind(':ward',$_GET['ward']);
}else{
  $councillors = $database->getData("SELECT * FROM ward w left join councillor c on c.ward = w.wardid order by w.wardname desc, c.surname");
}
//$database->execute();
//$councillors = $database->resultset();
*/
$councillors = new MyCSV('data/councillor.csv');
$councillors->sort('ward surname');
$wards = ["","Tintern","Llandogo","Clerk to the Council","County Councillor"];
if(!isset($_GET['ward'])){
?>
<div class="nine columns" style="padding-left:10px;">
  <h1 class="limit-min-max">About us</h1>
  <p>The Wye Valley CC consists of two wards, the villages of Tintern and Llandogo. Each of these wards has a number of Community Councillors (4 in Tintern and 3 in Llandogo) representing the interests of their ward but all representing both villages. The Councillors are shown below but, don't forget, you can contact any one of them regardless of the ward in which you live.</p>
 <?PHP
  }
  $thisward = "";
  while($councillor = $councillors->each()){
    $stat = $councillor['status'] > "" ? "(".$councillor['status'].")" : "";
    $address = implode("<br />",explode(',',$councillor['address']));
    if(strcmp($wards[$councillor['ward']],$thisward)!=0){
  	  printf("<div class='row u-full-width reversed center'>%s</div>",$wards[$councillor['ward']]);
      $thisward = $wards[$councillor['ward']];
    }
	  switch(substr($councillor['phone'],0,2)){
	    case '01': $phone = "<img src='images/phone.png' style='display:in-line;' alt='landline phone' role='presentation' />"; break;
	    case '07': $phone = "<img src='images/mobile.png' style='display:in-line;' alt='mobile phone' role='presentation' />"; break;
	    default: $phone = "";
	  }
	  if($councillor['surname'] === "ZZZ"){
	    print("<div class='row councillor u-full-width' style='text-align:center;'><strong>VACANCY</strong><p>If you would like information on becoming<br />a Community Councillor please contact the Clerk</p></div>");
	  }else{
  ?>
	    <div class='row councillor' style="display:flex">
	      <div class='four columns'>
	        <img class="u-full-width" src="images/<?=$councillor['photo']?>" alt="Photo of Councillor <?=$councillor['name']?> <?=$councillor['surname']?>" />
	      </div>
	      <div class="eight columns">
	        <span><?=$councillor['name']?> <?=$councillor['surname']?> </span><?=$stat?><br /><?=$address?><br /><?=$phone?> <?=$councillor['phone']?><br /><br />
          <button class='email shadow' style='text-align:center;font-weight:bold;width:30vw;font-size:1.2vw;' type='button' id="<?=$councillor['code']?>">Send email to <?=$councillor['name']?></button>
          <br />
          <?PHP
            if(strlen($councillor['responsibility']) > 0){
              printf("Responsibility: %s<br /><br />",$councillor['responsibility']);
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
