<?PHP
/**********************************************************
 * STEVETABLE IS A CLASS WRITTEN FOR PHP BY STEVE EVANS
 * AND IS COPYRIGHT (C) 2024, LICENCED FOR USE ON THIS
 * SERVER AND SYSTEM ONLY.
 **********************************************************/
function validateDate($date, $format = 'Y-m-d')
  {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
  }
  function mysort($a,$b){
    $col = $GLOBALS['col'];
    if ($a->cells[$col]->content===$b->cells[$col]->content) return 0;
    return ($a->cells[$col]->content<$b->cells[$col]->content)?-1:1;
  }
  function getBetween($content,$start,$end){
    $r = explode($start, $content);
    if(strlen($r[0]) === 0 AND strlen($r[1] === 0)){
        return $content;
    }
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
  }
  function deleteBetween($string, $beginning, $end) {
    $beginningPos = strpos($string, $beginning);
    $endPos = strpos($string, $end);
    if ($beginningPos === false || $endPos === false) {
      return $string;
    }
  
    $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);
  
    return deleteBetween(str_replace($textToDelete, '', $string), $beginning, $end ); // recursion to ensure all occurrences are replaced
  }
  class Row {
    public $style = ""; 
    public $stripe = "";
    public $cells; // array of cells
    public $heading = false;
    public $headingColor;
    public $headingBackground;
    public $subtotalRow = false;
    public $textrow = false;
    public $stripeTextcolor;
    public $borderColor;
    public $skipFieldValues;
    public $sortExclude;
    
    public $id = "";
    public function __construct($tot = false){
      $this->cells = [];
    }
    public function print(){
      if($this->heading){
        $this->style .= sprintf("font-weight:bold;background-color:%s;color:%s;",$this->headingBackground,$this->headingColor);
      }elseif($this->stripe){
        $this->style .= sprintf("background-color:%s;color:%s",$this->stripe,$this->stripeTextcolor);
      }
      // new process to cater for row id
      $s = "<tr";
      if(!is_null($this->id)){
        $s .= sprintf(" id='%s'",$this->id);
      }
      if($this->style > ''){
        $s .= sprintf(" style='%s'",$this->style);
      }
      $s .= ">";
      //$s .= $str;
      for($i=0;$i<count($this->cells);$i++){
        $cell = $this->cells[$i];
        $count = 0;
        if(substr($cell->content,1,1) === ">"){;
          $cell->colspan = substr($cell->content,0,1);
          $cell->content = substr($cell->content,2);
          $i += $cell->colspan - 1;
        }
        if(trim($cell->colspan) > ''){
          $colspan = sprintf("colspan='%s'",$cell->colspan);
        }
        $cstyles = $cell->style."width:".$cell->width.";text-align:".$cell->align;
          if($cell->border > ''){
            $cstyles .= $cell->border;
          } 
          $cstyles = "style='".$cstyles."'";
          //$submark = $cell->subtotal ? "" : "&loz;";
          if($cell->content === ""){
            $cell->content = "&nbsp;";
          }
          // set up cell id text
          if($cell->id > ''){
            $cell->id = "id='".$cell->id."' ";
          }
          if($this->heading){
            $s .= sprintf("<th %s %s %s>%s</th>\r\n",$cell->id, $colspan,$cstyles,$cell->content);
          }else{
            $s .= sprintf("<td %s %s %s %s>%s</td>\r\n",$cell->id, $cell->celleditable, $colspan,$cstyles,$cell->content);
          }
        }
      //}
      $s .= "</tr>\r\n";
      return $s;
    }
}
class Cell {
    public $css; // cell css style
    public $pointer; // from pointers
    public $style; // cell font style
    public $class; // cell class
    public $width; // cell width
    public $align; // cell align
    public $border; // cell border
    public $colour; // cell text colour
    public $background; // cell background colour
    public $prefix; // cell prefix
    public $colspan; // column span
    public $content; // content of the cell
    public $subtotal; // internal
    public $id; // identifier
    public $celleditable; // string
}
class steveTable {
  private $version = "Release 2.0";
  public $pageBreakBefore = false;
  public $aligns; //array of single character strings L-left C-centre R-right
  public $backgrounds; //array of colour names, hex or rgb
  public $border = ""; //string L-left R-right T-top B-bottom or A-all cell not table
  public $borders; // array of combinations of l,r,t and b
  public $borderCollapse = true; //Collapse border
  public $borderColor = "black"; //string of colour name, hex or rgb
  public $brackets; //Array of boolean for enclosing negative values in brackets
  public $classes; //Array of class for each column
  public $colors; //array of colour names, hex or rgb
  public $currency = "";
  public $percent = "";
  public $currencySymbol;
  public $date = "";
  public $dateFormat = "jS F Y";
  public $decimals = 2;
  public $editable = false;
  public $emptyFields = false; // show empty field instead of zeros
  public $heading; //array of heading values 
  public $headingBackground; //string colour name or value
  public $headingColor; //string colour name or value
  private $hrow; //heading row
  private $html = ""; //internal storage of output string
  public $ID = "steveTable"; //id for table
  public $keyCell = '';
  public $lineheight = 1.5; 
  public $links = [];
  public $noBorder; //array of boolean for columns which have border turned off
  public $noBottomBorder; //array of boolean to turn off bottom border
  public $noSymbolOnZero = false;
  public $noTopBorder; //array of boolean to turn off top border
  public $prefix; //Character or string to prefix - array
  public $pointers = ''; // array of pointers. 1 for pointer 0 for default
  public $rowNo = 0; //internal counter for strip
  public $rows = []; //internal row collection
  public $seperators;
  public $skipFields = []; //array of fields to be tested for duplicate
  private $skipFieldValues = [];
  public $skipStripe = false;
  public $skipText = []; //array of strings to replace duplicate fields text
  public $skipValues = []; //internal storage of value for duplicate test
  public $stripe = ""; //colour for stripe on even rows
  public $stripeTextcolor; //color for text on stripe
  public $styles; //array of strings b-bold u-underline i-italic or mix of those
  public $subTotalLabel = " ";
  public $sum; //sum for columns
  public $subtotal = false; //internal;
  public $sums = []; //internal
  public $tableBorder = false; //Border surrounding the table (not cells)
  public $tableCenter = false; //Whether to horizontally centre the table on the window
  public $tableClass = ""; //Overall class for table
  public $tableFont = "Arial,Helvetica,sans-serif"; //Font to be used for table
  public $tableFontSize = "1.2rem"; //Font size;
  public $tableStyle; //string of css for entire table
  public $tableWidth = "100%"; // Overall width of table
  public $tdeditable = [];
  public $textJustify = false;
  public $textRowActive = false;
  public $topAlign = true; //vertical align top true by default
  public $totalFormat = "";
  public $totalLabel = " ";
  public $widths; //array of strings of value and unit
  
