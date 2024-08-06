<?PHP
include "fpdf.php";
/*$pdf = new FPDF();
$pdf->SetFont("Arial");
$pdf->AddPage();
$pdf->Cell(0,5,"HELLO");
$pdf->Line(10,20,190,20);
$pdf->Output();
exit();*/
?>
<!-- cSpell:disable /---->
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
    <link rel="stylesheet" href="css/skeleton.css">
    <style>
      * {
        box-sizing: border-box;
      }
      body {
        font-size: 2vw;
      }
      .rule {
        border-bottom: 1px solid gray;
      }
      .error {
        border: 1px solid red !important;
      }
      .white { 
        background-color: white;
      }
      h1 {
        font-size: 1.5em;
        text-align: center;
      }
      p {
        font-size: 0.75em;
      }
      form {
        background-color: lightgray;
      }
      fieldset {
        padding: 5px;
        background-color: lightgray;
      }
      label, legend {
        font-weight: normal;
        font-size: 0.75em;
      }
      legend {
        font-weight: bold;
      }
      input[type=radio] {
        width: 3vw;
      }
      input {
        font-size: 1em;
      }
      textarea {
        min-height: 100px;
        font-size: 0.75em;
      }
      textarea.medium {
        min-height: 250px;
      }
      textarea.high {
        min-height: 400px;
      }
      #agentpanel {
        display: none;
      }
      #regForm {
  background-color: #ffffff;
  margin: 100px auto;
  padding: 40px;
  width: 70%;
  min-width: 300px;
}

