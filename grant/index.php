<?PHP
include "fpdf.php";
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
        <script src="jquery-3.1.1.min.js"></script>
        <style>
            html {
                background-color: lightgray;
                font-size: 1.5vw;
            }
            textarea, input[type=text] {
                background-color: white;
                border: 1px solid black;
                border-radius: 10px;
                font-family: courier;
                font-size: 12px;
            }
            fieldset {
                border: 1px solid black;
                padding: 10px 10px 0 10px;
                border-radius: 10px;
            }
            placeholder {font-size: 12pt;}
            .biginput {
                height: 50vh;
            }
            .mediuminput {
                height: 25vh;
            }
            .smallinput {
                height: 15%;
            }
        </style>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <form id="dataform" method="POST" action="getapp.php" target="_blank">
        <div class="container">
            <div class="row" style="text-align:center;font-weight:bold;font-size:2rem;">
                WYE VALLEY COMMUNITY COUNCIL<br/>GRANT FUNDING APPLICATION FORM
            </div>
            <div class="row" style="text-align:center;">
                If you require any assistance when completing this form<br />please contact the Clerk or one of your Councillors
            </div>
            <br />
             <div class="row">
                <fieldset>
                    <legend>SECTION 1 ORGANISATION CONTACT DETAILS</legend>
                    <label for="orgname">Name of group or organisation</label>
                    <input type="text" id="orgname" name="orgname" class="u-full-width" /><br />
                    <label for="orgcontact">Contact name</label>
                    <input type="text" id="orgcontact" name="orgcontact" class="u-full-width" placeholder="This is probably your name" /><br />
                    <label for="orgaddress">Contact postal address including postcode</label>
                    <textarea class="u-full-width" id="orgaddress" name="orgaddress" placeholder="Ideally the organisation's address or your own if not applicable"></textarea>
                    <label for="contactphone" class="five columns">Day time phone number</label>
                        <input type="text" id="contactphone" name="contactphone" class="five columns" placeholder="Land line or mobile" />
                    <label for="contactemail" class="five columns">Contact email address</label>
                    <input type="text" id="contactemail" name="contactemail" class="five columns"/>
                </fieldset>
            </div>
            <div class="row">
                <fieldset>
                    <legend>SECTION 2 ORGANISATION ACTIVITY DETAILS</legend>
                    <label for="objectives">Describe your organisation's main activites and objectives</label>
                    <textarea id="objectives" name="objectives" class="u-full-width mediuminput" placeholder="Please give as full a desciption as possible"></textarea>
                    <label for="howlong">How long has the organisation been operating?</label>
                    <input type="text" class="u-full-width" id="howlong" name="howlong" />
                    <label for="where">Where and when do your meetings take place?</label>
                    <textarea class="u-full-width mediuminput" id="where" name="where"></textarea>
                </fieldset>
            </div>
            <div class="row">
                <fieldset>
                    <legend>Section 3 PROJECT DETAILS</legend>
                    <label for="project">Outline of the project or item for which funding is sought</label>
                    <textarea class="u-full-width mediuminput" id="project" name="project"></textarea>
                    <label for="inarea">Who, in the Council's area will benefit?</label>
                    <textarea id="inarea" name="inarea" class="u-full-width mediuminput" placeholder="Who will benefit in the Council's area and for how long. Estimated number of people, age range and for how long"></textarea>
                    <label for="notinarea">Who, outside of the Council's area will benefit?</label>
                    <textarea id="notinarea" name="notinarea" class="u-full-width mediuminput" placeholder="Who will benefit and for how long. Estimated number of people, age range and for how long"></textarea>                </fieldset>
            </div>
            <div class="row">
                <fieldset>
                    <legend>SECTION 4 FINANCES</legend>
                    <label for="finances">Sources of income and items of expenditure</label>
                    <textarea id="finances" name="finances" class="u-full-width mediuminput" placeholder="What are your main sources of income and what are your main expenses? How do you raise funds?"></textarea>
                    <label for="upcoming">Upcoming and planned fundraising activities</label>
                    <textarea id="upcoming" name="upcoming" class="u-full-width mediuminput"></textarea>
                    <label for="before">If you have previously applied for a grant from Wye Valley Community Council please give details</label><textarea id="before" name="before" class="u-full-width mediuminput"></textarea>
                    <label for="cost">What is the total cost of the project or item for which funding is requested?</label><textarea class="u-full-width smallinput" id="cost" name="cost"></textarea><br />
                    <label for="howmuch" class="u-full-width">Amount of grant being requested</label><input type="text" id="howmuch" name="howmuch" />
                    <label for="difference">If the grant does not cover the full amount how is the balance to be raised?</label><textarea type="text" id="difference" name="difference" class="u-full-width mediuminput"></textarea>
                    <div class="row">
                    <div>Please provide the account name and the address to which a cheque should be sent if your application is successful. The account <strong>must</strong> be in the name of the organisation and not an idividual. Note that if there is no bank accound for the orhanisation items may be paid for directly by the Council.</div>
                    </div>
                    <div class="row">
                    <label for="accountname">Account name</label><input type="text" class="u-full-width" id="accountname" name="accountname" placeholder = "This must be the organisation's account not an individual" />
                    <label for="accaddress">Address for cheque</label><textarea class="u-full-width mediuminput" id="accaddress" name="accaddress"></textarea>
                    </div>
                </fieldset>
            </div>
        </form>
            <div class="row">
                <p>Clicking the button will produce a PDF which will display on your computer. This should be printed and signed before sending to the Clerk by post or scanned (to include the signature) before emailing.</p>
                <p>The PDF will open in a new tab or browser (depending on your settings) so you will be able to return to the form to correct or alter your responses.</p>
                <button class="button button-primary" id="print">PRINT FORM</button>
            </div>
        </div>
    </body>
</html>
<script>
    $('#print').click(function(){
        $('#dataform').submit();
    });
</script>