<?PHP
// cSpell:disable
$title = "Accounts and financial regulations";
$description = "Documents related to our accounts and financial transactions";
require "top.html";
require 'classes.php';
?>
<div class="nine columns" id="content">
  <h1>Financial documents</h1>
  <p>These documents relate to our financial transactions and our audited accounts.</p>
<?
$auditdate = new DateTime('2021-09-30');
$now = new DateTime();
if($auditdate->diff($now)->days < 14){
echo "<p style='text-align:center;'><strong>Publication of Audited Accounts for Year ended 31st March 2021</strong><br /><br />
Regulation 15(5) of the Accounts & Audit (Wales) Regulations 2014
requires that by 30th September 2021 Tintern Community Council
publish its accounting statements for the year ended 31st March 2021, together with any certificate, opinion or report issued, given or made by the Auditor General.<br /><br />
The accounting statements in the form of an Annual Return
have been published on the Council’s website and on noticeboards..
However the accounts are published before the conclusion of the audit.<br /><br />
Due to the impact of Covid 19 the Auditor General has not yet
issued an audit opinion.</p>";
}
?>
<h2><a href="accounts.php">Annual Returns</a></h2>
  <p>This page shows the accounting statement for the last financial year after the accounts have been officially audited. The document shows income and expenditure together with a statement of balances.</p>
  <h2><a href="budgets.php">Annual Budgets</a></h2>
  <p>Each year the Council sets budgets and this page show the budget and the amount spent  for the last financial year.</p>
  <h2><a href="assets.php">Tangible Assets</a></h2>
  <p>The Council owns, on behalf of its electors, a number of actual assets. These are listed together with the value.</p>
</div>
<?PHP
  require "bottom.html";
?>
<script type="text/javascript">
  handleMenu($('#financial'));
</script>