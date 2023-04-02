<?PHP
//cSpell:disable

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
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="skeleton.css">
        <link rel="stylesheet" href="jquery-ui.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container">        
            <h1>Wye Valley Community Council</h1>
            <h2>Purchase order System</h2>
            <form action="makepo.php" method="POST" target="_new">
            <div class="row">
                <div class="eight columns">
                    <label for="supplier">Supplier</label>
                    <textarea id="supplier" name="supplier" class="u-full-width"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="u-full-width">
                    <label for="desc">Goods or services</label>
                    <textarea class="u-full-width" id="desc" name="desc"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="four columns">
                    <label for="price">Price ex VAT</label>
                    <input type="text" class="u-full-width" id="price" name="price" />
                </div>
            </div>
            <div class="row">
                <div class="four columns">
                    <label for="deldate">Delivery date</label>
                    <input type="text" class="u-full-width" id="deldate" name="deldate" />
                </div>
                <div class="four columns">
                    <label for="period">Period of supply</label>
                    <input type="text" class="u-full-width" id="period" name="period" />
                </div>
                <div class="four columns">
                    <label for="place">Deliver to</label>
                    <textarea class="u-full-width" id="place" name="place"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="four columns">
                    <label for="ourref">Our ref</label>
                    <input type="text" class="u-full-width" id="ourref" name="ourref" />
                </div>
                <div class="four columns">
                    <label for="yourref">Your ref</label>
                    <input type="text" class="u-full-width" id="yourref" name="yourref" />
                </div>
            </div>
            <div class="row">
                <div class="eight columns">
                    <label for="special">Special instructions</label>
                    <textarea class="u-full-width" id="special" name="special"></textarea>
                </div>
                <div class="four columns" style="text-align:center;">
                    <input type="submit" value="PRODUCE ORDER" />
                </div>
            </div>
            </form>
        </div>
    </body>
</html>
<script src="jquery-3.1.1.min.js"></script>
<script src="jquery-ui.min.js"></script>
<script src="jquery.datetimepicker.js"></script>
<script>
    $('#deldate').datepicker({
        dateFormat: "dd-mm-yy"
    })   
</script>