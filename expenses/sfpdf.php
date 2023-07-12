<?PHP
///////// 20190823 ////////

require 'fpdf.php';

class SFPDF extends FPDF {
  function SetWeight($w = ""){
  // shortcut to set the font weight
    switch($w){
      case "b" : $this->SetFont("","B"); break;
      case "B" : $this->SetFont("","B"); break;
      case "" : $this->SetFont("","");
    }
  }
  function FontWeight($w = ""){
  // set font weight calls SetWeight
	  $this->SetWeight($w);
  }
  function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

  // BULLETED MULTICELL
  function MultiCellBlt($w, $h, $blt, $txt, $border=0, $align='L', $fill=false){
  // produces a multicell with a bullet (single only)
	  //Get bullet width including margins
    $blt_width = $this->GetStringWidth($blt)+$this->cMargin*2;

    //Save x
    $bak_x = $this->x;

    //Output bullet
    $this->Cell($blt_width,$h,$blt,0,'',$fill);

    //Output text
    $this->MultiCell($w-$blt_width,$h,$txt,$border,$align,$fill);

    //Restore x
    $this->x = $bak_x;
  }


  // RULERS
  function SetDash($black=null, $white=null){
  // sets the dash for dashed line
	if($black and $white){
	    $s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
	}else{
	    $s='[] 0 d';
	}
	$this->_out($s);
  }

  function DottedLine($x,$y,$w,$space=0,$count=1,$lw=0.2,$dashed=0.5){
  // produces a dotted line
    $this->SetLineWidth($lw);
    $this->SetDash($dashed,$dashed);
    for($i=0;$i<$count;$i++){
      $this->Line($x,$y,$x+$w,$y);
      $y+=$space;
    }
    $this->SetLineWidth(0.2);
    $this->SetDash();
  }

  function vLine($x,$y,$h,$space=0,$count=1,$lw=0.2,$darkline=array()){
  // produces any number of vertical line
    $darklines = false;
    $repeat = 0;
    if(is_array($darkline)){
      $darklines = true;
      if(substr($darkline[0],0,5) == 'every'){
	$repeat = substr($darkline[0],6);
      }
    }
    for($i=0;$i<$count;$i++){
      $this->SetLineWidth($lw);
      if($darklines){
	if(in_array($i+1,$darkline)){
	  $this->SetLineWidth($lw*3);
	}elseif($repeat > 0){
	  if(($i+1) % intval($repeat) === 0) {
	    $this->SetLineWidth($lw*3);
	  }
	}
      }
     $this->Line($x, $y, $x, $y+$h);
      $x+=$space;
    }
    $this->SetLineWidth(0.2);
  }

  function hLine($x,$y,$w,$space=0,$count=1,$lw=0.2,$darkline=array()){
  // produces any number of horizontal lines
    $darklines = false;
    $repeat = 0;
    if(is_array($darkline)){
      $darklines = true;
      if(substr($darkline[0],0,5) == 'every'){
	$repeat = substr($darkline[0],6);
      }
    }
    for($i=0;$i<$count;$i++){
      $this->SetLineWidth($lw);
      if($darklines){
	if(in_array($i+1,$darkline)){
	  $this->SetLineWidth($lw*3);
	}elseif($repeat > 0){
	  if(($i+1) % intval($repeat) === 0) {
	    $this->SetLineWidth($lw*3);
	  }
	}
      }
      $this->Line($x,$y,$x+$w,$y);
      $y+=$space;
    }
    $this->SetLineWidth(0.2);
  }

  function hLabel($x,$y,$w,$h=5,$labels=array(),$align="L"){
  // produces any number of labels horizontally on the page
    $oldx = $this->GetX();
    $oldy = $this->GetY();
    $this->SetXY($x, $y);
    for($i=0;$i<count($labels);$i++){
      $this->Cell($w, $h, $labels[$i],0,0,$align);
    }
    $this->SetXY($oldx,$oldy);
  }

  function vLabel($x,$y,$w,$h=5,$labels=array(),$align="L"){
  // produces any number of labels vertically on the page
    $oldx = $this->GetX();
    $oldy = $this->GetY();
    $this->SetMargins($x, 10);
    $this->SetXY($x,$y);
    for($i=0;$i<count($labels);$i++){
      $this->Cell($w, $h, $labels[$i],0,1,$align);
      //$this->Ln($h);
    }
    $this->SetMargins(10, 10);
    $this->SetXY($oldx, $oldy);
  }

