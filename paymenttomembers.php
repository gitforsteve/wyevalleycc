<?PHP
//cSpell:disable
$title = "Payments to members";
$desc = "Statement of payments made to members";
require 'steveCSV.php';
require 'top.html';
$d = new steveCSV("data/payments.csv");
$data = $d->data;
$total = 0;
function output($v){
  if($v === '0'){
    return "0";
  }
  return "&pound;".number_format($v,2,'.',',');
}
/*********** SET FINANCIAL YEAR *************/
$year = "2022 - 2023";
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
<p>Statement of payments made to members of the Community Council for the financial year <?=$year?></p>
<p> 
<?PHP
//"Councillor","Basic Payment","Responsibility Payment","Chair's Payment","Vice Chair's Payment","Loss Allowance","Travel and Subsistence","Cost of Care","Attendance","Other","total"
  foreach($data as $cllr){
    if(output($cllr->total) !== '0'){
      printf("<strong>%s Total %s</strong><br />",$cllr->councillor,output($cllr->total));
      $total += floatval($cllr->total);
    }
    if(output($cllr->basic) !== '0'){
      printf("Basic Payment. %s<br />",output($cllr->basic));
    }
    if(output($cllr->responsibility) !== '0'){
      printf("Responsibility Payment %s<br />",output($cllr->responsibility));
    }
    if(output($cllr->chair) !== '0'){
      printf("Chair's Payment %s<br />",output($cllr->chair));
    }
    if(output($cllr->vice) !== '0'){
      printf("Vice Chair's Payment %s<br />",output($cllr->loss));
    }
    if(output($cllr->loss) !== '0'){
      printf("Loss Allowance %s<br />",output($cllr->expenses));
    }
    if(output($cllr->expenses) !== '0'){
      printf("Travel and Subsistence Expenses %s<br />",output($cllr->expenses));
    }
    if(output($cllr->care) !== '0'){
      printf("Contribution to Cost of Care %s<br />",output($cllr->care));
    }
    if(output($cllr->attendance) !== '0'){
      printf("Attendance Allowance %s<br />",output($cllr->expenses));
    }
    if(output($cllr->other) !== '0'){
      printf("Other %s<br />",output($cllr->other));
    }
  }
  printf("</p><p>Total payments to members for the year %s: &pound;%s</p>",$year,number_format($total,2,'.',','));
  ?>
<p style="font-size:80%;">In accordance with Section 151 of the Local Government Measure 2011, Community and Town Councils must publish within their authority area the remuneration received by their members by 30th September following the end of the previous financial year.</p></div>

<?PHP
  require "bottom.html";
?>
<script type="text/javascript">
  handleMenu($('#financial'));
</script>