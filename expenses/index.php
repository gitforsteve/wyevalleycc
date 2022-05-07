<?PHP
require 'classes.php';

?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <script type="text/javascript" src="jquery-3.1.1.min.js"></script>
    <script type='text/javascript'>
      $(document).ready(function(){
	$('#login').on('click',function(){
	  $('#loginok').load('checkpw.php',$('#signon').serialize());
	});
	$('#pword').keydown(function(e){
	  if(e.which === 13){
	    $('#login').trigger('click');
	  }
	});
      });
    </script>
  </head>
  <body>
    <form id="signon">
      <table>
	<tr><td>User</td><td><input type="text" id="username" name="username" /></td></tr>
	<tr><td>Password</td><td><input type="password" id="pword" name="pword" /></td></tr>
	<tr><td colspan="2"><input type="button" value="Sign in" name='login' id='login' /></td></tr>
      </table>
    </form>
    <div id='loginok'></div>
    <?PHP
    ?>
  </body>
</html>
