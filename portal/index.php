<?PHP
require "classes.php";
require "stevetable.php";
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PORTAL</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/skeleton.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container">
            <div id="sticky" style="position:sticky;top:0;">
                <div class="row">
                    <h1 class="u-full-width" style="text-align:center;">PLANNING PORTAL</h1>
                </div>
                <div class="row">
                    <fieldset style="border:1px solid gray">
                    <legend>PLANNING SECTION</legend>
                    <button id="active">ACTIVE</button> <button id="approved">APPROVED</button> <button id="refused">REFUSED</button>
                    <select id="byyear">
                        <option value="">Select Year</option>
                        <?PHP
                        $q=new Database("Application");
                        $years = $q->getData("select DISTINCT SUBSTRING(number,4,4) as planyear from planning");
                        foreach($years as $year){
                            printf("<option value=%s>%s</option>",$year->planyear,$year->planyear);
                        }
                        ?>
                    </select>
                    <input type="text" style="display:inline-block" id="srch" placeholder="Search Planing">
                    <div id="result"></div>
                    
                </div>
            </div>
        </div>
        <div id="popup" style="position:absolute;top:0;left:150px;max-width:600px;min-height:100px;border:1px solid black;background-color:rgb(250,250,250);box-shadow: 5px 5px 20px;padding:5px;">THE POPUP</div>
    </body>
</html>
<script src="js/jquery-3.1.1.min.js"></script>
<script>
    $('#popup').hide();
    $('#popup').on("click",function(){
        $(this).hide();
    })
    $('#active').on("click",function(){
        $('#srch').val("");
        $('#result').load("getresults.php?type=active");
    })
    $('#approved').on("click",function(){
        $('#srch').val("");
        $('#result').load("getresults.php?type=approved");
    })
    $('#refused').on("click",function(){
        $('#srch').val("");
        $('#result').load("getresults.php?type=refused");
    })
    $('#byyear').on("change",function(){
        $('#srch').val("");
        if($(this).val() > ''){
            $('#result').load("getresults.php?type="+$(this).val());
        }
    })
    $('#srch').on("keyup",function(){
        if($(this).val().length > 2){
            $('#result').load(encodeURI("getresults.php?search="+$(this).val()));
        }else{
            $('#result').empty();
        }
    })
</script>