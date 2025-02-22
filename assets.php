<?PHP
//cSpell:disable
ini_set('error_reporting','1');
$title = "Finance - Tangible Assets";
$desc = "The tangible assets owned on behalf of the residents by the Council";
require "stevetable.php";
require "top.html";
require "steveCSV.php";
$csv = new steveCSV('data/assets.csv');
$csv->sort('Item');
$assets = $csv->data;
//include "classes.php";
?>
<div class="nine columns" id="content">
<div role="navigation">Our other financial pages:
    <ul>
      <li><a href="accounts.php">Accounting statement</a></li>
      <li><a href="budgets.php">Budgets</a></li>
      <!--li><a href="assets.php">Tangible assets</a></li-->
      <li><a href="paymenttomembers.php">Payments to members</a></li>
    </ul>
  </div>
<h1 style="padding-left:10ox;">Tangible Assets</h1>
<p>The tangible assets owned on behalf of the residents of Tintern and Llandogo by the Council</p>
<?PHP
$table = new steveTable('{
  "tableCenter": true,
  "tableWidth": "80%",
  "tableFontSize": "2vw",
  "widths": ["70%","10%","20%"],
  "aligns": ["L","C","R"],
  "heading": ["&nbsp;Item","Qty","Total Value&nbsp;"],
  "headingBackground": "rgb(40,82,134)",
  "headingColor": "white",
  "sum": [0,0,1],
  "currency": [0,0,1],
  "currencySymbol": "&pound;",
  "decimals": 0,
  "totalLabel": "Total"
}');
$table->heading();
class Item {
  public $item;
  public $qty;
  public $total;
  function __construct($i){
    $this->item = $i;
    $this->qty = 0;
    $this->total = 0;
  }
}

foreach($assets as $item){
  if($item->Item > ''){
    $table->row([$item->Item,$item->Qty,$item->Value]);
  }
}
$table->setStyles(['b','','b']);
$table->print();
?>
</div>
<?PHP
include "bottom.html";
?>
<script type="text/javascript">
  handleMenu('#financial');
</script>