/* Style the input fields */
input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}
button {
  font-size: 0.75em;
}
/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}
textarea.invalid {
  background-color: #ffdddd;
}
/* Hide all steps by default: */
.tab {
  display: none;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

/* Mark the active step: */
.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #04AA6D;
}    </style>
  </head>
  <body>
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <div class="container u-full-width">
      <form id="complaintform" action="" autocomplete="off">

        <h1 class="white">WYE VALLEY COMMUNITY COUNCIL<br />GRANT FUNDING APPLICATION FORM</h1>
        
        <!-- One "tab" for each step in the form: -->
        <!--PAGE 1-->
        <div class="u-full-width tab">
          <div class="u-full-width white">
            <p>We have split this form into various sections to make completion simpler.</p>
            <p>If you require any assistnace in completing this form please contact the Clerk or one of your Councillors.</p>
            <p class="rule"><strong>IF YOU ARE USING A PUBLIC COMPUTER PLEASE CONSIDER THE CONFIDENTIAL NATURE OF YOUR DATA WHICH MAY BE OVERLOOKED OR OTHERWISE COMPROMISED</strong></p>
            <p class="rule"><strong>Please complete each section in as much detail as possible.</strong><br /><br /></p>
          </div>
        </div>
        
        <!==PAGE2==>
        <div class="u-full-width tab">
          <fieldset>
            <legend>Organisation contact details</legend>
            <div class="row">
              <label for="orgname">Organisation name</label>
              <input type="text" id="orgname" name="orgname" class="u-full-width" placeholder="Name of your organisation" />
            </div>
            <div class="row">
              <div class="four columns">
                <label for="title">Contact name (required)</label>
                <input type="text" class="u-full-width required" name="title" id="title" placeholder="Mr,Mrs,Ms,etc." list="titles" oninput="this.className=''">
                <datalist id="titles">
                  <option value="Mr">
                  <option value="Mrs">
                  <option value="Ms">
                  <option value="Dr">
                  <option value="Prof">
                </datalist>
              </div>
              <div class="eight columns">
                <label for="surname">Surname (required)</label>
                <input type="text" class="u-full-width required" name="surname" id="surname" placeholder="Your family name" oninput="this.classList.remove('invalid')">
              </div>
            </div>
            <div class="row">
              <div class="u-full-width">
                <label for="forenames">Forenames (required)</label>
                <input type="text" class="u-full-width required" name="forenames" id="forenames" placeholder="Your given names" oninput="this.classList.remove('invalid')">
              </div>
            </div>
            <div class="row">
              <div class="u-full-width">
                <label for="address">Postal address and postcode (required)</label>
                <textarea name="address" id="address" class="u-full-width medium required" placeholder="Your full address including postcode" oninput="this.classList.remove('invalid')"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="three columns">
                <label for="phone">Daytime Phone No (required)</label>
                <input type="text" class="u-full-width required" placeholder="Your daytime phone ot mobile number" name="phone" id="phone" oninput="this.classList.remove('invalid')">
              </div>
              <div class="six columns">
                <label for="email"><br />Email address (required)</label>
                <input type="text" class="u-full-width required" placeholder="Your email address" name="email" id="email" oninput="this.classList.remove('invalid')">
              </div>
            </div>
            <div class="row">
              <fieldset>
                <legend>How would you prefer us to contact you</legend>
                <div class="row">
                  <label class="five columns">Daytime phone
                    <input class="label-body" type="radio" name="contact" value="Daytime phone" checked>
                  </label>
                  <label class="four columns">Mobile
                    <input class="label-body" type="radio" name="contact" value="Mobile phone">
                  </label>
                  <label class="three columns">Email
                    <input class="label-body" type="radio" name="contact" value="Email">
                  </label>
                </div>
              </fieldset>
              <br />
            </div>
            </fieldset>
        </div>

        <!==PAGE3==>
        <div class="u-full-width tab">
          <p>ORGANISATION ACTIVITY DETAILS</p>
          <div class="row">
            <fieldset>
              <div class="row">
                <label for="activities">Please dscribe your organisation's main activities, aims and objectoves</label>
                <textarea class="u-full-width" type="text" name="activities" id="activities" placeholder="What are your organisations objectives"></textarea>
              </div>
              <div class="row">
                <label for="howlong">How long has your organisation been operating?/label>
                <input class="u-full-width medium" name="howlong" id="howlong" placeholder="Please state how long your organisation has been operating"></input>
              </div>
              <div class="row">
                <label for="meetings">When and where does you organisation meet?</label>
                <input class="u-full-width" type="text" name="meetings" id="meetings" placeholder="Please state your meeting venue and how often you meet">
              </div>
              <div class="row">
                <label for="project">Please outline the project or item for which you are seeking funding</label>
                <textarea class="u-full-width" name="project" id="project" placeholder="The project or item for which funding is required"></textarea>
              </div>
            </fieldset>
          </div>
        </div>

        <!=PAGE4==>
        <div class="u-full-width tab">
          <div class="row">
            <label for="whobenefits">Who will benefit?</label>
            <textarea class="u-full-width high required" name="whobenefits" id="whobenefits" placeholder="Who, within the Council's area will benefit from the project and for how long?" oninput="this.classList.remove('invalid')"></textarea>
          </div>
          <br />
          <div class="row">
            <label for="whoelse">Who outside of the Council's area will benefit from the project and for how long?</label>
            <textarea class="u-full-width" name="whoelse" id="whoelse" placeholder="Estimated number of people, age range, etc." oninput="this.classList.remove('invalid')"></textarea>
          </div>
        </div>

        <div class="u-full-width tab">
          <div class="row">
            <label for="mainsource">Please tell us about your finances (required)</label>
            <input type="text" class="u-full-width high required" name="mainsource" id="mainsource" placeholder="Your main source of income" oninput="this.classList.remove('invalid')"></input>
          </div>
          <br />
          <div class="row">
            <label for="expenditure>DWhere does most of your expenditure go?(required)</label>
            <input class="u-full-width high required" name="expenditure" id="expendtiture" placeholder="Where does most of your mony get spent?" oninput="this.classList.remove('invalid')"></textarea>
          </div>
          <div class="row">
            <label for="fundraising">How do you raise funds(required)</label>
            <input type="text" class="u-full-width high required" name="fundraising" id="fundraising" placeholder="Your main source of income" oninput="this.classList.remove('invalid')"></input>
          </div>
          <br />
        
        <div class="row">
          <label for="fundraisingactivities">Do you have upcoming or planned fundraising activites (required)</label>
          <input class="u-full-width required" type="text" name="planned" id="planned" placeholder="Upcoming and planned fundraising (if none enter 'none')" oninput="this.classList.remove('invalid')">
        </div>
        </div>
        <div class="u-full-width tab">
          <div class="row">
            <p style="font-weight:bold;">If your organisation has an annual record of accounts please include the most recent accounts or a copy of your bank statement</p>
          </div>
          <br />
          <div class="row">
            <p>Have you applied for a grant from Wye Valley Community Council before? If so please give details</p><textarea class="u-full-width" name="prevclaim" id="prevclaim" placeholder="If you have not applied before please enter 'No' or 'None'"></textarea>
          </div>
          <div class="row">
            <div class="four columns"><label for="amount">What is the amount of grant funding being requested?</label></div><div class="four columns"><input type="text" id="amount" name="amount" />
          </div>
        </div>
        <!--*****/-->
        <div class="u-full-width tab">
          <p>You have now completed the form and can, if you wish go to any part to check and change as required. When the printable form is generated you can still return here to make changes and produce the form again.</p>
          <p>When you click on the "print form" button another browser page or tab will open and a PDF displayed in it. This is the form which must be presented to the school and can be printed and a copy saved to your computer if you wish.</p>
        </div>
        <div style="overflow:auto;">
          <div style="float:right;">
            <button class="button-primary" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button class="button-primary" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
          </div>
        </div>
        
        <!-- Circles which indicates the steps of the form: -->
        <div style="text-align:center;margin-top:40px;">
          <span class="step"></span>
          <span class="step"></span>
          <span class="step"></span>
          <span class="step"></span>
          <span class="step"></span>
          <span class="step"></span>
          <span class="step"></span>
          <span class="step"></span>
          <span class="step"></span>
        </div>
        
        </form>    
      </div>
  </body>
</html>
<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Print form";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  if(currentTab < x.length){
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
  }
    // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("complaintform").action = "printform.php";
    document.getElementById("complaintform").target = "blank";
    document.getElementById("complaintform").method = "POST";
    document.getElementById("complaintform").submit();
    currentTab = x.length-1;
    //return false;
  }
   showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    if(y[i].classList.contains('required')){
      // If a field is empty...
      if (y[i].value == "") {
        // add an "invalid" class to the field:
        y[i].className += " invalid";
        // and set the current valid status to false:
        valid = false;
      }
    }
  }
  y = x[currentTab].getElementsByTagName("textarea");
  // A loop that checks every textarea field in the current tab:
  for (i = 0; i < y.length; i++) {
    if(y[i].classList.contains('required')){
      // If a field is empty...
      if (y[i].value.length == 0) {
        // add an "invalid" class to the field:
        y[i].className += " invalid";
        // and set the current valid status to false:
        valid = false;
      }
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}
</script>