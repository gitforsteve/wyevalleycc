<?PHP
// cSpell:disable
$title = "Notice of Election";
$desc = "2022 notice of election";
$keywords = "Tintern community councillors, wards, represent, election";
require '../classes.php';
require "../stevetable.php";
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$title?></title>
    <meta name="description" content="<?=$desc?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
   
<div role="region" aria-label="Community and Town Councils">
<h1 style="text-align:center;background:black;color:white;font-size:1.2em;font-family:Arial, helvetica,sans-serif;">
  Notice of Election<br />Election of Councillors<br />Community / Town Councils
</h1>
<?
$table = new steveTable('{
  "tableWidth": "95%",
  "tableCenter": true,
  "widths": ["12%","12%","12%","12%","12%","12%","12%","12%"],
  "aligns": ["L","C","L","C","L","C","L","C"],
  "tableFontsize": "10px",
  "heading": [" Ward","Number of Councillors to be elected"," Ward","Number of councillors to be elected"," Ward","Number of councillors to be elected"," Ward","Number of councillors to be elected"], 
  "headingBackground": "lightgray",
  "border": "b",
  "borderColor": "lightgray"
}');
$table->heading();
$table->row([" Abergavenny (Cantref)"," 3"," Devauden (Devauden)"," 3"," Llangybi Fawr (Llangattock Nigh Caerleon)"," 1"," Portskewett (Portskewett Village)"," 7"]);
$table->row([" Abergavenny (Grofield)"," 4"," Devauden (Itton)"," 2"," Llangybi Fawr (Llangybi)"," 3"," Portskewett (Sudbrook)"," 2"]);
$table->row([" Abergavenny (Lansdown)"," 3"," Devauden (Kilgwrrwg)"," 1"," Llangybi Fawr (Llanhennock)"," 1"," Raglan (Gwehelog)"," 1"]);
$table->row([" Abergavenny (Llanwenarth Citra)"," 1"," Devauden (Llanvihangel Tor-Y-Mynydd)"," 1"," Llangybi Fawr (Tredunnock)"," 1"," Raglan (Kingcoed)"," 1"]);
$table->row([" Abergavenny (Park)"," 3"," Gobion Fawr (Llanddewi Rhydderch)"," 2"," Llantilio Pertholey (Croesonen)"," 6"," Raglan (Llandenny)"," 1"]);
$table->row([" Abergavenny (Pen Y Fal)"," 3"," Gobion Fawr (Llanfair Cilgydyn)"," 1"," Llantilio Pertholey (Mardy)"," 3"," Raglan (Raglan)"," 6"]);
$table->row([" Caerwent (Caerwent)"," 3"," Gobion Fawr (Llangattock-nigh-Usk)"," 3"," Llantilio Pertholey (Pantygelli)"," 1"," Rogiet"," 7"]);
$table->row([" Caerwent (Crick)"," 1"," Gobion Fawr (Llanvapley)"," 1"," Llantilio Pertholey (Sgyrrid)"," 2"," Shirenewton (Earlswood and Newchurch)"," 2"]);
$table->row([" Caerwent (Dinham)"," 1"," Goetre Fawr (Goetre Wharf)"," 2"," Llantrisant Fawr (Gwernesney)"," 1"," Shirenewton (Shirenewton and Mynyddbach)"," 5"]);
$table->row([" Caerwent (Llanvair Discoed)"," 1"," Goetre Fawr (Goytre)"," 4"," Llantrisant Fawr (Llangwm)"," 3"," Skenfrith (Cross Ash)"," 3"]);
$table->row([" Caerwent (St. Brides Netherwent)"," 1"," Goetre Fawr (Llanover)"," 1"," Llantrisant Fawr (Llansoy)"," 1"," Skenfrith (Llanvetherine)"," 2"]);
$table->row([" Caldicot (Caldicot Castle)"," 3"," Goetre Fawr (Nant-Y-Derry)"," 1"," Llantrisant Fawr (Llantrisant)"," 3"," Skenfrith (Skenfrith)"," 2"]);
$table->row([" Caldicot (Caldicot Cross)"," 3"," Grosmont (Grosmont)"," 6"," Magor with Undy (Magor East)"," 4"," St Arvans"," 7"]);
$table->row([" Caldicot (Dewstow)"," 3"," Grosmont (Llangattock Lingoed)"," 1"," Magor with Undy (Magor West)"," 3"," Trellech United (Catbrook)"," 2"]);
$table->row([" Caldicot (Severn)"," 2"," Llanarth (Bryngwyn)"," 2"," Magor with Undy (Undy)"," 3"," Trellech United (Llanishen)"," 2"]);
$table->row([" Caldicot (The Village)"," 2"," Llanarth (Clytha)"," 1"," Mathern (Mathern)"," 3"," Trellech United (Penallt)"," 3"]);
$table->row([" Caldicot (West End)"," 3"," Llanarth (Kemeys Commander and Llancayo)"," 2"," Mathern (Mounton)"," 1"," Trellech United (The Narth)"," 2"]);
$table->row([" Chepstow (Bulwark)"," 4"," Llanarth (Llanarth)"," 3"," Mathern (Pwllmeyric)"," 3"," Trellech United (Trellech Grange)"," 1"]);
$table->row([" Chepstow (Chepstow Castle)"," 3"," Llanbadoc (Glascoed)"," 2"," Mitchel Troy (Cwmcarvan)"," 1"," Trellech United (Trellech Town)"," 3"]);
$table->row([" Chepstow (Larkfield)"," 2"," Llanbadoc (Little Mill)"," 3"," Mitchel Troy (Dingestow)"," 2"," Trellech United (Whitebrook)"," 1"]);
$table->row([" Chepstow (Maple Avenue)"," 1"," Llanbadoc (Llanbadoc)"," 2"," Mitchel Troy (Mitchel Troy)"," 2"," Usk"," 7"]);
$table->row([" Chepstow (Mount Pleasant)"," 3"," Llanbadoc (Monkswood)"," 2"," Mitchel Troy (Pen-y-Clawdd)"," 1"," Whitecastle (Llangattock Vibon Avel)"," 1"]);
$table->row([" Chepstow (St Kingsmark)"," 3"," Llanelly (Clydach)"," 2"," Mitchel Troy (Tregare)"," 2"," Whitecastle (Llanvihangel-Ystern-Llewern)"," 1"]);
$table->row([" Chepstow (Thornwell)"," 3"," Llanelly (Darrenfelin)"," 2"," Mitchel Troy (Wonastow)"," 1"," Whitecastle (Newcastle)"," 2"]);
$table->row([" Crucorney (Bwlch, Trewyn and Oldcastle)"," 1"," Llanelly (Gilwern)"," 9"," Monmouth (Drybridge)"," 4"," Whitecastle (Penrhos)"," 2"]);
$table->row([" Crucorney (Cwmyoy)"," 1"," Llanfoist (Govilon)"," 6"," Monmouth (Osbaston)"," 4"," Whitecastle (Rockfield and St Maughans)"," 3"]);
$table->row([" Crucorney (Forest and Ffwddog)"," 1"," Llanfoist (Llanellen)"," 2"," Monmouth (Overmonnow)"," 3"," Whitecastle (Whitecastle)"," 2"]);
$table->row([" Crucorney (Llanvihangel Crucorney)"," 2"," Llanfoist (Llanfoist)"," 5"," Monmouth (Town)"," 4"," Wye Valley (Llandogo)"," 3"]);
$table->row([" Crucorney (Pandy)"," 2"," Llangybi Fawr (Coed-Y-Paen)"," 1"," Monmouth (Wyesham)"," 4"," Wye Valley (Tintern)"," 4"]);
$table->row([" "," "," Llangybi Fawr (Llandegfedd)"," 1"," Portskewett (Leechpool)"," 1"," ",""]);

