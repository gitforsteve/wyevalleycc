<?PHP
require_once "stevetable.php";
require_once "steveCSV.php";
$d = new steveCSV("data/assets.csv");
$d->sort("item");
$table = new steveTable('{
    "tableCenter": true,
    "tableWidth": "70%",
    "tableFontSize": "1.2rem",
    "widths": ["70%","10%","20%"],
    "aligns": ["L","C","L"],
    "heading": ["&nbsp;Item","Qty","Total Value&nbsp;"],
    "headingBackground": "darkgray",
    "headingColor": "white",
    "sum": [0,0,1],
    "currency": [0,0,1],
    "currencySymbol": "&pound;",
    "noSymbolOnZero": true,
    "decimals": 0,
    "border": "b",
    "borderColor": "lightgray",
    "totalLabel": "Total"
  }');
  $table->setAligns("C");
  $table->row(["3>TANGIBLE ASSETS AS AT AUGUST 2023"]);
  $table->setAligns(["L","C","L"]);
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
  $items = [];
  $thisitem = "X";
  $thisvalue = $count = 0;
  foreach($d->data as $dataitem){
    if($thisitem !== $dataitem->item){
      $item = new Item($dataitem->item);
      $items[] = $item;
      $thisitem = $dataitem->item;
    }
    $item->qty += $dataitem->qty;
    $item->total += $dataitem->qty*$dataitem->value;
  }
  foreach($items as $item){
    if($item->item > ''){
      $table->row([$item->item,$item->qty,$item->total]);
    }
  }
  $table->setStyles(["b","","b"]);
  $table->print();
  ?>
  <div style="text-align:center;font-family:sans-serif;font-size:1.2rem">Note that no write down has been made for depreciation.<br />Individual values vary so the accumulated totals are shown</div>