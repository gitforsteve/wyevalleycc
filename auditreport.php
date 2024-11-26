<?PHP
//cSpell:disable
// auditreport (used to be electorsroghts)
$title = "Finance - Date for exercise of electors' rights";
$desc = "Electors can exercise their right to review our accounts on this published date";
require 'classes.php';
//require 'myCSV.class.php';
$currentyear = "2024";
$todate = "31st December 2024";
require 'top.html';
?>
<div class="nine columns" id="content">
  <div class="row" style="text-align:center;">
    <h1>NOTICE OF CONCLUSION OF AUDIT</h1>
    <h2>and right to inspect the annual return for year ended 31st March <?=$currentyear?></h2>
  </div>
  <div class="row">
    <ol>
      <li><p>The audit of accounts for <strong>Wye Valley Community Council</strong> for the year ended 31st March <?=$currentyear?> has been concluded</p></li>
      <li><p>The annual return is available for inspection by any local government elector for the areas of Tintern and Llandogo on application to</p><p style="display:flex;justify-content:center;"></span>Elizabeth Greatorex-Davies (Clerk)<br />The Poplars<br />Whitelye<br />Catbrook<br />Chepstow<br />NP16 6NP</p><p></p>between <?=$hours?> Monday to Friday (excluding bank holidays) from now until <span style="font-weight:bold;">31st December <?=$currentyear?></span>, when any local government elector may make copies of the annual return.</p></li>
      <li><p>Copies will be provided to any local government elector on payment of 20p for each copy of the annual return.</p></li>
    </ol>
  </div>
</div>
<?PHP
require 'bottom.html';
?>
<script type="text/javascript">
  $('#financial').show();
  $('#caret').html('&#X25b2;');
  handleMenu($('#electorsrights'));
</script>