  function MusicRule($x,$y,$w,$staves,$space,$border,$sets){
  // produces a set of lines as music staves
    $oldx = $this->GetX();
    $oldy = $this->GetY();
    $this->SetXY($x,$y);
    for($s=0;$s<$sets;$s++){
      $this->Line($x,$y,$x,$y+($space*($staves-1)));
      $this->Line($x+$w,$y,$x+$w,$y+($space*($staves-1)));
      for($l=0;$l<$staves;$l++){
	$this->Line($x,$y,$x+$w,$y);
	$y+=$space;
      }
      $y+=$border;
    }
    $this->SetXY($oldx,$oldy);
  }

  // rotation
  var $angle=0;

  function Rotate($angle,$x=-1,$y=-1)
  {
      if($x==-1)
	  $x=$this->x;
      if($y==-1)
	  $y=$this->y;
      if($this->angle!=0)
	  $this->_out('Q');
      $this->angle=$angle;
      if($angle!=0)
      {
	  $angle*=M_PI/180;
	  $c=cos($angle);
	  $s=sin($angle);
	  $cx=$x*$this->k;
	  $cy=($this->h-$y)*$this->k;
	  $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
      }
  }

  function RotatedText($x,$y,$txt,$angle)
  {
      //Text rotated around its origin
      $this->Rotate($angle,$x,$y);
      $this->Text($x,$y,$txt);
      $this->Rotate(0);
  }

  function RotatedImage($file,$x,$y,$w,$h,$angle)
  {
      //Image rotated around its upper-left corner
      $this->Rotate($angle,$x,$y);
      $this->Image($file,$x,$y,$w,$h);
      $this->Rotate(0);
  }

  function Bold($width,$height,$text,$border=0,$newline=0,$align='L'){
  // produces a cell with bold text
    $this->SetFont('','B');
    $this->Cell($width,$height,$text,$border,$newline,$align);
    $this->SetFont('','');
  }

  function Red($width,$height,$text,$border=0,$newline=0,$align='L'){
  // produces a cell with red text
    $this->SetTextColor(255,0,0);
    $this->Cell($width,$height,$text,$border,$newline,$align);
    $this->SetTextColor(0);
  }


  function Justify($text, $w, $h)
  {
      $tab_paragraphe = explode("\n", $text);
      $nb_paragraphe = count($tab_paragraphe);
      $j = 0;

      while ($j<$nb_paragraphe) {

	  $paragraphe = $tab_paragraphe[$j];
	  $tab_mot = explode(' ', $paragraphe);
	  $nb_mot = count($tab_mot);

	  // Handle strings longer than paragraph width
	  $k=0;
	  $l=0;
	  while ($k<$nb_mot) {

	      $len_mot = strlen ($tab_mot[$k]);
	      if ($len_mot<($w-5) )
	      {
		  $tab_mot2[$l] = $tab_mot[$k];
		  $l++;    
	      } else {
		  $m=0;
		  $chaine_lettre='';
		  while ($m<$len_mot) {

		      $lettre = substr($tab_mot[$k], $m, 1);
		      $len_chaine_lettre = $this->GetStringWidth($chaine_lettre.$lettre);

		      if ($len_chaine_lettre>($w-7)) {
			  $tab_mot2[$l] = $chaine_lettre . '-';
			  $chaine_lettre = $lettre;
			  $l++;
		      } else {
			  $chaine_lettre .= $lettre;
		      }
		      $m++;
		  }
		  if ($chaine_lettre) {
		      $tab_mot2[$l] = $chaine_lettre;
		      $l++;
		  }

	      }
	      $k++;
	  }

	  // Justified lines
	  $nb_mot = count($tab_mot2);
	  $i=0;
	  $ligne = '';
	  while ($i<$nb_mot) {

	      $mot = $tab_mot2[$i];
	      $len_ligne = $this->GetStringWidth($ligne . ' ' . $mot);

	      if ($len_ligne>($w-5)) {

		  $len_ligne = $this->GetStringWidth($ligne);
		  $nb_carac = strlen ($ligne);
		  $ecart = (($w-2) - $len_ligne) / $nb_carac;
		  $this->_out(sprintf('BT %.3F Tc ET',$ecart*$this->k));
		  $this->MultiCell($w,$h,$ligne);
		  $ligne = $mot;

	      } else {

		  if ($ligne)
		  {
		      $ligne .= ' ' . $mot;
		  } else {
		      $ligne = $mot;
		  }

	      }
	      $i++;
	  }

	  // Last line
	  $this->_out('BT 0 Tc ET');
	  $this->MultiCell($w,$h,$ligne);
	  $tab_mot = '';
	  $tab_mot2 = '';
	  $j++;
      }
  }

