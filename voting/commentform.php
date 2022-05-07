<?PHP
session_start();
if(!isset($_SESSION['userid']) AND strpos($_SERVER['PHP_SELF'],"index") === false){
    header("location: index.php");
}
include_once "../classes.php";
printf("<p>Commenting on <span style='font-weight:bold;'>%s</span></p>",$_GET['t']);
?>

<form id="comform" autocomplete="off">
    <input type="hidden" name="propno" value="<?=$_GET['v']?>">
    <textarea name="com" cols="60" rows="10"></textarea><br />
    <input type="submit" value="ADD COMMENT" />
</form>
<div id="message"></div>
<script>
    $('#comform').on("submit",function(e){
        e.preventDefault();
        $.ajax({
            url: 'addcomment.php',
            data: $(this).serialize(),
            method: 'POST',
            success: function(data){
                $('#message').html(data);
            }
        });

    })
</script>