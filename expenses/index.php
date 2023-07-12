<?PHP
// cSpell:disable
    include "../MyCSV.class.php";
    $data = new MyCSV('../data/councillor.csv');
    $data->sort("name surname");
    $councillors = $data->toObj();
?>

<!DOCTYPE html lang="en">
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Wye Valley CC Expenses</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/skeleton.css">
        <link rel="stylesheet" href="../css/jquery-ui.css">
        <style>
            html {
                font-size: 1.25vw;
            }
            h1 h2 {
                font-size: 1vw;
            }    
            fieldset {
                  background-color: #eeeeee;
                  padding: 5px;
            }
            legend {
                background-color: gray;
                color: white;
                padding: 5px 10px;
            }
            input.error {
                background-color: #ffdddd;
            }
            textarea.error {
                background-color: #ffdddd;
            }
            #msg {
                color: red;
            }
        </style>
        <script src="../js/jquery-3.1.1.min.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script>
           $(document).ready(function(){
                $('#date').datepicker({
                    dateFormat: "d MM yy"
                });
                $('#printform').on("click",function(){
                    var ok = true;
                     var total = 0.00;
                    $('#msg').empty();
                    $('#expform').find(':input').each(function(){
                        $(this).removeClass('error');
                    });
                    /*$('#name').removeClass('error');
                    $('#date').removeClass('error');
                    $('#description').removeClass('error');
                    $('#fares').removeClass('error');
                    */
                    $('#expform').find(':input').each(function(){
                        if($(this).attr('id') !== 'date' && $(this).type !== 'button'){
                            var v = parseFloat($(this).val());
                            if($.isNumeric(v)){
                                total += v;
                            }
                         }
                    })
                   if(!$.trim($('#name').val())){
                        $('#name').addClass('error');
                        $('#name').attr('placeholder','YOUR NAME IS REQUIRED');
                        ok = false;
                    }
                    if(!$.trim($('#date').val())){
                        $('#date').addClass('error');
                        $('#date').attr('placeholder','THE DATE IS REQUIRED')
                        ok = false;
                    }
                    if(!$.trim($('#description').val())){
                        $('#description').addClass('error');
                        $('#description').attr('placeholder','REASON FOR EXPENSE IS REQUIRED');
                        ok = false;
                    }
                    if(!ok){
                        $('#msg').text("Please check missing fields");
                    }else if(!total){
                       $('#msg').text("No amounts have been entered");
                        var ok = false;
                        $('#expform').find(':input[type="number"]').each(function(){
                            $(this).addClass('error');
                        })

                    }
                    if(ok){
                        $('#expform').submit();
                    }
                })
                $('#fares').on('input',function(){
                    if($.trim($(this).val()) && $(this).val() > 0){
                        $('#farerec').prop('checked',true);
                    }else{
                        $('#farerec').prop('checked',false);
                    }
                });
                $('#parking').on('input',function(){
                    if($.trim($(this).val()) && $(this).val() > 0){
                        $('#parkingrec').prop('checked',true);
                    }else{
                        $('#parkingrec').prop('checked',false);
                    }
                });
                $('#accom').on('input',function(){
                    if($.trim($(this).val()) && $(this).val() > 0){
                        $('#accomrec').prop('checked',true);
                    }else{
                        $('#accomrec').prop('checked',false);
                    }
                });
                $('#food').on('input',function(){
                    if($.trim($(this).val()) && $(this).val() > 0){
                        $('#foodrec').prop('checked',true);
                    }else{
                        $('#foodrec').prop('checked',false);
                    }
                });
                $('#other').on('input',function(){
                    if($.trim($(this).val()) && $(this).val() > 0){
                        $('#otherrec').prop('checked',true);
                    }else{
                        $('#otherrec').prop('checked',false);
                    }
                });
            });
        </script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container">
            <h1 style="text-align:center;">Wye Valley Community Council</h1>
            <h2 style="text-align:center;">Expenses Claim</h2>
            <form id="expform" action="drawform.php" method="POST" autocomplete="off">
                <div class="row">
                    <fieldset>
                        <legend>Claim details</legend>
                        <div class="six columns">
                            <label for="name">Your name</label>
                            <input type="text" list="names" class="u-full-width" name="name" id="name" />
                            <datalist id="names">
                                <?PHP
                            foreach($councillors as $councillor){
                                    printf("<option value='%s %s'>",$councillor->name,$councillor->surname);
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="five columns">
                            <label for="date">Date of expense</label>
                            <input type="text" class="u-full-width" name="date" id="date" />
                        </div>
                        <div class="row">
                        <div class="u-full-width">
                            <label for="description">Reason for expense</label>
                            <textarea class="u-full-width" name="description" id="description"></textarea>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <fieldset>
                        <legend>Travel</legend>
                        <br />
                        <div class="four columns">
                            <label for="fares">Fares</label>
                            <input type="number" step="0.01" name="fares" id="fares" class="u-full-width" placeholder="Receipts required">
                            <input type="checkbox" name="farerec" id="farerec"> <span id="farerecspan">Receipts attached</span>
                        </div>
                        <div class="three columns">
                            <label for="mileage">Vehicle mileage</label>
                            <input type="number" step="0.01" name="mileage" id="mileage" class="u-full-width" placeholder="Actual mileage">
                        </div>
                        <div class="four columns">
                            <label for="parking">Parking fees</label>
                            <input type="number" step="0.01" name="parking" id="parking" class="u-full-width" placeholder="Receipt/ticket required">
                            <input type="checkbox" name="parkingrec" id="parkingrec"> Receipts attached
                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <fieldset>
                        <legend>Subsistence</legend>
                        <div class="four columns">
                            <label for="accom">Accommodation</label>
                            <input type="number" step="0.01" name="accom" id="accom" class="u-full-width" placeholder="Receipt required">
                            <br />
                            <input type="checkbox" name="accomrec" id="accomrec"> Receipts attached
                        </div>
                        <div class="four columns">
                            <label for="food">Food and drink</label>
                            <input type="number" step="0.01" name="food" id="food" class="u-full-width" placeholder="Receipt required">
                            <br />
                            <input type="checkbox" name="foodrec" id="foodrec"> Receipts attached
                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <fieldset>
                        <legend>Other expense</legend>
                        <div class="seven columns">
                            <label for="otherdesc">Description of expense</label>
                            <textarea id="otherdesc" name="otherdesc" class="u-full-width" placeholder="Enter details of other expenses"></textarea>
                        </div>
                        <div class="four columns">
                            <label for="other">Amount paid</label>
                            <input type="number" step="0.01" name="other" id="other" class="u-full-width" placeholder="Receipt if available">
                            <br />
                            <input type="checkbox" name="otherrec" id="otherrec"> Receipts attached
                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <p>ENTER AMOUNTS WITH NO POUND SIGN</p>
                    <p>Fares are fares for coach, train, bus, etc.<br />
                    Mileage is actual mileage for the journey(s)<br /><strong>Parking fees do not include parking fines.</strong></p>
                    <p>Receipts must be scanned and sent</p>
                    <p style="font-weight:bold">IMPORTANT</p>
                    <p>By submitting this form you are certifying that the amounts were expended while on Wye Valley Community Council business.</p>
                    <p>A PDF of the form will be produced and this should be saved and sent to the Clerk.</p>
                 </div>
            </form>
            <input type="button" id="printform" name="printform" value="Produce form" /> <span id="msg"></span>
       </div>
    </body>
</html>