  function WriteText($text)
  {
      $intPosIni = 0;
      $intPosFim = 0;
      if (strpos($text,'<')!==false && strpos($text,'[')!==false)
      {
	  if (strpos($text,'<')<strpos($text,'['))
	  {
	      $this->Write(5,substr($text,0,strpos($text,'<')));
	      $intPosIni = strpos($text,'<');
	      $intPosFim = strpos($text,'>');
	      $this->SetFont('','B');
	      $this->Write(5,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1));
	      $this->SetFont('','');
	      $this->WriteText(substr($text,$intPosFim+1,strlen($text)));
	  }
	  else
	  {
	      $this->Write(5,substr($text,0,strpos($text,'[')));
	      $intPosIni = strpos($text,'[');
	      $intPosFim = strpos($text,']');
	      $w=$this->GetStringWidth('a')*($intPosFim-$intPosIni-1);
	      $this->Cell($w,$this->FontSize+0.75,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1),1,0,'');
	      $this->WriteText(substr($text,$intPosFim+1,strlen($text)));
	  }
      }
      else
      {
	  if (strpos($text,'<')!==false)
	  {
	      $this->Write(5,substr($text,0,strpos($text,'<')));
	      $intPosIni = strpos($text,'<');
	      $intPosFim = strpos($text,'>');
	      $this->SetFont('','B');
	      $this->WriteText(substr($text,$intPosIni+1,$intPosFim-$intPosIni-1));
	      $this->SetFont('','');
	      $this->WriteText(substr($text,$intPosFim+1,strlen($text)));
	  }
	  elseif (strpos($text,'[')!==false)
	  {
	      $this->Write(5,substr($text,0,strpos($text,'[')));
	      $intPosIni = strpos($text,'[');
	      $intPosFim = strpos($text,']');
	      $w=$this->GetStringWidth('a')*($intPosFim-$intPosIni-1);
	      $this->Cell($w,$this->FontSize+0.75,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1),1,0,'');
	      $this->WriteText(substr($text,$intPosFim+1,strlen($text)));
	  }
	  else
	  {
	      $this->Write(5,$text);
	  }

      }
  }
  function GetMultiCellHeight($w, $h, $txt, $border=null, $align='J') {
	  // Calculate MultiCell with automatic or explicit line breaks height
	  // $border is un-used, but I kept it in the parameters to keep the call
	  //   to this function consistent with MultiCell()
	  $cw = &$this->CurrentFont['cw'];
	  if($w==0)
		  $w = $this->w-$this->rMargin-$this->x;
	  $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
	  $s = str_replace("\r",'',$txt);
	  $nb = strlen($s);
	  if($nb>0 && $s[$nb-1]=="\n")
		  $nb--;
	  $sep = -1;
	  $i = 0;
	  $j = 0;
	  $l = 0;
	  $ns = 0;
	  $height = 0;
	  while($i<$nb)
	  {
		  // Get next character
		  $c = $s[$i];
		  if($c=="\n")
		  {
			  // Explicit line break
			  if($this->ws>0)
			  {
				  $this->ws = 0;
				  $this->_out('0 Tw');
			  }
			  //Increase Height
			  $height += $h;
			  $i++;
			  $sep = -1;
			  $j = $i;
			  $l = 0;
			  $ns = 0;
			  continue;
		  }
		  if($c==' ')
		  {
			  $sep = $i;
			  $ls = $l;
			  $ns++;
		  }
		  $l += $cw[$c];
		  if($l>$wmax)
		  {
			  // Automatic line break
			  if($sep==-1)
			  {
				  if($i==$j)
					  $i++;
				  if($this->ws>0)
				  {
					  $this->ws = 0;
					  $this->_out('0 Tw');
				  }
				  //Increase Height
				  $height += $h;
			  }
			  else
			  {
				  if($align=='J')
				  {
					  $this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
					  $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
				  }
				  //Increase Height
				  $height += $h;
				  $i = $sep+1;
			  }
			  $sep = -1;
			  $j = $i;
			  $l = 0;
			  $ns = 0;
		  }
		  else
			  $i++;
	  }
	  // Last chunk
	  if($this->ws>0)
	  {
		  $this->ws = 0;
		  $this->_out('0 Tw');
	  }
	  //Increase Height
	  $height += $h;

	  return $height;

    }
    function hex2rgb($hex) {
      $hex = str_replace("#", "", $hex);
      if(strlen($hex) == 3) {
	$r = hexdec(substr($hex,0,1).substr($hex,0,1));
	$g = hexdec(substr($hex,1,1).substr($hex,1,1));
	$b = hexdec(substr($hex,2,1).substr($hex,2,1));
      } else {
       $r = hexdec(substr($hex,0,2));
	$g = hexdec(substr($hex,2,2));
	$b = hexdec(substr($hex,4,2));
      }
      $rgb = array($r, $g, $b);
      return implode(",", $rgb); // STRING returns the rgb values separated by commas
    }
    function SetFillColorS($color){ 
    // sets fill colour based on hex value
	if(substr($color,0,1)=='#'){
	  $color = $this->hex2rgb($color);
	}
	$rgb = explode(',', $color); 
	if(count($rgb) != 3){ 
	   user_error("invalid parameter '$color'"); 
	   return false; 
	} 
	$this->SetFillColor((int)$rgb[0], (int)$rgb[1], (int)$rgb[2]); 
	//return true; 
     } 
    function SetTextColorS($color){ 
    // sets text colour based on hex value
	if(substr($color,0,1)=='#'){
	  $color = $this->hex2rgb($color);
	}
	$rgb = explode(',', $color); 
	if(count($rgb) != 3){ 
	   user_error("invalid parameter '$color'"); 
	   return false; 
	} 
	$this->SetTextColor((int)$rgb[0], (int)$rgb[1], (int)$rgb[2]); 
	//return true; 
     } 
    function SetDrawColorS($color){ 
    // sets draw colour based on hex value
	if(substr($color,0,1)=='#'){
	  $color = $this->hex2rgb($color);
	}
	$rgb = explode(',', $color); 
	if(count($rgb) != 3){ 
	   user_error("invalid parameter '$color'"); 
	   return false; 
	} 
	$this->SetDrawColor((int)$rgb[0], (int)$rgb[1], (int)$rgb[2]); 
	//return true; 
     } 
     function SpreadText($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link=''){
       $newtext = implode(' ',str_split($txt));
       $this->Cell($w, $h, $newtext, $border, $ln, $align, $fill, $linl);
     }
     function fitText($txt, $w=0, $auto=0){
       $fsize = $this->FontSizePt;
       $w = $w !==0 ? $w : $this->w-20;
       if($auto>0){
	 $txt = wordwrap($txt,$auto,'/n',true);
       }
       $lines = explode("/n",$txt);
       foreach($lines as $line){
	  $size = 10;
	  $this->SetFontSize($size);
	  while($this->getStringWidth($line)<$w){
	  $size+=0.1;
	  $this->setFontSize($size);
	  }
	  $this->cell($w,$size/2.83,$line,0,1,"C");
       }
       $this->SetFontSize($fsize);
     }
     function GetFontSize(){
       return $this->FontSizePt;
     }
     function CheckMark($size=11){
       $currentfont = $this->GetCurrentFont();
       $this->SetFont('ZapfDingbats','',$size);
       $this->Cell(5,5,'4');
       $this->SetFont($currentfont['family'],$currentfont['style'],$currentfont['size']);
     }
    function CheckedBox($textpos="l", $txt=''){
	$currentfont = $this->GetCurrentFont();
       $x = $this->GetX();
       $this->SetFont('ZapfDingbats','',$currentfont['size']*1.5);
       $this->Cell($currentfont['size'],5,chr(113));
       $this->SetX($x+0.5);
       $this->CheckMark($currentfont['size']*0.9);
       $this->SetFont($currentfont['family'],$currentfont['style'],$currentfont['size']);
       $this->SetLeftMargin($x+10);
       $this->SetX($x+$currentfont['em']*2);
       $this->MultiCell(0,5,$txt);
       $this->SetLeftMargin($x);
       $this->SetX($x);
    }
    function CheckBoxes($textpos="L", $txt=[], $count = 1, $space = 5){
      $y = $this->GetY();
      for($i=0;$i<$count;$i++){
	if($txt[$i] !== NULL){
	  $this->CheckBox($textpos, $txt[$i]);
	}else{
	  $this->CheckBox();
	}
	$y += $space;
	$this->SetY($y);
      }
    }
    function Title($w,$text,$ln=0){
      // resizes text to fill width
      $y = $this->GetY();
      $x = $this->GetX();
      $size = 1;
      do{
	$size += 1;
	$this->SetFontSize($size);
      } while ($this->GetStringWidth($text) < $w);
      $this->Text($x,$y+$size*0.352778,$text);
      if($ln){$this->Ln($size*0.352778);}
      $this->setY($y+$size*0.352778);
    }

    function setFontWeight($wt){
      switch($wt){
	case 'bold':
	case 'b' : $this->SetFont('','b',''); break;
	case '' : $this->SetFont('','',''); break;
      }
    }
  function MultiCellBltArray($w, $h, $blt_array, $border=0, $align='L', $fill=false){
     // produces a number of bulleted multicells based on array
	  if (!is_array($blt_array))
	  {
	      die('MultiCellBltArray requires an array with the following keys: bullet,margin,text,indent,spacer');
	      exit;
	  }

	  //Save x
	  $bak_x = $this->x;

	  for ($i=0; $i<sizeof($blt_array['text']); $i++)
	  {
	      //Get bullet width including margin
	      $blt_width = $this->GetStringWidth($blt_array['bullet'] . $blt_array['margin'])+$this->cMargin*2;

	      // SetX
	      $this->SetX($bak_x);

	      //Output indent
	      if ($blt_array['indent'] > 0)
		  $this->Cell($blt_array['indent']);

	      //Output bullet
	      $this->Cell($blt_width,$h,$blt_array['bullet'] . $blt_array['margin'],0,'',$fill);

	      //Output text
	      $this->MultiCell($w-$blt_width,$h,$blt_array['text'][$i],$border,$align,$fill);

	      //Insert a spacer between items if not the last item
	      if ($i != sizeof($blt_array['text'])-1)
		  $this->Ln($blt_array['spacer']);

	      //Increment bullet if it's a number
	      if (is_numeric($blt_array['bullet']))
		  $blt_array['bullet']++;
	  }

	  //Restore x
	  $this->x = $bak_x;
    }
    // **************************** INDEX CREATION ************************
    // Program set to override refTitleSize and refPageSize
  var $RefActive=false;    //Flag indicating that the index is being processed
  var $ChangePage=false;   //Flag indicating that a page break has occurred
  var $Reference=array();  //Array containing the references
  var $col=0;              //Current column number
  var $NbCol;              //Total number of columns
  var $y0;                 //Top ordinate of columns
  public $refTitleSize=14;	 //Font size of INDEX
  public $refFontSize=12;	 //font size of index items
  public $refPageSize=270;    // cut off mm for page break;

  function setRefTitleSize($size){
    $this->refTitleSize = $size;
  }
  function setRefFontSize($size){
    $this->refFontSize = $size;
  }
  function setRefPageSize($size){
    $this->refPageSize = $size;
  }
  function mycheckpagebreak()
  {
      if ($this->RefActive) {
	  if($this->col<$this->NbCol-1)
	  {
	      //Go to the next column
	      $this->SetCol($this->col+1);
	      $this->SetY($this->y0);
	      //Stay on the page
	      return false;
	  }
	  else
	  {
	      //Go back to the first column
	      $this->SetCol(0);
	      $this->ChangePage=true;
	      //Page break
	      $this->AddPage();
	  }
      }
      else
      {
	  $this->AddPage();
      }
  }

  function Reference($txt)
  {
      $Present=0;
      $size=sizeof($this->Reference);

      //Search the reference in the array
      for ($i=0;$i<$size;$i++){
	  if ($this->Reference[$i]['t']==$txt){
	      $Present=1;
	      $this->Reference[$i]['p'].=','.$this->PageNo();
	  }
      }

      //If not found, add it
      if ($Present==0)
	  $this->Reference[]=array('t'=>$txt,'p'=>$this->PageNo());
  }

  function CreateReference($NbCol)
  {
      //Initialization
      $this->RefActive=true;
      $this->SetFontSize($this->refFontSize);

      //New page
      //if(!$GLOBALS['blankpage']){
	//$this->AddPage();
      //}
      $this->SetY(10);
      $fsize = $this->GetFontSize();
      $this->SetFont('','B',$this->refTitleSize);
      $this->Cell(0,10,"I N D E X",0,1,'C');
      $this->SetFont('','',$fsize);
      //Save the ordinate
      $this->y0=$this->GetY();
      $this->NbCol=$NbCol;
      $size=sizeof($this->Reference);
      $PageWidth=$this->w-$this->lMargin-$this->rMargin;

      for ($i=0;$i<$size;$i++){

	  //Handles page break and new position
	  if ($this->ChangePage) {
	      $this->ChangePage=false;
	      $this->y0=$this->GetY()-$this->FontSize-1;
	  }

	  //LibellLabel
	  $str=$this->Reference[$i]['t'];
	  $strsize=$this->GetStringWidth($str);
	  $this->Cell($strsize+2,$this->FontSize+2,ucfirst($str),0,0,'R');

	  //Dots
	  //Computes the widths
	  $ColWidth = ($PageWidth/$NbCol)-2;
	  $w=$ColWidth-$this->GetStringWidth($this->Reference[$i]['p'])-($strsize+4);
	  if ($w<15)
	      $w=15;
	  $nb=$w/$this->GetStringWidth('.');
	  $dots=str_repeat('.',$nb-2);
	  $this->Cell($w-2,$this->FontSize+2,$dots,0,0,'L');

	  //Page number
	  $Width=$ColWidth-$strsize-$w;
	  $this->Cell($Width,$this->FontSize+2,$this->Reference[$i]['p'],0,1,'R');

	  if($this->GetY() >= $this->refPageSize){
	    $this->mycheckpagebreak();
	  }
      }
      $this->RefActive=false;
  }
  function SetCol($col)
  {
      //Set position on a column
      $this->col=$col;
      $x=$this->rMargin+$col*($this->w-$this->rMargin-$this->rMargin)/$this->NbCol;
      $this->SetLeftMargin($x);
      $this->SetX($x);
  }
  // NUMBER OF LINES A MULTICELL WILL TAKE UP
  function NbLines($w,$txt)
  {
      //Computes the number of lines a MultiCell of width w will take
      $cw=&$this->CurrentFont['cw'];
      if($w==0)
	  $w=$this->w-$this->rMargin-$this->x;
      $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
      $s=str_replace("\r",'',$txt);
      $nb=strlen($s);
      if($nb>0 and $s[$nb-1]=="\n")
	  $nb--;
      $sep=-1;
      $i=0;
      $j=0;
      $l=0;
      $nl=1;
      while($i<$nb)
      {
	  $c=$s[$i];
	  if($c=="\n")
	  {
	      $i++;
	      $sep=-1;
	      $j=$i;
	      $l=0;
	      $nl++;
	      continue;
	  }
	  if($c==' ')
	      $sep=$i;
	  $l+=$cw[$c];
	  if($l>$wmax)
	  {
	      if($sep==-1)
	      {
		  if($i==$j)
		      $i++;
	      }
	      else
		  $i=$sep+1;
	      $sep=-1;
	      $j=$i;
	      $l=0;
	      $nl++;
	  }
	  else
	      $i++;
      }
      return $nl;
  }
  function GetFillColor(){
    return $this->FillColor;
  }
  function GetTextColor(){
    return $this->TextColor;
  }
  function ReverseColors(){
    $t = explode(' ',$this->GetTextColor());
    array_pop($t);
    $textcols = $t;
    $t = explode(' ',$this->GetFillColor());
    array_pop($t);
    $fillcols = $t;
    if(count($fillcols) === 1){
      $this->SetTextColor($fillcols[0]*255);
    }else{
      $this->SetTextColor($fillcols[0]*255,$fillcols[1]*255,$fillcols[2]*255);
    }
    if(count($textcols) === 1){
      $this->SetFillColor($textcols[0]*255);
    }else{
      $this->SetFillColor($textcols[0]*255,$textcols[1]*255,$textcols[2]*255);
    }
  }
  function GetCurrentFont(){
    $arr = [];
    $arr['family'] = $this->FontFamily;
    $arr['style'] = $this->FontStyle;
    $arr['size'] = $this->FontSizePt;
    $arr['em'] = $this->GetStringWidth("M");
    return $arr;
  }
  function Grid($width, $height, $hcount, $vcount, $darkline=0){
    $x = $this->GetX();
    $y = $this->GetY();
    $hspace = round($height/$hcount,1);
    $vspace = round($width/$vcount,1);
    $this->hline($x, $y, $width, $hspace, $hcount+1, 0.2, $darkline);
    $this->SetXY($x, $y);
    $this->vLine($x, $y, $height, $vspace, $vcount+1, 0.2, $darkline);
  }
  function LabelBox($x, $y, $w, $h, $txt, $line=0, $round=0){
    if($round > 0){
      $this->RoundedRect($x, $y, $w, $h, $round);
      $this->Text($x+$round,$y+5,$txt);
    }else{
      $this->Rect($x, $y, $w, $h);
    $this->Text($x+2, $y+5, $txt);
    }
    if($line > 0){
      $this->hLine($x, $y+6, $w);
    }
  }
  function Erased($w, $h, $txt){
    $x = $this->GetX();
    $y = $this->GetY();
    $ly = $y / 2;
    $ll = $this->GetStringWidth($txt);
    $this->Cell($w, $h, $txt);
    $this->hLine($x, $ly, $ll);
  }

  function subWrite($h, $txt, $link='', $subFontSize=12, $subOffset=0)
  {
      // resize font
      $subFontSizeold = $this->FontSizePt;
      $this->SetFontSize($subFontSize);

      // reposition y
      $subOffset = ((($subFontSize - $subFontSizeold) / $this->k) * 0.3) + ($subOffset / $this->k);
      $subX        = $this->x;
      $subY        = $this->y;
      $this->SetXY($subX, $subY - $subOffset);

      //Output text
      $this->Write($h, $txt, $link);

      // restore y position
      $subX        = $this->x;
      $subY        = $this->y;
      $this->SetXY($subX,  $subY + $subOffset);

      // restore font size
      $this->SetFontSize($subFontSizeold);
  }
  function Number($s="No"){
    $char1 = substr($s,0,1);
    $char2 = substr($s,-1);
    $this->Cell($this->GetStringWidth($char1),5,$char1);
    $this->subWrite(5, $char2.' ', '', $this->GetFontSize()*0.75, $this->GetFontSize()*0.33);
  }
  function OverUnder($s){
    $char1 = substr($s,0,1);
    $char2 = substr($s,-1);
    $x = $this->GetX();
    $this->subWrite(5, $char1.' ', '', $this->GetFontSize()*0.5, $this->GetFontSize()*0.50);
    $this->SetX($x);
    $this->subWrite(5, $char2.' ', '', $this->GetFontSize()*0.5, ($this->GetFontSize()*0.0)*-1);
  }
  function WordWrap(&$text, $maxwidth)
  {
    $text = trim($text);
    if ($text==='')
        return 0;
    $space = $this->GetStringWidth(' ');
    $lines = explode("\n", $text);
    $text = '';
    $count = 0;

    foreach ($lines as $line)
    {
        $words = preg_split('/ +/', $line);
        $width = 0;

        foreach ($words as $word)
        {
            $wordwidth = $this->GetStringWidth($word);
            if ($wordwidth > $maxwidth)
            {
                // Word is too long, we cut it
                for($i=0; $i<strlen($word); $i++)
                {
                    $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                    if($width + $wordwidth <= $maxwidth)
                    {
                        $width += $wordwidth;
                        $text .= substr($word, $i, 1);
                    }
                    else
                    {
                        $width = $wordwidth;
                        $text = rtrim($text)."\n".substr($word, $i, 1);
                        $count++;
                    }
                }
            }
            elseif($width + $wordwidth <= $maxwidth)
            {
                $width += $wordwidth + $space;
                $text .= $word.' ';
            }
            else
            {
                $width = $wordwidth + $space;
                $text = rtrim($text)."\n".$word.' ';
                $count++;
            }
        }
        $text = rtrim($text)."\n";
        $count++;
    }
    $text = rtrim($text);
    return $count;
  }
  function WrapText($txt, $width){
    WordWrap($txt, $width);
    $this->Write(5, $txt);
  }
} // end of class
?>