  public function __set($property,$value){
    $this->$property = $value;
  }
  public function isJson($string) { // test for valid json string
    return ((is_string($string) &&
            (is_object(json_decode($string)) ||
            is_array(json_decode($string))))) ? true : false;
  }
  public function version(){ //return current version
    return $this->version;
  }
  public function getTotals($clear = false){
    $v =  $this->sums;
    if($clear){
      $this->sums = [];
    }
    return $v;
  }
  public function setPageBreakBefore($a){ // true or false
    $this->pageBreakBefore = $a;
  }
  public function setSeperator($a){
    $this->seperators = $a;
  }
  public function setSkip($a){ //sets skip field
    $this->skipFields = $a;
  }
  public function setTableClass($s){
    $this->tableClass = $s;
  }
  public function setClasses($s){
    $this->classes = $s;
  }
  public function setTableStyle($s){ //sets overal table styles
    if(substr($s,-1)!==";"){
      $s = ($s.";");
    }
    $this->tableStyle = $s;
  }
  public function setTableFont($s){
    $this->tableFont = $s;
  }
  public function setTableFontSize($s){
    $this->tableFontSize = $s;
  }
  public function setTableBorder($s){
    $this->tableBorder = $s;
  }
  public function setBorderCollapse($s){
    $this->borderCollapse = $s;
  }
  public function setTableWidth($s){
    $this->tableWidth = $s;
  }
  public function setTableCenter($s){
    $this->tableCenter = $s;
  }
  public function setBorder($s = ""){ //sets cell borders
      $this->border = $s;
  }
  public function setBorders($s){
      $this->borders = $s;
  }
  public function setNoTopBorder($s){
    $this->noTopBorder = $s;
  }
  public function setNoBottomBorder($s){
  $this->noBottomBorder = $s;
  }
  public function setBorderColor($s = "black"){ //sets the colour of the border
      $this->borderColor = $s;
  }
  public function setWidths($s){ //sets the widths for columns
      $this->widths = $s;
  }
  public function setAligns($s){ //sets text alignment
      $this->aligns = $s;
  }
  public function setTopAlign($s){
      $this->topAlign = $s;
  }
  public function setColors($s){ //sets colours of text in cells
      $this->colors = $s;
  }
  public function setBackgrounds($s){ //sets colour of cell backgrounds
      $this->backgrounds = $s;
  }
  public function setHeadingColor($s){
      $this->headingColor = $s;
  }
  public function setHeadingBackground($s){
      $this->headingBackground = $s;
  }
  public function setHeading($s){
      $this->heading = $s;
  }
  public function setStyles($s){ //sets text style of cells
      $this->styles = $s;
  }
  public function setSkipFields($a){ //sets fields to be tested for duplicates
    $this->skipFields = $a;
  }
  public function setSkipText($a){ //sets replacement text for duplicate fields
      $this->skipText = $a;
  }
  public function setSkipFieldValues($a){ //internal storage of field values
      $this->skipFieldValues = $a;
  }
  public function setPrefix($s){
      $this->prefix = $s;
  }
  public function setBrackets($s){
      $this->brackets = $s;
  }
  public function setStripe($s){
      $this->stripe = $s;
  }
  public function setStripeTextcolor($s){
      $this->stripeTextcolor = $s;
  }
  public function setCurrency($s){
      $this->currency = $s;
  }
  public function setCurrencysymbol($s){
      $this->currencySymbol = $s;
  }
  public function setPercent($s){
      $this->percent = $s;
  }
  public function setNoSymbolOnZero($s){
      $this->noSymbolOnZero = $s;
  }
  public function setDate($s){
      $this->date = $s;
  }
  public function setDateFormat($s){
    $this->dateFormat = $s;
  }
  public function setDecimals($s){
    $this->decimals = $s;
  }
  public function setSum($s){
      $this->sum = $s;
  }
  public function setTotalLabel($s){
      $this->totalLabel = $s;
  }
  public function setSubTotalLabel($s){
      $this->subTotalLabel = $s;
  }
  public function setEmptyFields($s){
      $this->emptyFields = $s;
  }
  public function setID($s){
    $this->ID = $s;
  }
  public function setPointers($s){
      $this->pointers = $s;
  }
  public function setLineheight($s){
    $this->lineheight = $s;
  }
  public function setEditable($s){
    $this->editable = $s;
  }
  public function setTdEditable($s){
    $this->tdeditable = $s;
  }
  public function total($sub = false){
    if($sub){
      $this->subtotal = true;
    }
    $sumarray = [];
    for($col=0;$col<count($this->widths);$col++){
      if(!$this->date[$col]){
        $sumarray[] = $this->sums[$col];
        if($this->subtotal){
          $t = end($sumarray);
        }
      }else{
        if(!validateDate($this->sums[$col],$this->dateFormat)){
          $sumarray[] = $this->totalLabel;
        }
      }
    }
    if($this->subtotal){
      if($this->subTotalLabel > ' '){
        $sumarray[0] = $this->subTotalLabel;
      }
    }else{
      if($this->totalLabel > ' '){
        $sumarray[0] = $this->totalLabel;
      }
    }
    $this->row($sumarray);
    if(!$sub){
      $this->sums = [];
    }
    $this->subtotal = false;
  }
//******** */
  public function boldtotal($sub = false){
    $this->fontWeight("b");
    $this->total($sub);
    $this->fontWeight("");
  }
//******** */
  public function reset($s=''){ //analyse json string and set properties
    if($this->isJson($s)){
      $obj = json_decode($s);
      if(isset($obj->tableClass) && $obj->tableClass > ''){
        $this->setTableClass($obj->tableClass);
      }
      if(isset($obj->pageBreakBefore)){
        $this->setPageBreakBefore($obj->pageBreakBefore);
      }
      if(isset($obj->classes)){
        $this->setClasses($obj->classes);
      }
      if(isset($obj->tableStyle)){
        $this->setTableStyle($obj->tableStyle);
      }
      if(isset($obj->tableFont)){
        $this->setTableFont($obj->tableFont);
      }
      if(isset($obj->tableFontSize)){
        $this->setTableFontSize($obj->tableFontSize);
      }
      if(isset($obj->tableBorder)){
        $this->setTableBorder($obj->tableBorder);
      }
      if(isset($obj->borderCollapse)){
        $this->borderCollapse = $obj->borderCollapse;
      }
      if(isset($obj->tableWidth)){
        $this->tableWidth = $obj->tableWidth;
      }
      if(isset($obj->tableCenter)){
        $this->tableCenter = $obj->tableCenter;
      }
      if(isset($obj->widths)){
        $this->setWidths($obj->widths);
      }
      if(isset($obj->aligns)){
        $this->setAligns($obj->aligns);
      }
      if(isset($obj->topAlign)){
        $this->topAlign = $obj->topAlign;
      }
      if(isset($obj->border)){
        $this->setBorder($obj->border);
      }
      if(isset($obj->borders)){
        $this->setBorders($obj->borders);
      }
      //if(isset($obj->noBorder)){
      //  $this->setNoBorder($obj->noBorder);
      //}
      if(isset($obj->noTopBorder)){
        $this->setNoTopBorder($obj->noTopBorder);
      }
      if(isset($obj->noBottomBorder)){
        $this->setNoBottomBorder($obj->noBottomBorder);
      }
      if(isset($obj->borderColor)){
        $this->setBorderColor($obj->borderColor);
      }
      if(isset($obj->colors)){
        $this->setColors($obj->colors);
      }
      if(isset($obj->backgrounds)){
        $this->setBackgrounds($obj->backgrounds);
      }
      if(isset($obj->headingColor)){
        $this->setHeadingColor($obj->headingColor);
      }
      if(isset($obj->headingBackground)){
        $this->setHeadingBackground($obj->headingBackground);
      }
      if(isset($obj->heading)){
        $this->setHeading($obj->heading);
      }
      if(isset($obj->styles)){
        $this->setStyles($obj->styles);
      }
      if(isset($obj->skipFields)){
        $this->setSkipFields($obj->skipFields);
      }
      if(isset($obj->skipText)){
        $this->skipText = $obj->skipText;
      }
      if(isset($obj->skipFieldValues)){
        $this->setSkipFieldValues($obj->setSkipFieldValues);
      }
      if(isset($obj->prefix)){
        $this->setPrefix($obj->prefix);
      }
      if(isset($obj->brackets)){
        $this->setBrackets($obj->brackets);
      }
      if(trim($obj->stripe) > ''){
        $this->setStripe($obj->stripe);
      }
      if(isset($obj->stripeTextcolor)){
        $this->setStripeTextcolor($obj->stripeTextcolor);
      }
      if(isset($obj->currency)){
        $this->setCurrency($obj->currency);
      }
      if(isset($obj->currencySymbol)){
        $this->setCurrencySymbol($obj->currencySymbol);
      }
      if(isset($obj->percent)){
        $this->setPercent($obj->percent);
      }
      if(isset($obj->noSymbolOnZero)){
        $this->setNoSymbolOnZero($obj->noSymbolOnZero);
      }
      if(isset($obj->date)){
        $this->setDate($obj->date);
      }
      if(isset($obj->dateFormat)){
        $this->setDateFormat($obj->dateFormat);
      }
      if(isset($obj->decimals)){
        $this->setDecimals($obj->decimals);
      }
      if(isset($obj->sum)){
        $this->setSum($obj->sum);
      }
      if(isset($obj->totalLabel)){
        $this->totalLabel = $obj->totalLabel;
      }
      if(isset($obj->subTotalLabel)){
        $this->subTotalLabel = $obj->subTotalLabel;
      }
      if(isset($obj->emptyFields)){
        $this->emptyFields = $obj->emptyFields;
      }
      if(isset($obj->ID)){
        $this->ID = $obj->ID;
      }
      if(isset($obj->keyCell)){
        $this->keyCell = $obj->keyCell;
      }
      if(isset($obj->pointers)){
        $this->pointers = $obj->pointers;
      }
      if(isset($obj->lineheight)){
        $this->lineheight = $obj->lineheight;
      }
      if(isset($obj->links)){
        $this->links = $obj->links;
      }
      if(isset($obj->editable)){
        $this->editable = $obj->editable;
      }
      if(isset($obj->tdeditable)){
        $this->tdeditable = $obj->tdeditable;
      }
   }else{
    printf("<p style='font-weight:bold;color:red;'>steveTable version %s <br />Invalid json string (%s)<br /></p>",$this->version,json_last_error_msg());
    exit($s);
   }
}
public function __construct($s=''){
  $this->reset($s);
  $this->rowNo = 1;
}
public function fontWeight($s = ""){
  if(strtolower($s) === "b"){
    $this->reset('{ "styles": ["b","b","b","b","b","b","b","b","b","b","b","b"]}');
  }else{
    $this->reset('{ "styles": ["","","","","","","","","","","","","","","",""]}');
  }
}

public function clearTable(){
  $this->rows = [];
}
public function empty(){
  $this->rows = [];
}

public function center(){
  $this->reset('{ "aligns": ["c"] }');
}

public function skipStripe(){
  $this->skipStripe = !$this->skipStripe;
}

public function emptyFields(){
  // if true zero fields will be empty oyjerwise displayed
  $this->emptyFields = !$this->emptyFields;
}

public function text($s = ""){
  //$s = str_replace("\n","<br />",$s);
  //$r = new Row();
  //$r->style = $this->styles;
  //$c = new Cell;
  $this->textRowActive = true;
  if($s === ""){
    $s = "&nbsp;";
  }
  $tarray = [$s];
  for($i=1;$i<count($this->widths);$i++){
    array_push($tarray,"");
  }
  $this->row($tarray);
  }

public function heading(){
  $this->row($this->heading,'',true);
}

public function row($s,$id = null,$h = false){
  $s = str_replace("\n","<br />",$s);
  $r= new Row();
  // assign row id
  if(!is_null($id)){
    $r->id = $id;
  }
  //
  if($h){
    $r->heading = true;
    $r->headingColor = $this->headingColor;
    $r->headingBackground = $this->headingBackground;
  }else{
    if($this->stripe > '' && count($this->rows) > 1 && count($this->rows) % 2 === 0){
      if(!$this->skipStripe){
        $r->stripe = $this->stripe;
      }
    }
  }
  $count = 0;
  if($this->textRowActive){
    $max = 1;
  }else{
    $max = count($this->widths);
  }
  for($i=0;$i<$max;$i++){
    $c = new Cell();
    // CHECK FOR CELL ID
    $c->id = getBetween($s[$i],"{","}");
    if($c->id > ''){
      $s[$i] = deleteBetween($s[$i],"{","}");
    }
    if($this->tdeditable[$i]){
      $c->celleditable = "contenteditable";
    }
    if($this->textRowActive){
      $c->colspan = count($this->widths);
    }
    if($this->sum[$i] && is_numeric($s[$i]) && !$this->subtotal){
      $this->sums[$i] += floatval($s[$i]);
      $c->subtotal = $this->sums[$i];
    }else{
      if($this->sum[$i] && !$this->subtotal){
        $newval = $s[$i];
        // removed to prevent headings being included in total
        // when they contain numerics
       /* while(!is_numeric($newval) && $newval > ''){
          $newval = substr($newval,1);
        }*/
        if($newval > '' && is_numeric($newval)){
          $this->sums[$i] += floatval($newval);
        }
        $c->subtotal = $this->sums[$i];
      }
    }
    $c->class = $this->classes[$i];
    $c->width = $this->widths[$i];
    if($this->currency[$i]){
      $c->align .= "right;";
    }
    switch(strtoupper($this->aligns[$i])){
      case 'L': $c->align .= "left;"; break;
      case 'C': $c->align .= "center;"; break;
      case 'R': $c->align .= "right;"; break;
      default : $c->align .= "left;"; break;
    }
    if($this->border > ''){
      if(is_numeric(stripos($this->border,'a'))){
        $c->border = "border-right:1px solid ".$this->borderColor.";"; 
        $c->border .= "border-left:1px solid ".$this->borderColor.";"; 
        if(!$this->noTopBorder[$i]){
          $c->border .= "border-top:1px solid ".$this->borderColor.";";
        }
        if(!$this->noBottomBorder[$i]){
          $c->border .= "border-bottom:1px solid ".$this->borderColor.";"; 
        }
      }else{
        if(is_numeric(stripos($this->border,'l'))){
          $c->border = "border-left:1px solid ".$this->borderColor.";";
        }
        if(is_numeric(stripos($this->border,'r'))){
          $c->border = "border-right:1px solid ".$this->borderColor.";";
        }
        if(is_numeric(stripos($this->border,'t'))){
          if(!$this->noTopBorder[$i]){
            $c->border = "border-top:1px solid ".$this->borderColor.";";
          }
        }
        if(is_numeric(stripos($this->border,'b'))){
          if(!$this->noBottomBorder[$i]){
            $c->border = "border-bottom:1px solid ".$this->borderColor.";";
          }
        }
      }
     }
     // multiple borders
    if(isset($this->borders[$i])){
      if(is_numeric(stripos($this->border,'t'))){
        $c->border .= "border-top:1px solid ".$this->borderColor.";";
      }
      if(is_numeric(stripos($this->border,'b'))){
        $c->border .= "border-bottom:1px solid ".$this->borderColor.";";
      }
      if(is_numeric(stripos($this->border,'r'))){
        $c->border .= "border-right:1px solid ".$this->borderColor.";";
      }
      if(is_numeric(stripos($this->border,'l'))){
        $c->border .= "border-left:1px solid ".$this->borderColor.";";
      }
    }
    if(isset($this->styles[$i]) && $this->styles[$i] > ''){
      if(is_numeric(stripos($this->styles[$i],'b'))){
            $c->style.="font-weight:bold;";
      }
      if(is_numeric(stripos($this->styles[$i],'u'))){
            $c->style.="text-decoration:underline;";
      }
      if(is_numeric(stripos($this->styles[$i],'i'))){
            $c->style.="font-style:italic;";
      }
    }
    //if($i === 0 && $this->pointers[$i]){
    if($this->pointers[$i]){
      $c->style .= "cursor:pointer;";
    }
    if($this->backgrounds[$i] > '' && !$r->heading){
      $c->style .= "background-color:".$this->backgrounds[$i].";";
    }
    if($this->colors[$i] > '' && !$r->heading){
      $c->style .= "color:".$this->colors[$i].";";
    }
    if($this->topAlign > '' && $this->topAlign !== false){
      $c->style .= "vertical-align:top;";
    }
    if($this->seperators[$i]){
      $c->style .= "border-right:2px solid ".$this->borderColor.";";
    }
    if(count($this->skipFields) > 0){
      if(in_array($i,$this->skipFields)){
        if(trim($s[$i]) === trim($this->skipFieldValues[$i])){
          $s[$i] = $this->skipText[$i];
        }elseif(!$this->textRowActive){
          $this->skipFieldValues[$i] = $s[$i];
        }
      }
    }
    if($this->currency[$i] && !$r->heading){
      $symbol = $this->currencySymbol;
      // empty fields not to display if 0
      if(floatval($s[$i]) === 0.00){
        if($this->emptyFields){
          $s[$i] = "";
          $out = "";
        }
        if($this->noSymbolOnZero){
          $symbol = "";
        }
      }elseif(floatval($s[$i]) < 0){
        $v = floatval($s[$i]);
        $out = $symbol.number_format(abs($v),$this->decimals,'.',',');
        if(isset($this->brackets[$i])){
          $s[$i] = "(".$out.")";
        }
      }else{
        $s[$i] = $symbol.number_format(floatval($s[$i]),$this->decimals,'.',',');
      }
    }
    if($this->percent[$i] && !$r->heading){
      $out = floatval($s[$i])*100;
      $s[$i] = number_format($out,0,'.',',')."%";
    }
    if($this->date[$i] && !$r->heading && validateDate($s[$i])){
      $c->content = date($this->dateFormat,strtotime($s[$i]));
    }else{
        $c->content = $s[$i];
    }
    if($this->links[$i] && filter_var($s[$i], FILTER_VALIDATE_URL)!==false){
        $c->content = sprintf("<a href='%s'>%s</a>",$s[$i],$s[$i]);
    }
    array_push($r->cells,$c);
   }
    array_push($this->rows,$r);
    $this->textRowActive = false;
  }


