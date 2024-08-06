<?PHP
//ini_set('display_errors',1);
//cSpell:disable
/*********** SET FINANCIAL YEAR *************/
$year = "2023 to 2024";
$title = "Payments to members";
$desc = "Statement of payments made to members";
require 'steveCSV.php';
require 'stevetable.php';
require 'top.html';
$d = new steveCSV("data/payments.csv");
$d->sort('surname');
$table = new steveTable('{
  "tableWidth": "80%",
  "tableCenter": true,
  "widths": ["80%","10%","10%"],
  "aligns": ["L","R","R"],
  "currency": [0,1,1],
  "currencySymbol": "&pound;",
  "sum": [0,0,1],
  "totalLabel": "Total payments for the year",
  "emptyFields": true,
  "heading": ["Councillor","Payment","Total"],
  "headingBackground": "darkgray",
  "headingColor": "white"
}');
$table->row(["2>Payments for the financial year 2023 - 2024"]);
$table->heading();
$data = $d->data;
$total = 0;
function output($v){
  if($v === '0'){
    return "0";
  }
  return number_format($v,2,'.',',');
}

?>
<div class="nine columns" style="padding-left:10px;">
<div role="navigation">Our other financial pages:
    <ul>
      <li><a href="accounts.php">Accounting statement</a></li>
      <li><a href="budgets.php">Budgets</a></li>
      <li><a href="assets.php">Tangible assets</a></li>
      <!--li><a href="paymenttomembers.php">Payments to members</a></li-->
    </ul>
</div>
<h1>Payments to members</h1>
<p>Statement of payments made to members of the Community Council for the financial year 2023 - 2024</p>
<p style="font-size:80%;">In accordance with Section 151 of the Local Government Measure 2011, Community and Town Councils must publish within their authority area the remuneration received by their members by 30th September following the end of the previous financial year.</p>
<p> 
<?PHP
//"Surname","Initial","Basic Payment","Responsibility Payment","Chair's Payment","Vice Chair's Payment","Loss Allowance","Travel and Subsistence","Cost of Care","Attendance","Other","total"
$spacer = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  foreach($data as $cllr){
    $table->setStyles(['b','b','b']);
    if($cllr->total === '0'){
      $table->text($cllr->forename." ".$cllr->surname);
    }else{
      $table->row([$cllr->forename." ".$cllr->surname,'',$cllr->total]);
    }
    $table->setStyles(['','']);
    $total += floatval($cllr->total);
    if(output($cllr->basic) !== '0'){
      $table->row([$spacer."Basic Payment",output($cllr->basic),'']);
    }
    /*if(output($cllr->responsibility) !== '0'){
      $table->row([$spacer."Responsibility Payment",output($cllr->responsibility),'']);
    }*/
    if(output($cllr->chair) !== '0'){
      $table->row([$spacer."Chair's Allowance",output($cllr->chair),'']);
    }
    if(output($cllr->vice) !== '0'){
      $table->row([$spacer."Vice Chair's Allowance",output($cllr->vice),'']);
    }
    if(output($cllr->loss) !== '0'){
      $table->row([$spacer."Financial Loss Allowance",output($cllr->loss)],'');
    }
    if(output($cllr->expenses) !== '0'){
      $table->row([$spacer."Travel and Subsistence Expenses",output($cllr->expenses),'']);
    }
    /*if(output($cllr->care) !== '0'){
      $table->row([$spacer."Contribution to Cost of Care",output($cllr->care),'']);
    }*/
    /*if(output($cllr->attendance) !== '0'){
      $table->row([$spacer."Attendance Allowance",output($cllr->attendance),'']);
    }*/
    /*if(output($cllr->other) !== '0'){
      $table->row([$spacer."Other",output($cllr->other)]);
    }*/
    //$table->text("");
  }
  //$table->row(["Total payments to members for the year ".$year,"&pound;".number_format($total,2,'.',',')]);
  $table->text("");
  $table->setStyles(['b','b','b']);
  $table->print();
?>
<br />
<p>NOTES</p>
<p>Community and town councils in our group must pay their members &pound;156 a year (equivalent to &pound;3 a week) towards the extra household expenses (including heating, lighting, power and broadband) of working from home unless the Councillor opts out of the payment.</p>
<p>Councils must either pay their members £52 a year for the cost of office consumables required to carry out their role, or alternatively councils must enable members to claim full reimbursement for the cost of their office consumables.</p>
<p>Community and town councils in our group can make an annual payment of up to &pound;500 to up to 3 members in recognition of specific responsibilities. This is in addition to the &pound;156 towards the extra household expenses of working from home and the &pound;52 a year for the cost of office consumables required to carry out their role.

</p>
<p>Note that these rules are due to change before our next statement.</p>
</div>

<?PHP
  require "bottom.html";
?>
<script type="text/javascript">
  handleMenu($('#financial'));
</script>