$table->print();
?>
<div style="font-family:Arial, helvetica,sans-serif;">
  <ol>
    <li>Nomination papers must be delivered to the Returning Officer <span style="font-weight:bold;">no later than 4pm on the 5 April 2022</span>.</li>
    <li>Nomination papers may be delivered to the Returning Officer at County Hall, The Rhadyr, Usk, NP15 1GA between 9:30am and 4pm on any working day from the date of publication of this notice (excluding bank holidays) or electronically as per the arrangements set out in the electronic delivery statement below.</li>
    <li>Nomination papers may be obtained from the Returning Officer either at the offices of the Council above or online at www.monmouthshire.gov.uk. If any election is contested the poll will take place on 5 May 2022.</li>
    <li>Applications to register to vote must reach the Electoral Registration Officer 12 midnight on 14 April 2022. Applications can be made online: <a href="https://www.gov.uk/registertovote" target="new">www.gov.uk/registertovote</a></li>
    <li>Applications, amendments or cancellations of postal votes must reach the Electoral Registration Officer at County Hall, The Rhadyr, Usk, NP15 1GA by 5pm on 19 April 2022</li>
    <li>Applications to vote by proxy at this election must reach the Electoral Registration Officer at County Hall, The Rhadyr, Usk, NP15 1GA by 5pm on 26 April 2022.</li>
    <li>Applications to vote by emergency proxy at this election must reach the Electoral Registration Officer at County Hall, The Rhadyr, Usk, NP15 1GA by 5pm on 5 May 2022.</li>
  </ol>
  <p>Dated: 16 March 2022 Paul Matthews Returning Officer</p>
