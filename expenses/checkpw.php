<?PHP
require 'classes.php';

$q = new Database();
$q->query("select * from user where username = :user");
$q->bind(':user', $_REQUEST['username']);
$q->execute();
if($q->rowCount() !== 1){
  exit();
}
$user = $q->single();
if(password_verify($_REQUEST['pword'], $user['userhash'])){
  ?>
<p><br />Please enter details for your claim</p>
<form id='expense' name='expense' action="expenses.php" method="POST" target="_blank">
  <input type="hidden" id="name" name="name" value="<?=$user['realname']?>" />
  <input type="hidden" id="userid" name="userid" value="<?=$user['userid']?>" />
  <table>
    <tr><td>Councillor</td><td><?=$user['realname']?></td><td></td></tr>
    <tr><td>Date or period</td><td><input type='text' id='date' name='date' /></td><td></td></tr>
    <tr><td valign="top">Description</td><td colspan="2"><textarea id='description' name='description' cols="40" rows="5"></textarea>
    <tr><td>Fares</td><td><input type="text" id="fares" name="fares"></td><td>Receipt attached <input type="checkbox" id="farerect" name="farerect" /></td></tr>
    <tr><td>Vehicle mileage</td><td><input type="text" id="miles" name="miles" /></td><td></td></tr>
    <tr><td>Parking fees</td><td><input type="text" id="parking" name="parking"></td><td>Receipt attached <input type="checkbox" id="parkrect" name="parkrect" /></td></tr>
    <tr><td>Accommodation</td><td><input type="text" id="accommodation" name="accommodation" /></td><td></td></tr>
    <tr><td>Food &amp; drink</td><td><input type="text" id="food" name="food" /></td><td></td></tr>
  </table>
  <p>ENTER AMOUNTS WITH NO POUND SIGN</p>
  <p>Fares are fares for coach, train, bus, etc., and parking fees and receipts must be scanned and sent<br />Mileage is actual mileage for the journey(s)<br />Parking fees do <span style="font-weight:bold;">not</span> include parking fines<br />Accommodation receipts must be scanned and sent</p>
  <p style="font-weight:bold">IMPORTANT</p>
  <p>By submitting this form you are certifying that the amounts were expended while on Tintern Community Council business.</p>
  <p>A PDF of the form will be produced and this should be saved and sent to the Clerk.</p>
  <input type="submit" id="printform" name="printform" value="Produce form" />
</form>
  <?PHP
}
?>
