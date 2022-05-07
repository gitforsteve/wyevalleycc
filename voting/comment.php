<?PHP
include_once "header.php";
?>
<h1>Add a comment</h1>
<p>Please select a current proposal</p>
<?PHP
$q = new Database('Proposal');
$q->query("select * from proposal where closingdate >= CURRENT_DATE");
$q->execute();
if($q->rowCount === 0){
    echo "Sorry, no current proposals";
    exit;
}
$result = $q->resultset();

?>
<select name="proplist" id="proplist" >
    <option value=0>Please select</option>
    <?PHP
    foreach($result as $proposal){
        printf("<option value=%s>%s</option>",$proposal->propid,$proposal->item);
    }
    ?>
</select>
<br />
<div id="commentbox" style="padding:30px;width:50vw;background-color:lightgray;margin:0 auto;display:none;"></div>
<?PHP
include_once "footer.php";
?>
<script>
    $('#proplist').on("change",function(){
        if($('#proplist').val() !== '0'){
            text = $('#proplist option:selected').html();
            $('#commentbox').load('commentform.php?t='+encodeURI(text+'&v='+$('#proplist').val()));
            $('#commentbox').css('display','block');
        }else{
            $('#commentbox').empty();
            $('#commentbox').css('display','none');
        }
    });
</script>