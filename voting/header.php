<?PHP
session_start();
if(!isset($_SESSION['userid']) AND strpos($_SERVER['PHP_SELF'],"index") === false){
    header("location: index.php");
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
include_once "../classes.php";
?>
<HTML>
    <HEAD>
        <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
        <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
        <script>
        $(document).ready(function(){
            $('#login').on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url: 'checklogin.php',
                    data: $(this).serialize(),
                    method: 'POST',
                    success: function(data){
                        $('#message').html(data);
                        if(data === "You are in"){
                            window.location.href = "welcome.php";
                        }
                    }
                });
            });
            $('#prop').on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url: 'saveprop.php',
                    data: $(this).serialize(),
                    method: 'POST',
                    success: function(data){
                        $('#message').html(data);
                    }
                });
            });
            $('#voteform').on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url: 'vote.php',
                    data: $(this).serialize(),
                    method: 'POST',
                    success: function(data){
                        window.location.href = "proposals.php";
                        //$('#message').html(data);
                    }
                });
            });
            $('#withdrawfrm').on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url: 'withdraw.php',
                    data: $(this).serialize(),
                    method: 'POST',
                    success: function(data){
                        $('#message').html(data);
                    }
                });
            })
            $('.date').datepicker({
                dateFormat: "dd/mm/yy"
            });
        });
    </script>
    <link rel="stylesheet" href="../css/jquery-ui.css" />
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        form {
            padding: 30px;
            width: 400px;
            margin:0 auto;
            background-color: lightgray;
        }
        label {
            width: 200px;
            display: inline-block;
            vertical-align: top;
        }
        input:not([type=submit]):not([type=radio]) {
            width: 200px;
        }
        #menu {
            border-top: 4px inset lightgray;
            min-height: 20px;
        }
        #menu ul {
                clear: both;
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: rgba(68,104,151,0.5);
        }
        #menu li {
            float: left;
        }
        #menu li a {
            display: block;
            color: white;
            text-align:center;
            padding: 16px;
            text-decoration: none;
        }
        #menu li a:hover {
            background-color: rgba(68,104,151);
        }
        #menu li a:active {
            background-color: #333333;
        }
        #selectmenu {
            display: none;
        }
        @media (max-width:670px){
                #menu {display: none;}
                #selectmenu {display: inline-block;}
            }
    </style>
    </HEAD>
    <BODY>
        <div id="banner" style="padding:10px;background-color: rgba(68,104,151,0.5);">
            <img src="../images/tcc.png" style="height:20vh;width:auto;display:inline-block;" />
            <span style="font-size: 7vw;padding-left:30px;">VOTING PLATFORM</span>
        </div>
        <div id="menu" style="position:relative;">
            <?PHP
            if(strpos($_SERVER['PHP_SELF'],"index") === false){
            ?>
            <ul>
                <li><a href="addproposal.php">ADD PROPOSAL</a></li>
                <li><a href="proposals.php">VOTE</a></li>
                <li><a href="comment.php">COMMENT</a></li>
                <!--li><a href="print.php" target="new">PRINT</a></li-->
                <li><a href="index.php">LOG OUT</a></li>
            </ul>
            <div id="userspan" style="position:absolute;top:10px;right:20px;width:300px;text-align:right;font-weight:bold;color:white;"><?=$_SESSION['user']?></div>
            <?PHP
            }
            ?>
        </div>
        <div id="selectmenu">
            <?PHP
            if(strpos($_SERVER['PHP_SELF'],"index") === false){
            ?>
            <ul>
                <li><a href="addproposal.php">ADD PROPOSAL</a></li>
                <li><a href="proposals.php">VOTE</a></li>
                <li><a href="comment.php">COMMENT</a></li>
                <!--li><a href="print.php" target="new">PRINT</a></li-->
                <li><a href="index.php">LOG OUT</a></li>
            </ul>
             <div id="userspan" style="position:absolute;top:10px;right:20px;width:300px;text-align:right;font-weight:bold;color:white;"><?=$_SESSION['user']?></div>
            <?PHP
            }
            ?>
        </div>
        <div id="content" style="padding:20px;overflow:auto;">
