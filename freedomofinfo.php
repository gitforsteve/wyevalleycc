<?php
// cSpell:disable
$title = "Freedom of Information Requests";
$description = "Details of how we respond to FOI request";
require "top.html";
require "stevetable.php";
$table = new steveTable('{
    "ID": "icotable",
    "tableWidth": "100%",
    "widths": ["50%","30%","20%"],
    "border": "a",
    "borderColour": "gray",
    "heading": ["Information to be published","How the information can be obtained","Cost (ppc 10p per sheet)"],
    "tableFontSize": "1.5vw",
    "aligns": ["L","L","L"]
}');
?>
<div class="nine columns" id="content">
    <h1>Freedom of Information</h1>
    <img src="images/icologo.png" style="width:8vw;" alt="Logo of the Information Commissioner's Office">
    <p>Information available from Wye Valley Community Council under the model publishing scheme</p>
    <p>You can download this information as WVCCFOI.pdf by <a href="foipdf.php" title="Download the file WVCCFOI as a PDF to your device">clicking here</a>. The file will be in your downloads folder.</p>
    <?php
    $table->heading();
    // class 1
    $table->row(["3><strong>Class 1 - Who we are and what we do</strong><br />(Organisational information, structures, locations and contacts"]);
    $table->row(["Who's who on the Council and its Advisory Groups. Current information only","Notice boards and web site",""]);
    $table->row(["Contact details for Clerk and Council members.<br />Name, location, telephone number and email address","Notice board and web site",""]);
    $table->row(["Location of Community Council meeting venue and accessibility details","Tintern &amp; Llandogo Village Halls (alternate months)","Accessible"]);
    // class 2
    $table->row(["3><strong>Class 2 - What we spend and how we spend it</strong><br />(Financial information relating to projected and actual income and expenditure, procurement, contracts and financial audit)<br />Current and previous financial year as a minimum "]);
    $table->row(["Annual return form and report by auditor","Web site &amp; hard copy",""]);
    $table->row(["Precept, Finalised budget","Hard Copy",""]);
    $table->row(["Precept","Hard Copy",""]);
    $table->row(["Financial, Standing Orders &amp; Regulations","Web site &amp; Hard Copy",""]);
    $table->row(["Grants given and received","Hard Copy",""]);
    $table->row(["List of current contracts awarded and value of contract","Hard Copy",""]);
    $table->row(["Members' allowances and expenses","Hard Copy",""]);
    // class 3
    $table->row(["3><strong>Class 3 - What our priorities are and how we are doing</strong>"]);
    $table->row(["Strategies and plans, performance indicators, audits, inspections and reviews. Current and previous years as a minimum","(hard copy or website)",""]);
    $table->row(["Community Plan (current and previous year as a minimum)","LDP Hard Copy",""]);
    $table->row(["Annual Report (current year as a minimum","Annual meeting minutes, Hard Copy &amp; website"]);
    // class 4
    $table->row(["3><strong>Class 4 - How we make decisions</strong>"]);
    $table->row(["Decision making processes and records of decisions<br />Current and previous Council year as a minimum","Hard Copy or website",""]);
    $table->row(["Timetable of meetings (Council, Community meetings","Website &amp; Hard Copy",""]);
    $table->row(["Agendas of meetings (as above)","Website &amp; Notice Boards",""]);
    $table->row(["Minutes of meetings (as above) - NB this will exclude information that is properly regarded as private to the meeting.","Website &amp; Notice Boards",""]);
    $table->row(["Reports presented to council meetings – NB this will exclude information that is properly regarded as private to the meeting.","Hard Copy",""]);
    $table->row(["Responses to consultation papers","Hard Copy, minutes",""]);
    $table->row(["Responses to planning applications","Hard Copy, minutes",""]);
    // class 5
    $table->row(["3><strong>Class 5 - Our policies and procedures</strong>"]);
    $table->row(["Current written protocols, policies and procedures for delivering our services and responsibilities. Current information only","Hard Copy or website",""]);
    $table->row(["Policies and procedures for the conduct of council business: <br />Procedural Standing Orders<br />Advisory Group terms of reference<br />Code of Conduct<br />Policy statements","Website &amp; Hard Copy",""]);
    $table->row(["Policies and procedures for the provision of services and about the employment of staff:<br />Internal policies relating to the delivery of services<br />Equality and diversity policy<br />Health and safety policy<br />Recruitment and Employment policies<br />Policies and procedures for handling requests for information Complaints procedures (including those covering requests for information and operating the publication scheme)","Website &amp; Hard Copy",""]);
    $table->row(["Information security policy","Website &amp; Hard Copy",""]);
    $table->row(["Records management policies (records retention, destruction and archive)","Hard Copy",""]);
    $table->row(["Data protection policies","Hard Copy",""]);
    // class 6
    $table->row(["<strong>Class 6 - Lists and Registers</strong><br />Currently maintained lists and registers only","(hard copy or website; some information may only be available by inspection)",""]);
    $table->row(["Assets register","Hard Copy / Website",""]);
    $table->row(["Register of members' interests","Hard Copy",""]);
    $table->row(["Register of gifts and hospitality","Hard Copy",""]);
    // class 7
    $table->row(["<strong>Class 7 - The services we offer</strong><br />(Information about the services we offer, including leaflets, guidance and newsletters produced for the public and businesses)<br />Current information only","(hard copy or website; some information may only be available by inspection) ",""]);
    $table->row(["Burial grounds and closed churchyards","Hard Copy",""]);
    $table->row(["Village halls","Hard Copy",""]);
    $table->row(["Parks, playing fields and recreational facilities","Hard Copy",""]);
    $table->row(["Seating, litter bins and lighting","Hard Copy",""]);
    $table->row(["Bus shelters","Hard Copy",""]);
    $table->row(["<strong>Additional Information</strong><br />This will provide Councils with the opportunity to publish information that is not itemised in the lists above","",""]);
    $table->print();
    $table->save("icotable.html");
    ?>
    <p style="font-weight:bold;">Email contact via our form : <a href="contact.php?id=eg">Clerk of the Council</a></p>
    <p>SCHEDULE OF CHARGES<br /><br />This describes how the charges have been arrived at and should be published as part of the guide.</p>
    <?php
    $table->empty();
    $table->reset('{
        "ID": "chargetable",
        "widths": ["33%","33%","33%"],
        "aligns": ["L","L","L"],
        "heading": ["TYPE OF CHARGE","DESCIPTION","BASIS OF CHARGE"]
    }');
    $table->heading();
    $table->row(["<strong>Disbursement cost</strong>","Photocopying 10p per sheet (black & white)","Actual cost *"]);
    $table->row(["","Photocopying 15p per sheet (colour)","Actual cost"]);
    $table->text("");
    $table->row(["","Postage","Actual cost"]);
    $table->text("");
    $table->row(["<strong>Statutory Fee</strong>","","In accordance with the relevant legislation (quote the actual statute)"]);
    $table->text("");
    $table->row(["<strong>Other</strong>","",""]);
    $table->print();
    $table->save("chargetable.html")
    ?>
    <p>* The actual cost incurred by the public authority</p>

</div>
<?php
require "bottom.html";
?>
<script type="text/javascript">
  handleMenu($('#freedomofinfo'));
</script>