  public function sort($col){
    //$storedheading = '';
    if(isset($this->heading)){
      $storedheading = array_shift($this->rows);
    }
    $GLOBALS['col'] = $col - 1;
    if($col-1 > count($this->widths)){
      trigger_error("<p style='font-weight:bold;color:red;'>steveTable version ".$this->version."<br />Invalid sort column<br />Not that many columns</p>");
      exit;
    }
    if($col-1 < 0){
      trigger_error("<p style='font-weight:bold;color:red;'>steveTable version ".$this->version."<br />Invalid sort column<br />Lowest value is 1</p>");
      exit;
    }
    usort($this->rows,"mysort");
    if(isset($this->heading)){
      array_unshift($this->rows,$storedheading);
    }
  }

  public function print($asString = false){ //displays the internal html
    $tstyle = "";
    // get total row
    if(count($this->sums)>0){
      $this->total();
    }
    if($this->tableCenter){
      $this->tableStyle.="margin:0 auto;";
    }
    if($this->tableBorder){
      $this->tableStyle.="border:1px solid ".$this->borderColor.";";
    }
    if($this->lineheight){
      $this->tableStyle.="line-height:".$this->lineheight
    .";";
    }
    if($this->tableStyle.="font-family:".$this->tableFont.";font-size:".$this->tableFontSize.";");
    if(isset($this->tableClass) && $this->tableClass > ''){
      $tstyle = "class='".$this->tableClass."' ";
    }
    if($this->tableStyle > ''){
      $tstyle .= "style='".$this->tableStyle;
    }
    $tstyle = $tstyle."width:".$this->tableWidth.";";
    
    if($this->borderCollapse){
      $tstyle.="border-collapse:collapse;";
    }
    if($this->editable){
      $edit = "contenteditable";
    }else{
      $edit = "";
    }
    if($this->pageBreakBefore){
      $tstyle.=";page-break-before:always;";
    }
    $this->html = "<table ".$edit." ver='steveTable ".$this->version."' id='".$this->ID."' keyCell='".$this->keyCell."' ".$tstyle."'>";
    foreach($this->rows as $row){
      if($row == $this->rows[count($this->rows)]){
        if($this->date[0]){
          $row[0] = $this->totalLabel;
        }
      }
      $this->html .= $row->print();
    }
    $this->html .= "</table>";
    if($asString){
      return $this->html;
    }else{
      print($this->html);
    }
  }
  public function save($filename = "saved_table.html"){
    $content = $this->print(true);
    file_put_contents($filename,$content);
  }
  public function csv($filename = ""){
    $output = "";
    foreach($this->rows as $row){
      $temp = [];
      foreach($row->cells as $cell){
        $temp[] = strip_tags($cell->content);
      }
      $line = implode(",",$temp);
      $temp = implode("",explode("&nbsp;",$line));      $output .= $line."\r\n";
    }
    if($filename > ''){
      file_put_contents($filename,$output);
    }else{
      echo $output;
    }
  }
}
