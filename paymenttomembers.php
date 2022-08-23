<?PHP
//cSpell:disable
$title = "Payments to members";
$desc = "Statement of payments made to members";
require 'MyCSV.class.php';
require 'top.html';
$d = new MyCSV("data/payments.csv");
$data = $d->toObj();
$total = 0;
function output($v){
  if($v === ''){
    return "nil";
  }
  return "&pound;".number_format($v,2,'.',',');
}
/*********** SET FINANCIAL YEAR *************/
$year = "2021 - 2022";
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
  foreach($data as $cllr){
    if(output($cllr->total) !== 'nil'){
      printf("<strong>%s Total %s</strong><br />",$cllr->Councillor,output($cllr->total));
      $total += floatval($cllr->total);
    }
    if(output($cllr->telephone) !== 'nil'){
      printf("Telephone, broadband, etc. %s<br />",output($cllr->telephone));
    }
    if(output($cllr->responsibility) !== 'nil'){
      printf("Responsibility allowance %s<br />",output($cllr->responsibility));
    }
    if(output($cllr->allowance) !== 'nil'){
      printf("Chair's allowance %s<br />",output($cllr->allowance));
    }
    if(output($cllr->loss) !== 'nil'){
      printf("Financial loss allowance %s<br />",output($cllr->loss));
    }
    if(output($cllr->expenses) !== 'nil'){
      printf("Travel and subsistence %s<br />",output($cllr->expenses));
    }
    if(output($cllr->care) !== 'nil'){
      printf("Care allowance %s<br />",output($cllr->care));
    }
    if(output($cllr->other) !== 'nil'){
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