</div>
</div>
<div role="region" aria-label="Monmouthshire County Council">
<h2 style="text-align:center;background:black;color:white;font-size:1.2em;font-family:Arial, helvetica,sans-serif;">
  Notice of Election<br />Election of Councillors<br />Monmouthshire County Council
</h2>

<?
$table = new steveTable('{
  "tableWidth": "95%",
  "tableCenter": true,
  "widths": ["25%","25%","25%","25%"],
  "aligns": ["L","C","L","C"],
  "tableFontsize": "10px",
  "heading": [" Ward","Number of Councillors to be elected"," Ward","Number of councillors to be elected"], 
  "headingBackground": "lightgray",
  "borderColor": "lightgray",
  "border": "b"
}');
$table->heading();
$table->row([" Ward","Number of Councillors to be elected"," Ward","Number of councillors to be elected"]);
$table->row([" Bulwark and Thornwell"," 2"," Magor East with Undy"," 2"]);
$table->row([" Caerwent"," 1"," Magor West"," 1"]);
$table->row([" Caldicot Castle"," 1"," Mardy"," 1"]);
$table->row([" Caldicot Cross"," 1"," Mitchel Troy and Trellech United"," 2"]);
$table->row([" Cantref"," 1"," Mount Pleasant"," 1"]);
$table->row([" Chepstow Castle and Larkfield"," 2"," Osbaston"," 1"]);
$table->row([" Croesonen"," 1"," Overmonnow"," 1"]);
$table->row([" Crucorney"," 1"," Park"," 1"]);
$table->row([" Devauden"," 1"," Pen Y Fal"," 1"]);
$table->row([" Dewstow"," 1"," Portskewett"," 1"]);
$table->row([" Drybridge"," 1"," Raglan"," 1"]);
$table->row([" Gobion Fawr"," 1"," Rogiet"," 1"]);
$table->row([" Goetre Fawr"," 1"," Severn"," 1"]);
$table->row([" Grofield"," 1"," Shirenewton"," 1"]);
$table->row([" Lansdown"," 1"," St Arvans"," 1"]);
$table->row([" Llanbadoc and Usk"," 2"," St Kingsmark"," 1"]);
$table->row([" Llanelly"," 2"," Town"," 1"]);
$table->row([" Llanfoist Fawr and Govilon"," 2"," West End"," 1"]);
$table->row([" Llangybi Fawr"," 1"," Wyesham"," 1"]);
$table->row([" Llantilio Crossenny"," 1"," "," "]);
$table->print();
?>
  <div style="font-family:Arial, helvetica,sans-serif;">
    <ol>
      <li>Nomination papers must be delivered to the Returning Officer <span style="font-weight:bold;">no later than 4pm on the 5 April 2022</span>.</li>
      <li>Nomination papers may be delivered to the Returning Officer at County Hall, The Rhadyr, Usk, NP15 1GA
      between 9:30 am and 4pm on any working day from the date of publication of this notice (excluding bank
      holidays) or electronically as per the arrangements set out in the electronic delivery statement below.</li>
      <li>Nomination papers may be obtained from the Returning Officer either at the offices of the Council above or
      online at <a href="https://www.monmouthshire.gov.uk" target="new">www.monmouthshire.gov.uk</a>.</li>
      <li>If any election is contested the poll will take place on 5 May 2022.</li>
      <li>Applications to register to vote must reach the Electoral Registration Officer by 12 midnight on 14 April 2022. Applications can be made online: <a href="https://www.gov.uk/registertovote" target="new">www.gov.uk/registertovote</a></li>
      <li>Applications, amendments or cancellations of postal votes must reach the Electoral Registration Officer at
      County Hall, The Rhadyr, Usk, NP15 1GA by 5pm on 19 April 2022</li>
      <li>Applications to vote by proxy at this election must reach the Electoral Registration Officer at County Hall, The Rhadyr, Usk, NP15 1GA by 5pm on 26 April 2022.</li>
      <li>Applications to vote by emergency proxy at this election must reach the Electoral Registration Officer at County Hall, The Rhadyr, Usk, NP15 1GA by 5pm on 5 May 2022.</li>
    </ol>
    <p>Dated: 16 March 2022 Paul Matthews Returning Officer</p>
    <p style="font-weight:bold;">Electronic Delivery Statement</p>
