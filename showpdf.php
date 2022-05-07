<?PHP
$file = $_REQUEST['file'];
if(file_exists($file)){
  printf("<div><object data='%s' type='application/pdf' width='100%%' height='600'><p>Your browser doesn't support this method of displaying PDF files. Please click <a href='%s' target='blank'>here</a> to view it in a new tab or window, depending on your settings.</p></object></div>",$file,$file);
}else{
?>
 <script type="text/javascript">
    $('#content').load('nodoc.html');
  </script>
  <?PHP
}
?>
