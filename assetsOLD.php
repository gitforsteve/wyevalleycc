<?PHP
//cSpell:disable
require_once "stevetable.php";
if(!class_exists('Database')){
  require_once "classes.php";
}
class Assetitem {
  public $type;
  public $count;
  public $total;
}
$title = "Finance - Tangible Assets";
$desc = "The tangible assets owned on behalf of the residents by the Council";
include "top.html";

echo "<h1>Tangible Assets</h1><br />";
echo "<p>The tangible assets owned on behalf of the residents of Tintern and Llandogo by the Council</p>";
$table = new steveTable('{
  "tableCenter": true,
  "tableWidth": "70%",
  "tableFontSize": "15vw",
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
$q = new Database('Asset');
$items = $q->getData("select * from asset order by item");

$thisitem = '';
$assetitems = [];
foreach($items as $asset){
  if($asset->item !== $thisitem){
    $assetitem = new Assetitem;
    $assetitem->type = $asset->item;
    $assetitem->count = 1;
    $assetitem->total = $asset->value;
    $assetitems[] = $assetitem;
    $thisitem = $asset->item;
  }else{
    $assetitem->total += $asset->value;
    $assetitem->count += 1;
  }
}
$table->heading();
foreach($assetitems as $item){
  $table->row([$item->type,$item->count,$item->total]);
}
$table->print();
include "bottom.html";
?>
<script type="text/javascript">
  handleMenu('#financial');
</script>