</div>
  <div role="region" aria-label="Electronic submission">
  <p>Nomination papers submitted electronically must be delivered in accordance with arrangements set out in this statement.</p>
    <ul>
    <p>• By Email<br />
      Nomination Papers can be submitted by email to elections@monmouthshire.gov.uk within the timeframe allowed for delivery of nominations.<br /> 
      Candidates are encouraged to submit their nomination for checking prior to its formal submission and can do so using the same email address.<br />
      Candidates will need to be mindful of the size of the files they are submitting and ensure they are delivered successfully and are clearly legible.<br />
      Candidates will receive an automatic response once the nomination paper has been received by the Returning Officer.<br />
      A follow up email will be sent to the candidate once the nomination paper has been processed and deemed valid.</p>
    <p>• Using our online system<br />
    Candidates can submit nominations to us through our online nomination system accessible through My Monmouthshire.<br />
    All instructions and requirements on submitting your nomination are provided as part of the process. When you submit the nomination paper, it will be initially submitted provisionally and once approved the relevant additional signatories will be emailed to carry out their actions required as part of the process.<br />
    It will be the candidates responsibility to ensure all the necessary signatories are submitted before the close of nominations.<br />
    If you need assistance with using the online system please contact the elections office on 01633 644212 or email <a href="mailto:elections@monmouthshire.gov.uk">elections@monmouthshire.gov.uk</a><br />
    Once all signatories have been received the candidate will be emailed a confirmation that the nomination is complete and valid.<br />
    Please note it is the responsibility of the candidate to ensure that the Returning Officer receives completed nomination forms in the correct way and by the required deadlines.<br />
    An electronic read receipt from the Returning Officer is not confirmation that the nomination is valid. The Returning Officer will send a notice to inform candidates of their decision as to whether or not their nomination is valid.</p>
  </div>
</div>
</div>
</body>
</html>