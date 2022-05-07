<?PHP
session_start();

include_once "header.php";
$n = explode(' ',$_SESSION['user']);
$fname = $n[0];
?>
<h1>Welcome <?=$fname?></h1>
<p>This is the voting portal for Tintern Community Council</p>

<?PHP
include_once "footer.php"
?>