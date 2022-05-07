<?PHP
include_once "header.php";
?>
<form id="prop" autocomplete="off">
    <input type="hidden" name="proposer" value="<?=$_SESSION['userid']?>" />
    <inout type="hidden" name="seconder" value="" />
    <label for="date">Date</label><input class="date" id="date" name="date" /><br /><br />
    <label for="closingdate">Closing date</label><input class="date" id="closingdate" name="closingdate" /><br /><br />
    <label for="proposal">Proposal</label><textarea id="proposal" name="proposal" cols="29" rows="5"></textarea><br /><br />
    <?PHP
        if($_SESSION['userid'] !== '6'){
            print("Vote for now? <input type='checkbox' id='vote' name='vote' /><br />");
        }
    ?>
    <input type="submit" value="ADD PROPOSAL" />
</form>
<?PHP
include_once "footer.php";
?>