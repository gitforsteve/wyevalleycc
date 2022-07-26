<?PHP
// cSpell:disable
$mailpage = true;
function isValid() 
{
    try {

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = ['secret'   => '6LfVv88fAAAAAASBuLqOefRu6X7q4g202wKYHcdt',
                 'response' => $_POST['g-recaptcha-response'],
                 'remoteip' => $_SERVER['REMOTE_ADDR']];
                 
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data) 
            ]
        ];
    
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return json_decode($result)->success;
    }
    catch (Exception $e) {
        return null;
    }
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if (!function_exists('str_contains')) {
  function str_contains($haystack, $needle) {
      return $needle !== '' && mb_strpos($haystack, $needle) !== false;
  }
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$title = "Email contact form";
$desc = "Contact us today using our form to send an email to any of our Councillors";
$keywords = "Wye Valley council contacts, councillors";
require "top.html";
require "classes.php";
require "Exception.php";
require "PHPMailer.php";
require "SMTP.php";
require "MyCSV.class.php";
if(isset($_GET['id'])){
  // send to me
  $id = $_GET['id'];
}elseif(isset($_POST['id'])){
  // send to a specific councillor
  $id = $_POST['id'];
}elseif(isset($_POST['name'])){
  // process the form
  // validation here
  $errorMessage = "";
  $error = 1;
  if(test_input($_POST['name']) > ''){
    $name = $_POST['name'];
    $error = 0;
  }else{
    $errorMessage .= "Please enter your name";
    $error = 1;
  }
  if(test_input($_POST['emailFrom']) > ''){
    $emailFrom = $_POST['emailFrom'];
    $error = 0;
  }else{
    $errorMessage .= "<br />Your email address is required";
    $error = 1;
  }
  if(test_input($_POST['emailTo']) > ''){
    $emailTo = $_POST['emailTo'];
    $error = 0;
  }else{
    $errorMessage .= "<br />You haven't selected a recipient";
    $error = 1;
  }
  if(test_input($_POST['subject']) > ''){
    $subject = $_POST['subject'];
    $error = 0;
  }else{
    $errorMessage .= "<br />Please provide a subject";
    $error = 1;
  }
  if(test_input($_POST['message']) > ''){
    $message = $_POST['message'];
    $error = 0;
  }else{
    $errorMessage .= "<br />You haven't included a message";
    $error = 1;
  }
  if(isset($_POST['email_me'])){ 
    $error = 1; 
    $errorMessage = ""; 
  }
  if(isset($_POST['g-recaptcha-response'])){
    $captcha = $_POST['g-recaptcha-response'];
  }
  if(!$captcha){
    $errorMessage = "Please check the captcha form";
    $error - 1;
  }else{
    if(!isValid()){
      $errorMessage = "Sorry, the captcha was rejected";
      $error = 1;
    }
  }
  $telephone = test_input($_POST['telephone']);
  $address = test_input($_POST['address']);
  $reply = test_input($_POST['reply']);
    if($error === 0){
      $mail = new PHPMailer(TRUE);
      $mail->isHTML(TRUE);
      try {
        $mail->setFrom($emailFrom, $name);
        $mail->addAddress($emailTo,$emailTo);
        if(!str_contains($emailTo,'clerk')){
          // disable for testing
          $mail->addAddress("clerk@wyevalleycc.co.uk","Clerk");
        }
        if(isset($_POST['copy'])){
          $mail->addAddress($emailFrom,$name);
        }
        $mail->Subject = $subject;
$body = <<<HERE
<html>
  <body>
    <p>Message from the Wye Valley Community Council web site</p>
    <p>From: $name<br />
    Telephone: $telephone<br />
    Address: $address<br />
    Message: $message</p>
    <p style="font-weight:bold;">Reply requested via $reply</p>
  </body>
</html>
HERE;
      $mail->Body = $body;
      $mail->send();
      $errorMessage = "Thank you, your email has been sent";
    } catch (Exception $e){
      $errorMessage = "Sorry, your email could not be sent (". $mail->ErrorInfo.")";
    }
  }
}

//$q = new Database('Councillor');
//$councillors = $q->getData("select * from councillor c left join ward w on c.ward=w.wardid order by surname, name");
$councillors = new MyCSV('data/councillor.csv');
$councillors->sort('surname');

?>
<div class="eight columns" id="content" style="border-radius:0 0 15px 0; ">
  <div class="row">
    <h1 class="limit-min-max">Contact Us</h1>
    <p>Use this form to send an email to any of the Councillors. Messages sent via this form are automatically copied to the Clerk to ensure that appropriate action is taken in the event of holiday or sickness.</p>
    <p>If you prefer you can contact our Clerk by writing to The Poplars, Whitelye, NP16 6NP<br /></p>
    <p class="newshead">Wye Valley Community Council will never share the information given on this form or in any other way unless you give your express permission and that this is necessary for the response. If this is the case you will be contacted for your permission.</p>
  </div>
  <div class="row" style="color: red; font-weight: bold; text-align:center;"><?=$errorMessage?> <?=$unsent?></div>
  <div class="row">
    <form id="contactForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
      <label for="name">Your name</label>
      <input class="u-full-width" type="text" name="name" id="name" placeholder="Your full name (required)" value="<?=$_POST['name']?>">
      <label for="emailFrom">Your email address</label>
      <input class="u-full-width" type="email" name="emailFrom" id="emailFrom" placeholder="Your valid email address (required)" value="<?=$_POST['emailFrom']?>">
      <label for="telephone">Phone or mobile</label>
      <input style="width:35%;" type="text" id="telephone" name="telephone" placeholder="If you want a phone reply">
      <label for="address">Address</label>
      <textarea class="u-full-width" id="address" name="address" placeholder="Please enter a valid address"></textarea>
      <label for="emailTo">Email to</label>
      <select class="u-full-width" name="emailTo" id="emailTo">
        <option value="">--- Please choose (required, for general email choose the Clerk) ---</option>
        <?php
        while($councillor = $councillors->each()){
          if($councillor['surname'] != "ZZZ"){
            $sel = "";
            switch($councillor['ward']){
              case 1: $wardname = "Tintern"; break;
              case 2: $wardname = "Llandogo"; break;
              case 3: $wardname = "Clerk to the Council"; break;
              case 4: $wardname = "County Councillor"; break;
            }
            if($councillor['surname'] > '' or $id > ''){
              if($councillor['code'] === $id or $councillor['email'] === $_POST['emailTo']){
              $sel = "selected";
            }
            printf("<option value='%s' %s>%s %s (%s)</option>",$councillor['email'],$sel,$councillor['name'],$councillor['surname'],$wardname);
          }
        }
      }
       ?>
      </select>
      <label for="subject">Subject</label>
      <input class="u-full-width" type="text" name="subject" id="subject" placeholder="Please enter the subject of your email (required)" value="<?=$_POST['subject']?>">
      <label for="message">Your message</label>
      <textarea class="u-full-width" name="message" id="message" placeholder="Please enter your message (This box can be expanded as required (required))"><?=$_POST['message']?></textarea>
      <?php
        $check = "";
        if(isset($_POST['copy'])){
          $check = "checked";
        }
      ?>
      <label>
        <input type="checkbox" id="copy" name="copy" <?echo $check?>>
        <span class="label-body">Would you like a copy sent to your email address?</span>
      </label>
      <p>How would you like the reply?<br />
      <input type="radio" name="reply" id="emailresp" value="email" checked > email<br />
      <?
        if($reply === "phone"){
          $rep = 'checked';
        }else{
          $rep = "";
        }
      ?>
	    <input type="radio" name="reply" id="phone" value="phone" <?=$rep?>> phone (please provide your phone number)<br />
      <?
        if($reply === "visit"){
          $rep = 'checked';
        }else{
          $rep = "";
        }
      ?>
      <input type="radio" name="reply" id="visit" value="visit" <?=$rep?>> a visit (please provide your postal address)<br />
      <?
        if($reply === "none"){
          $rep = 'checked';
        }else{
          $rep = "";
        }
      ?>
      <input type="checkbox" name="email_me" style="display:none; !important" tabindex="-1" autocomplete="off" placeholder="If you are human do not check this box" >
      <input type="radio" name="reply" id="none" value="none" <?=$rep?>> no reply required thanks</p>
      <!--div class="g-recaptcha" data-sitekey="6LfVv88fAAAAANvEHvw8aNvhT_qrtvBHoAA4Z71s"></div-->
      <br />
      <button class="shadow g-recaptcha" name="submit" type="button" date-sitekey="reCAPTCHA_site_key" data-callback="onSubmit" data-action="submit">Send Email</button>   
    </form>
  </div>
</div>
<?php
require "bottom.html";
?>
<script>
  handleMenu($('#contact'));
  function onSubmit(token){
    $('#contactForm').submit();
  }
</script>