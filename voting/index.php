<?PHP
include_once "header.php";
$_SESSION = array();
?>
    <form id="login" autocomplete="off">
        <label for="name">Your name</label><input type="text" id="name" name="name" ></label><br /><br />
        <label for="pword">Password</label><input type="password" id="pword" name="pword" ><br /><br />
        <input type="submit" value="LOG ON" />
    </form>
<?PHP
include_once "footer.php";
?>