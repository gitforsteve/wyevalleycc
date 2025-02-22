<?php
/*******************************************************************************
* FPDF                                                                         *
*                                                                              *
* Version: 1.6                                                                 *
* Date:    2008-08-03                                                          *
* Author:  Olivier PLATHEY                                                     *
* Contains: Rounded rectangles                                                 *
* Bulleted multicell                                                           *
* Rulers by Steve Evans  
* SetWeight by Steve Evans 
* Vertical and horizontal labels by Steve Evans  
* code39 barcode
* writetext (letter justification)   
* fitText (fit a string to a width by increasing text size
* Get Multicell height    
* SetFillColorS (use a string to set fille color
* SetTextColorS use a string to set text color    
* SetDrawColorS use a string to set draw color
* SpreadText space between characters in a cell  
* Hex2RGB convert color to rgb  
* Title resizes text to fill width
* CheckBox produces a checkbox with text to the right or left (default)                                        
*******************************************************************************/

define('FPDF_VERSION','1.6');

class SSFPDF
{
var $page;               //current page number
var $n;                  //current object number
var $offsets;            //array of object offsets
var $buffer;             //buffer holding in-memory PDF
var $pages;              //array containing pages
var $state;              //current document state
var $compress;           //compression flag
var $k;                  //scale factor (number of points in user unit)
var $DefOrientation;     //default orientation
var $CurOrientation;     //current orientation
var $PageFormats;        //available page formats
var $DefPageFormat;      //default page format
var $CurPageFormat;      //current page format
var $PageSizes;          //array storing non-default page sizes
var $wPt,$hPt;           //dimensions of current page in points
var $w,$h;               //dimensions of current page in user unit
var $lMargin;            //left margin
var $tMargin;            //top margin
var $rMargin;            //right margin
var $bMargin;            //page break margin
var $cMargin;            //cell margin
var $x,$y;               //current position in user unit
var $lasth;              //height of last printed cell
var $LineWidth;          //line width in user unit
var $CoreFonts;          //array of standard font names
var $fonts;              //array of used fonts
var $FontFiles;          //array of font files
var $diffs;              //array of encoding differences
var $FontFamily;         //current font family
var $FontStyle;          //current font style
var $underline;          //underlining flag
var $CurrentFont;        //current font info
var $FontSizePt;         //current font size in points
var $FontSize;           //current font size in user unit
var $DrawColor;          //commands for drawing color
var $FillColor;          //commands for filling color
var $TextColor;          //commands for text color
var $ColorFlag;          //indicates whether fill and text colors are different
var $ws;                 //word spacing
var $images;             //array of used images
var $PageLinks;          //array of links in pages
var $links;              //array of internal links
var $AutoPageBreak;      //automatic page breaking
var $PageBreakTrigger;   //threshold used to trigger page breaks
var $InHeader;           //flag set when processing header
var $InFooter;           //flag set when processing footer
var $ZoomMode;           //zoom display mode
var $LayoutMode;         //layout display mode
var $title;              //title
var $subject;            //subject
var $author;             //author
var $keywords;           //keywords
var $creator;            //creator
var $AliasNbPages;       //alias for total number of pages
var $PDFVersion;         //PDF version number
var $widths;
var $aligns;

/*******************************************************************************
*                                                                              *
*                               Public methods                                 *
*                                                                              *
*******************************************************************************/
function FPDF($orientation='P', $unit='mm', $format='A4')
{
	//Some checks
	$this->_dochecks();
	//Initialization of properties
	$this->page=0;
	$this->n=2;
	$this->buffer='';
	$this->pages=array();
	$this->PageSizes=array();
	$this->state=0;
	$this->fonts=array();
	$this->FontFiles=array();
	$this->diffs=array();
	$this->images=array();
	$this->links=array();
	$this->InHeader=false;
	$this->InFooter=false;
	$this->lasth=0;
	$this->FontFamily='';
	$this->FontStyle='';
	$this->FontSizePt=12;
	$this->underline=false;
	$this->DrawColor='0 G';
	$this->FillColor='0 g';
	$this->TextColor='0 g';
	$this->ColorFlag=false;
	$this->ws=0;
	//Standard fonts
	$this->CoreFonts=array('courier'=>'Courier', 'courierB'=>'Courier-Bold', 'courierI'=>'Courier-Oblique', 'courierBI'=>'Courier-BoldOblique',
		'helvetica'=>'Helvetica', 'helveticaB'=>'Helvetica-Bold', 'helveticaI'=>'Helvetica-Oblique', 'helveticaBI'=>'Helvetica-BoldOblique',
		'times'=>'Times-Roman', 'timesB'=>'Times-Bold', 'timesI'=>'Times-Italic', 'timesBI'=>'Times-BoldItalic',
		'symbol'=>'Symbol', 'zapfdingbats'=>'ZapfDingbats');
	//Scale factor
	if($unit=='pt')
		$this->k=1;
	elseif($unit=='mm')
		$this->k=72/25.4;
	elseif($unit=='cm')
		$this->k=72/2.54;
	elseif($unit=='in')
		$this->k=72;
	else
		$this->Error('Incorrect unit: '.$unit);
	//Page format
	$this->PageFormats=array('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a5'=>array(420.94,595.28),
		'letter'=>array(612,792), 'legal'=>array(612,1008));
	if(is_string($format))
		$format=$this->_getpageformat($format);
	$this->DefPageFormat=$format;
	$this->CurPageFormat=$format;
	//Page orientation
	$orientation=strtolower($orientation);
	if($orientation=='p' || $orientation=='portrait')
	{
		$this->DefOrientation='P';
		$this->w=$this->DefPageFormat[0];
		$this->h=$this->DefPageFormat[1];
	}
	elseif($orientation=='l' || $orientation=='landscape')
	{
		$this->DefOrientation='L';
		$this->w=$this->DefPageFormat[1];
		$this->h=$this->DefPageFormat[0];
	}
	else
		$this->Error('Incorrect orientation: '.$orientation);
	$this->CurOrientation=$this->DefOrientation;
	$this->wPt=$this->w*$this->k;
	$this->hPt=$this->h*$this->k;
	//Page margins (1 cm)
	$margin=28.35/$this->k;
	$this->SetMargins($margin,$margin);
	//Interior cell margin (1 mm)
	$this->cMargin=$margin/10;
	//Line width (0.2 mm)
	$this->LineWidth=.567/$this->k;
	//Automatic page break
	$this->SetAutoPageBreak(true,2*$margin);
	//Full width display mode
	$this->SetDisplayMode('fullwidth');
	//Enable compression
	$this->SetCompression(true);
	//Set default PDF version number
	$this->PDFVersion='1.3';
}

function SetMargins($left, $top, $right=null)
{
	//Set left, top and right margins
	$this->lMargin=$left;
	$this->tMargin=$top;
	if($right===null)
		$right=$left;
	$this->rMargin=$right;
}

function SetLeftMargin($margin)
{
	//Set left margin
	$this->lMargin=$margin;
	if($this->page>0 && $this->x<$margin)
		$this->x=$margin;
}

function SetTopMargin($margin)
{
	//Set top margin
	$this->tMargin=$margin;
}

function SetRightMargin($margin)
{
	//Set right margin
	$this->rMargin=$margin;
}

function SetAutoPageBreak($auto, $margin=0)
{
	//Set auto page break mode and triggering margin
	$this->AutoPageBreak=$auto;
	$this->bMargin=$margin;
	$this->PageBreakTrigger=$this->h-$margin;
}

function SetDisplayMode($zoom, $layout='continuous')
{
	//Set display mode in viewer
	if($zoom=='fullpage' || $zoom=='fullwidth' || $zoom=='real' || $zoom=='default' || !is_string($zoom))
		$this->ZoomMode=$zoom;
	else
		$this->Error('Incorrect zoom display mode: '.$zoom);
	if($layout=='single' || $layout=='continuous' || $layout=='two' || $layout=='default')
		$this->LayoutMode=$layout;
	else
		$this->Error('Incorrect layout display mode: '.$layout);
}

function SetCompression($compress)
{
	//Set page compression
	if(function_exists('gzcompress'))
		$this->compress=$compress;
	else
		$this->compress=false;
}

function SetTitle($title, $isUTF8=false)
{
	//Title of document
	if($isUTF8)
		$title=$this->_UTF8toUTF16($title);
	$this->title=$title;
}

function SetSubject($subject, $isUTF8=false)
{
	//Subject of document
	if($isUTF8)
		$subject=$this->_UTF8toUTF16($subject);
	$this->subject=$subject;
}

function SetAuthor($author, $isUTF8=false)
{
	//Author of document
	if($isUTF8)
		$author=$this->_UTF8toUTF16($author);
	$this->author=$author;
}

function SetKeywords($keywords, $isUTF8=false)
{
	//Keywords of document
	if($isUTF8)
		$keywords=$this->_UTF8toUTF16($keywords);
	$this->keywords=$keywords;
}

function SetCreator($creator, $isUTF8=false)
{
	//Creator of document
	if($isUTF8)
		$creator=$this->_UTF8toUTF16($creator);
	$this->creator=$creator;
}

function AliasNbPages($alias='{nb}')
{
	//Define an alias for total number of pages
	$this->AliasNbPages=$alias;
}

function Error($msg)
{
	//Fatal error
	die('<b>FPDF error:</b> '.$msg);
}

function Open()
{
	//Begin document
	$this->state=1;
}

function Close()
{
	//Terminate document
	if($this->state==3)
		return;
	if($this->page==0)
		$this->AddPage();
	//Page footer
	$this->InFooter=true;
	$this->Footer();
	$this->InFooter=false;
	//Close page
	$this->_endpage();
	//Close document
	$this->_enddoc();
}

function AddPage($orientation='', $format='')
{
	//Start a new page
	if($this->state==0)
		$this->Open();
	$family=$this->FontFamily;
	$style=$this->FontStyle.($this->underline ? 'U' : '');
	$size=$this->FontSizePt;
	$lw=$this->LineWidth;
	$dc=$this->DrawColor;
	$fc=$this->FillColor;
	$tc=$this->TextColor;
	$cf=$this->ColorFlag;
	if($this->page>0)
	{
		//Page footer
		$this->InFooter=true;
		$this->Footer();
		$this->InFooter=false;
		//Close page
		$this->_endpage();
	}
	//Start new page
	$this->_beginpage($orientation,$format);
	//Set line cap style to square
	$this->_out('2 J');
	//Set line width
	$this->LineWidth=$lw;
	$this->_out(sprintf('%.2F w',$lw*$this->k));
	//Set font
	if($family)
		$this->SetFont($family,$style,$size);
	//Set colors
	$this->DrawColor=$dc;
	if($dc!='0 G')
		$this->_out($dc);
	$this->FillColor=$fc;
	if($fc!='0 g')
		$this->_out($fc);
	$this->TextColor=$tc;
	$this->ColorFlag=$cf;
	//Page header
	$this->InHeader=true;
	$this->Header();
	$this->InHeader=false;
	//Restore line width
	if($this->LineWidth!=$lw)
	{
		$this->LineWidth=$lw;
		$this->_out(sprintf('%.2F w',$lw*$this->k));
	}
	//Restore font
	if($family)
		$this->SetFont($family,$style,$size);
	//Restore colors
	if($this->DrawColor!=$dc)
	{
		$this->DrawColor=$dc;
		$this->_out($dc);
	}
	if($this->FillColor!=$fc)
	{
		$this->FillColor=$fc;
		$this->_out($fc);
	}
	$this->TextColor=$tc;
	$this->ColorFlag=$cf;
}

function Header()
{
	//To be implemented in your own inherited class
}

function Footer()
{
	//To be implemented in your own inherited class
}

function PageNo()
{
	//Get current page number
	return $this->page;
}

function SetDrawColor($r, $g=null, $b=null)
{
	//Set color for all stroking operations
	if(($r==0 && $g==0 && $b==0) || $g===null)
		$this->DrawColor=sprintf('%.3F G',$r/255);
	else
		$this->DrawColor=sprintf('%.3F %.3F %.3F RG',$r/255,$g/255,$b/255);
	if($this->page>0)
		$this->_out($this->DrawColor);
}

function SetFillColor($r, $g=null, $b=null)
{
	//Set color for all filling operations
	if(($r==0 && $g==0 && $b==0) || $g===null)
		$this->FillColor=sprintf('%.3F g',$r/255);
	else
		$this->FillColor=sprintf('%.3F %.3F %.3F rg',$r/255,$g/255,$b/255);
	$this->ColorFlag=($this->FillColor!=$this->TextColor);
	if($this->page>0)
		$this->_out($this->FillColor);
}

function SetTextColor($r, $g=null, $b=null)
{
	//Set color for text
	if(($r==0 && $g==0 && $b==0) || $g===null)
		$this->TextColor=sprintf('%.3F g',$r/255);
	else
		$this->TextColor=sprintf('%.3F %.3F %.3F rg',$r/255,$g/255,$b/255);
	$this->ColorFlag=($this->FillColor!=$this->TextColor);
}

function GetStringWidth($s)
{
	//Get width of a string in the current font
	$s=(string)$s;
	$cw=&$this->CurrentFont['cw'];
	$w=0;
	$l=strlen($s);
	for($i=0;$i<$l;$i++)
		$w+=$cw[$s[$i]];
	return $w*$this->FontSize/1000;
}

function SetLineWidth($width)
{
	//Set line width
	$this->LineWidth=$width;
	if($this->page>0)
		$this->_out(sprintf('%.2F w',$width*$this->k));
}

function Line($x1, $y1, $x2, $y2)
{
	//Draw a line
	$this->_out(sprintf('%.2F %.2F m %.2F %.2F l S',$x1*$this->k,($this->h-$y1)*$this->k,$x2*$this->k,($this->h-$y2)*$this->k));
}

function Rect($x, $y, $w, $h, $style='')
{
	//Draw a rectangle
	if($style=='F')
		$op='f';
	elseif($style=='FD' || $style=='DF')
		$op='B';
	else
		$op='S';
	$this->_out(sprintf('%.2F %.2F %.2F %.2F re %s',$x*$this->k,($this->h-$y)*$this->k,$w*$this->k,-$h*$this->k,$op));
}

function AddFont($family, $style='', $file='')
{
	//Add a TrueType or Type1 font
	$family=strtolower($family);
	if($file=='')
		$file=str_replace(' ','',$family).strtolower($style).'.php';
	if($family=='arial')
		$family='helvetica';
	$style=strtoupper($style);
	if($style=='IB')
		$style='BI';
	$fontkey=$family.$style;
	if(isset($this->fonts[$fontkey]))
		return;
	include($this->_getfontpath().$file);
	if(!isset($name))
		$this->Error('Could not include font definition file');
	$i=count($this->fonts)+1;
	$this->fonts[$fontkey]=array('i'=>$i, 'type'=>$type, 'name'=>$name, 'desc'=>$desc, 'up'=>$up, 'ut'=>$ut, 'cw'=>$cw, 'enc'=>$enc, 'file'=>$file);
	if($diff)
	{
		//Search existing encodings
		$d=0;
		$nb=count($this->diffs);
		for($i=1;$i<=$nb;$i++)
		{
			if($this->diffs[$i]==$diff)
			{
				$d=$i;
				break;
			}
		}
		if($d==0)
		{
			$d=$nb+1;
			$this->diffs[$d]=$diff;
		}
		$this->fonts[$fontkey]['diff']=$d;
	}
	if($file)
	{
		if($type=='TrueType')
			$this->FontFiles[$file]=array('length1'=>$originalsize);
		else
			$this->FontFiles[$file]=array('length1'=>$size1, 'length2'=>$size2);
	}
}

function SetFont($family, $style='', $size=0)
{
	//Select a font; size given in points
	global $fpdf_charwidths;

	$family=strtolower($family);
	if($family=='')
		$family=$this->FontFamily;
	if($family=='arial')
		$family='helvetica';
	elseif($family=='symbol' || $family=='zapfdingbats')
		$style='';
	$style=strtoupper($style);
	if(strpos($style,'U')!==false)
	{
		$this->underline=true;
		$style=str_replace('U','',$style);
	}
	else
		$this->underline=false;
	if($style=='IB')
		$style='BI';
	if($size==0)
		$size=$this->FontSizePt;
	//Test if font is already selected
	if($this->FontFamily==$family && $this->FontStyle==$style && $this->FontSizePt==$size)
		return;
	//Test if used for the first time
	$fontkey=$family.$style;
	if(!isset($this->fonts[$fontkey]))
	{
		//Check if one of the standard fonts
		if(isset($this->CoreFonts[$fontkey]))
		{
			if(!isset($fpdf_charwidths[$fontkey]))
			{
				//Load metric file
				$file=$family;
				if($family=='times' || $family=='helvetica')
					$file.=strtolower($style);
				include($this->_getfontpath().$file.'.php');
				if(!isset($fpdf_charwidths[$fontkey]))
					$this->Error('Could not include font metric file');
			}
			$i=count($this->fonts)+1;
			$name=$this->CoreFonts[$fontkey];
			$cw=$fpdf_charwidths[$fontkey];
			$this->fonts[$fontkey]=array('i'=>$i, 'type'=>'core', 'name'=>$name, 'up'=>-100, 'ut'=>50, 'cw'=>$cw);
		}
		else
			$this->Error('Undefined font: '.$family.' '.$style);
	}
	//Select it
	$this->FontFamily=$family;
	$this->FontStyle=$style;
	$this->FontSizePt=$size;
	$this->FontSize=$size/$this->k;
	$this->CurrentFont=&$this->fonts[$fontkey];
	if($this->page>0)
		$this->_out(sprintf('BT /F%d %.2F Tf ET',$this->CurrentFont['i'],$this->FontSizePt));
}

function SetFontSize($size)
{
	//Set font size in points
	if($this->FontSizePt==$size)
		return;
	$this->FontSizePt=$size;
	$this->FontSize=$size/$this->k;
	if($this->page>0)
		$this->_out(sprintf('BT /F%d %.2F Tf ET',$this->CurrentFont['i'],$this->FontSizePt));
}

function AddLink()
{
	//Create a new internal link
	$n=count($this->links)+1;
	$this->links[$n]=array(0, 0);
	return $n;
}

function SetLink($link, $y=0, $page=-1)
{
	//Set destination of internal link
	if($y==-1)
		$y=$this->y;
	if($page==-1)
		$page=$this->page;
	$this->links[$link]=array($page, $y);
}

function Link($x, $y, $w, $h, $link)
{
	//Put a link on the page
	$this->PageLinks[$this->page][]=array($x*$this->k, $this->hPt-$y*$this->k, $w*$this->k, $h*$this->k, $link);
}

function Text($x, $y, $txt)
{
	//Output a string
	$s=sprintf('BT %.2F %.2F Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
	if($this->underline && $txt!='')
		$s.=' '.$this->_dounderline($x,$y,$txt);
	if($this->ColorFlag)
		$s='q '.$this->TextColor.' '.$s.' Q';
	$this->_out($s);
}

function AcceptPageBreak()
{
	//Accept automatic page break or not
	return $this->AutoPageBreak;
}

function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
{
	//Output a cell
	$k=$this->k;
	if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
	{
		//Automatic page break
		$x=$this->x;
		$ws=$this->ws;
		if($ws>0)
		{
			$this->ws=0;
			$this->_out('0 Tw');
		}
		$this->AddPage($this->CurOrientation,$this->CurPageFormat);
		$this->x=$x;
		if($ws>0)
		{
			$this->ws=$ws;
			$this->_out(sprintf('%.3F Tw',$ws*$k));
		}
	}
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$s='';
	if($fill || $border==1)
	{
		if($fill)
			$op=($border==1) ? 'B' : 'f';
		else
			$op='S';
		$s=sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
	}
	if(is_string($border))
	{
		$x=$this->x;
		$y=$this->y;
		if(strpos($border,'L')!==false)
			$s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
		if(strpos($border,'T')!==false)
			$s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
		if(strpos($border,'R')!==false)
			$s.=sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
		if(strpos($border,'B')!==false)
			$s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
	}
	if($txt!=='')
	{
		if($align=='R')
			$dx=$w-$this->cMargin-$this->GetStringWidth($txt);
		elseif($align=='C')
			$dx=($w-$this->GetStringWidth($txt))/2;
		else
			$dx=$this->cMargin;
		if($this->ColorFlag)
			$s.='q '.$this->TextColor.' ';
		$txt2=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
		$s.=sprintf('BT %.2F %.2F Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$txt2);
		if($this->underline)
			$s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
		if($this->ColorFlag)
			$s.=' Q';
		if($link)
			$this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$this->GetStringWidth($txt),$this->FontSize,$link);
	}
	if($s)
		$this->_out($s);
	$this->lasth=$h;
	if($ln>0)
	{
		//Go to next line
		$this->y+=$h;
		if($ln==1)
			$this->x=$this->lMargin;
	}
	else
		$this->x+=$w;
}

function MultiCell($w, $h, $txt, $border=0, $align='L', $fill=false)
{
	//Output text with automatic or explicit line breaks
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 && $s[$nb-1]=="\n")
		$nb--;
	$b=0;
	if($border)
	{
		if($border==1)
		{
			$border='LTRB';
			$b='LRT';
			$b2='LR';
		}
		else
		{
			$b2='';
			if(strpos($border,'L')!==false)
				$b2.='L';
			if(strpos($border,'R')!==false)
				$b2.='R';
			$b=(strpos($border,'T')!==false) ? $b2.'T' : $b2;
		}
	}
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$ns=0;
	$nl=1;
	while($i<$nb)
	{
		//Get next character
		$c=$s[$i];
		if($c=="\n")
		{
			//Explicit line break
			if($this->ws>0)
			{
				$this->ws=0;
				$this->_out('0 Tw');
			}
			$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$ns=0;
			$nl++;
			if($border && $nl==2)
				$b=$b2;
			continue;
		}
		if($c==' ')
		{
			$sep=$i;
			$ls=$l;
			$ns++;
		}
		$l+=$cw[$c];
		if($l>$wmax)
		{
			//Automatic line break
			if($sep==-1)
			{
				if($i==$j)
					$i++;
				if($this->ws>0)
				{
					$this->ws=0;
					$this->_out('0 Tw');
				}
				$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
			}
			else
			{
				if($align=='J')
				{
					$this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
					$this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
				}
				$this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
				$i=$sep+1;
			}
			$sep=-1;
			$j=$i;
			$l=0;
			$ns=0;
			$nl++;
			if($border && $nl==2)
				$b=$b2;
		}
		else
			$i++;
	}
	//Last chunk
	if($this->ws>0)
	{
		$this->ws=0;
		$this->_out('0 Tw');
	}
	if($border && strpos($border,'B')!==false)
		$b.='B';
	$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
	$this->x=$this->lMargin;
}

function Write($h, $txt, $link='')
{
	//Output text in flowing mode
	$cw=&$this->CurrentFont['cw'];
	$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		//Get next character
		$c=$s[$i];
		if($c=="\n")
		{
			//Explicit line break
			$this->Cell($w,$h,substr($s,$j,$i-$j),0,2,'',0,$link);
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			if($nl==1)
			{
				$this->x=$this->lMargin;
				$w=$this->w-$this->rMargin-$this->x;
				$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			}
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			//Automatic line break
			if($sep==-1)
			{
				if($this->x>$this->lMargin)
				{
					//Move to next line
					$this->x=$this->lMargin;
					$this->y+=$h;
					$w=$this->w-$this->rMargin-$this->x;
					$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
					$i++;
					$nl++;
					continue;
				}
				if($i==$j)
					$i++;
				$this->Cell($w,$h,substr($s,$j,$i-$j),0,2,'',0,$link);
			}
			else
			{
				$this->Cell($w,$h,substr($s,$j,$sep-$j),0,2,'',0,$link);
				$i=$sep+1;
			}
			$sep=-1;
			$j=$i;
			$l=0;
			if($nl==1)
			{
				$this->x=$this->lMargin;
				$w=$this->w-$this->rMargin-$this->x;
				$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			}
			$nl++;
		}
		else
			$i++;
	}
	//Last chunk
	if($i!=$j)
		$this->Cell($l/1000*$this->FontSize,$h,substr($s,$j),0,0,'',0,$link);
}

function Ln($h=null)
{
	//Line feed; default value is last cell height
	$this->x=$this->lMargin;
	if($h===null)
		$this->y+=$this->lasth;
	else
		$this->y+=$h;
}

function Image($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='')
{
	//Put an image on the page
	if(!isset($this->images[$file]))
	{
		//First use of this image, get info
		if($type=='')
		{
			$pos=strrpos($file,'.');
			if(!$pos)
				$this->Error('Image file has no extension and no type was specified: '.$file);
			$type=substr($file,$pos+1);
		}
		$type=strtolower($type);
		if($type=='jpeg')
			$type='jpg';
		$mtd='_parse'.$type;
		if(!method_exists($this,$mtd))
			$this->Error('Unsupported image type: '.$type);
		$info=$this->$mtd($file);
		$info['i']=count($this->images)+1;
		$this->images[$file]=$info;
	}
	else
		$info=$this->images[$file];
	//Automatic width and height calculation if needed
	if($w==0 && $h==0)
	{
		//Put image at 72 dpi
		$w=$info['w']/$this->k;
		$h=$info['h']/$this->k;
	}
	elseif($w==0)
		$w=$h*$info['w']/$info['h'];
	elseif($h==0)
		$h=$w*$info['h']/$info['w'];
	//Flowing mode
	if($y===null)
	{
		if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
		{
			//Automatic page break
			$x2=$this->x;
			$this->AddPage($this->CurOrientation,$this->CurPageFormat);
			$this->x=$x2;
		}
		$y=$this->y;
		$this->y+=$h;
	}
	if($x===null)
		$x=$this->x;
	$this->_out(sprintf('q %.2F 0 0 %.2F %.2F %.2F cm /I%d Do Q',$w*$this->k,$h*$this->k,$x*$this->k,($this->h-($y+$h))*$this->k,$info['i']));
	if($link)
		$this->Link($x,$y,$w,$h,$link);
}

function GetX()
{
	//Get x position
	return $this->x;
}

function SetX($x)
{
	//Set x position
	if($x>=0)
		$this->x=$x;
	else
		$this->x=$this->w+$x;
}

function GetY()
{
	//Get y position
	return $this->y;
}

function SetY($y)
{
	//Set y position and reset x
	$this->x=$this->lMargin;
	if($y>=0)
		$this->y=$y;
	else
		$this->y=$this->h+$y;
}

function SetXY($x, $y)
{
	//Set x and y positions
	$this->SetY($y);
	$this->SetX($x);
}

function Output($name='', $dest='')
{
	//Output PDF to some destination
	if($this->state<3)
		$this->Close();
	$dest=strtoupper($dest);
	if($dest=='')
	{
		if($name=='')
		{
			$name='doc.pdf';
			$dest='I';
		}
		else
			$dest='F';
	}
	switch($dest)
	{
		case 'I':
			//Send to standard output
			if(ob_get_length())
				$this->Error('Some data has already been output, can\'t send PDF file');
			if(php_sapi_name()!='cli')
			{
				//We send to a browser
				header('Content-Type: application/pdf');
				if(headers_sent())
					$this->Error('Some data has already been output, can\'t send PDF file');
				header('Content-Length: '.strlen($this->buffer));
				header('Content-Disposition: inline; filename="'.$name.'"');
				header('Cache-Control: private, max-age=0, must-revalidate');
				header('Pragma: public');
				ini_set('zlib.output_compression','0');
			}
			echo $this->buffer;
			break;
		case 'D':
			//Download file
			if(ob_get_length())
				$this->Error('Some data has already been output, can\'t send PDF file');
			header('Content-Type: application/x-download');
			if(headers_sent())
				$this->Error('Some data has already been output, can\'t send PDF file');
			header('Content-Length: '.strlen($this->buffer));
			header('Content-Disposition: attachment; filename="'.$name.'"');
			header('Cache-Control: private, max-age=0, must-revalidate');
			header('Pragma: public');
			ini_set('zlib.output_compression','0');
			echo $this->buffer;
			break;
		case 'F':
			//Save to local file
			$f=fopen($name,'wb');
			if(!$f)
				$this->Error('Unable to create output file: '.$name);
			fwrite($f,$this->buffer,strlen($this->buffer));
			fclose($f);
			break;
		case 'S':
			//Return as a string
			return $this->buffer;
		default:
			$this->Error('Incorrect output destination: '.$dest);
	}
	return '';
}

/*******************************************************************************
*                                                                              *
*                              Protected methods                               *
*                                                                              *
*******************************************************************************/
function _dochecks()
{
	//Check availability of %F
	if(sprintf('%.1F',1.0)!='1.0')
		$this->Error('This version of PHP is not supported');
	//Check mbstring overloading
	if(ini_get('mbstring.func_overload') & 2)
		$this->Error('mbstring overloading must be disabled');
	//Disable runtime magic quotes
	if(get_magic_quotes_runtime())
		@set_magic_quotes_runtime(0);
}

function _getpageformat($format)
{
	$format=strtolower($format);
	if(!isset($this->PageFormats[$format]))
		$this->Error('Unknown page format: '.$format);
	$a=$this->PageFormats[$format];
	return array($a[0]/$this->k, $a[1]/$this->k);
}

function _getfontpath()
{
	if(!defined('FPDF_FONTPATH') && is_dir(dirname(__FILE__).'/font'))
		define('FPDF_FONTPATH',dirname(__FILE__).'/font/');
	return defined('FPDF_FONTPATH') ? FPDF_FONTPATH : '';
}

function _beginpage($orientation, $format)
{
	$this->page++;
	$this->pages[$this->page]='';
	$this->state=2;
	$this->x=$this->lMargin;
	$this->y=$this->tMargin;
	$this->FontFamily='';
	//Check page size
	if($orientation=='')
		$orientation=$this->DefOrientation;
	else
		$orientation=strtoupper($orientation[0]);
	if($format=='')
		$format=$this->DefPageFormat;
	else
	{
		if(is_string($format))
			$format=$this->_getpageformat($format);
	}
	if($orientation!=$this->CurOrientation || $format[0]!=$this->CurPageFormat[0] || $format[1]!=$this->CurPageFormat[1])
	{
		//New size
		if($orientation=='P')
		{
			$this->w=$format[0];
			$this->h=$format[1];
		}
		else
		{
			$this->w=$format[1];
			$this->h=$format[0];
		}
		$this->wPt=$this->w*$this->k;
		$this->hPt=$this->h*$this->k;
		$this->PageBreakTrigger=$this->h-$this->bMargin;
		$this->CurOrientation=$orientation;
		$this->CurPageFormat=$format;
	}
	if($orientation!=$this->DefOrientation || $format[0]!=$this->DefPageFormat[0] || $format[1]!=$this->DefPageFormat[1])
		$this->PageSizes[$this->page]=array($this->wPt, $this->hPt);
}

function _endpage()
{
	$this->state=1;
}

function _escape($s)
{
	//Escape special characters in strings
	$s=str_replace('\\','\\\\',$s);
	$s=str_replace('(','\\(',$s);
	$s=str_replace(')','\\)',$s);
	$s=str_replace("\r",'\\r',$s);
	return $s;
}

function _textstring($s)
{
	//Format a text string
	return '('.$this->_escape($s).')';
}

function _UTF8toUTF16($s)
{
	//Convert UTF-8 to UTF-16BE with BOM
	$res="\xFE\xFF";
	$nb=strlen($s);
	$i=0;
	while($i<$nb)
	{
		$c1=ord($s[$i++]);
		if($c1>=224)
		{
			//3-byte character
			$c2=ord($s[$i++]);
			$c3=ord($s[$i++]);
			$res.=chr((($c1 & 0x0F)<<4) + (($c2 & 0x3C)>>2));
			$res.=chr((($c2 & 0x03)<<6) + ($c3 & 0x3F));
		}
		elseif($c1>=192)
		{
			//2-byte character
			$c2=ord($s[$i++]);
			$res.=chr(($c1 & 0x1C)>>2);
			$res.=chr((($c1 & 0x03)<<6) + ($c2 & 0x3F));
		}
		else
		{
			//Single-byte character
			$res.="\0".chr($c1);
		}
	}
	return $res;
}

function _dounderline($x, $y, $txt)
{
	//Underline text
	$up=$this->CurrentFont['up'];
	$ut=$this->CurrentFont['ut'];
	$w=$this->GetStringWidth($txt)+$this->ws*substr_count($txt,' ');
	return sprintf('%.2F %.2F %.2F %.2F re f',$x*$this->k,($this->h-($y-$up/1000*$this->FontSize))*$this->k,$w*$this->k,-$ut/1000*$this->FontSizePt);
}

function _parsejpg($file)
{
	//Extract info from a JPEG file
	$a=GetImageSize($file);
	if(!$a)
		$this->Error('Missing or incorrect image file: '.$file);
	if($a[2]!=2)
		$this->Error('Not a JPEG file: '.$file);
	if(!isset($a['channels']) || $a['channels']==3)
		$colspace='DeviceRGB';
	elseif($a['channels']==4)
		$colspace='DeviceCMYK';
	else
		$colspace='DeviceGray';
	$bpc=isset($a['bits']) ? $a['bits'] : 8;
	//Read whole file
	$f=fopen($file,'rb');
	$data='';
	while(!feof($f))
		$data.=fread($f,8192);
	fclose($f);
	return array('w'=>$a[0], 'h'=>$a[1], 'cs'=>$colspace, 'bpc'=>$bpc, 'f'=>'DCTDecode', 'data'=>$data);
}

function _parsepng($file)
{
	//Extract info from a PNG file
	$f=fopen($file,'rb');
	if(!$f)
		$this->Error('Can\'t open image file: '.$file);
	//Check signature
	if($this->_readstream($f,8)!=chr(137).'PNG'.chr(13).chr(10).chr(26).chr(10))
		$this->Error('Not a PNG file: '.$file);
	//Read header chunk
	$this->_readstream($f,4);
	if($this->_readstream($f,4)!='IHDR')
		$this->Error('Incorrect PNG file: '.$file);
	$w=$this->_readint($f);
	$h=$this->_readint($f);
	$bpc=ord($this->_readstream($f,1));
	if($bpc>8)
		$this->Error('16-bit depth not supported: '.$file);
	$ct=ord($this->_readstream($f,1));
	if($ct==0)
		$colspace='DeviceGray';
	elseif($ct==2)
		$colspace='DeviceRGB';
	elseif($ct==3)
		$colspace='Indexed';
	else
		$this->Error('Alpha channel not supported: '.$file);
	if(ord($this->_readstream($f,1))!=0)
		$this->Error('Unknown compression method: '.$file);
	if(ord($this->_readstream($f,1))!=0)
		$this->Error('Unknown filter method: '.$file);
	if(ord($this->_readstream($f,1))!=0)
		$this->Error('Interlacing not supported: '.$file);
	$this->_readstream($f,4);
	$parms='/DecodeParms <</Predictor 15 /Colors '.($ct==2 ? 3 : 1).' /BitsPerComponent '.$bpc.' /Columns '.$w.'>>';
	//Scan chunks looking for palette, transparency and image data
	$pal='';
	$trns='';
	$data='';
	do
	{
		$n=$this->_readint($f);
		$type=$this->_readstream($f,4);
		if($type=='PLTE')
		{
			//Read palette
			$pal=$this->_readstream($f,$n);
			$this->_readstream($f,4);
		}
		elseif($type=='tRNS')
		{
			//Read transparency info
			$t=$this->_readstream($f,$n);
			if($ct==0)
				$trns=array(ord(substr($t,1,1)));
			elseif($ct==2)
				$trns=array(ord(substr($t,1,1)), ord(substr($t,3,1)), ord(substr($t,5,1)));
			else
			{
				$pos=strpos($t,chr(0));
				if($pos!==false)
					$trns=array($pos);
			}
			$this->_readstream($f,4);
		}
		elseif($type=='IDAT')
		{
			//Read image data block
			$data.=$this->_readstream($f,$n);
			$this->_readstream($f,4);
		}
		elseif($type=='IEND')
			break;
		else
			$this->_readstream($f,$n+4);
	}
	while($n);
	if($colspace=='Indexed' && empty($pal))
		$this->Error('Missing palette in '.$file);
	fclose($f);
	return array('w'=>$w, 'h'=>$h, 'cs'=>$colspace, 'bpc'=>$bpc, 'f'=>'FlateDecode', 'parms'=>$parms, 'pal'=>$pal, 'trns'=>$trns, 'data'=>$data);
}

function _readstream($f, $n)
{
	//Read n bytes from stream
	$res='';
	while($n>0 && !feof($f))
	{
		$s=fread($f,$n);
		if($s===false)
			$this->Error('Error while reading stream');
		$n-=strlen($s);
		$res.=$s;
	}
	if($n>0)
		$this->Error('Unexpected end of stream');
	return $res;
}

function _readint($f)
{
	//Read a 4-byte integer from stream
	$a=unpack('Ni',$this->_readstream($f,4));
	return $a['i'];
}

function _parsegif($file)
{
	//Extract info from a GIF file (via PNG conversion)
	if(!function_exists('imagepng'))
		$this->Error('GD extension is required for GIF support');
	if(!function_exists('imagecreatefromgif'))
		$this->Error('GD has no GIF read support');
	$im=imagecreatefromgif($file);
	if(!$im)
		$this->Error('Missing or incorrect image file: '.$file);
	imageinterlace($im,0);
	$tmp=tempnam('.','gif');
	if(!$tmp)
		$this->Error('Unable to create a temporary file');
	if(!imagepng($im,$tmp))
		$this->Error('Error while saving to temporary file');
	imagedestroy($im);
	$info=$this->_parsepng($tmp);
	unlink($tmp);
	return $info;
}

function _newobj()
{
	//Begin a new object
	$this->n++;
	$this->offsets[$this->n]=strlen($this->buffer);
	$this->_out($this->n.' 0 obj');
}

function _putstream($s)
{
	$this->_out('stream');
	$this->_out($s);
	$this->_out('endstream');
}

function _out($s)
{
	//Add a line to the document
	if($this->state==2)
		$this->pages[$this->page].=$s."\n";
	else
		$this->buffer.=$s."\n";
}

function _putpages()
{
	$nb=$this->page;
	if(!empty($this->AliasNbPages))
	{
		//Replace number of pages
		for($n=1;$n<=$nb;$n++)
			$this->pages[$n]=str_replace($this->AliasNbPages,$nb,$this->pages[$n]);
	}
	if($this->DefOrientation=='P')
	{
		$wPt=$this->DefPageFormat[0]*$this->k;
		$hPt=$this->DefPageFormat[1]*$this->k;
	}
	else
	{
		$wPt=$this->DefPageFormat[1]*$this->k;
		$hPt=$this->DefPageFormat[0]*$this->k;
	}
	$filter=($this->compress) ? '/Filter /FlateDecode ' : '';
	for($n=1;$n<=$nb;$n++)
	{
		//Page
		$this->_newobj();
		$this->_out('<</Type /Page');
		$this->_out('/Parent 1 0 R');
		if(isset($this->PageSizes[$n]))
			$this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]',$this->PageSizes[$n][0],$this->PageSizes[$n][1]));
		$this->_out('/Resources 2 0 R');
		if(isset($this->PageLinks[$n]))
		{
			//Links
			$annots='/Annots [';
			foreach($this->PageLinks[$n] as $pl)
			{
				$rect=sprintf('%.2F %.2F %.2F %.2F',$pl[0],$pl[1],$pl[0]+$pl[2],$pl[1]-$pl[3]);
				$annots.='<</Type /Annot /Subtype /Link /Rect ['.$rect.'] /Border [0 0 0] ';
				if(is_string($pl[4]))
					$annots.='/A <</S /URI /URI '.$this->_textstring($pl[4]).'>>>>';
				else
				{
					$l=$this->links[$pl[4]];
					$h=isset($this->PageSizes[$l[0]]) ? $this->PageSizes[$l[0]][1] : $hPt;
					$annots.=sprintf('/Dest [%d 0 R /XYZ 0 %.2F null]>>',1+2*$l[0],$h-$l[1]*$this->k);
				}
			}
			$this->_out($annots.']');
		}
		$this->_out('/Contents '.($this->n+1).' 0 R>>');
		$this->_out('endobj');
		//Page content
		$p=($this->compress) ? gzcompress($this->pages[$n]) : $this->pages[$n];
		$this->_newobj();
		$this->_out('<<'.$filter.'/Length '.strlen($p).'>>');
		$this->_putstream($p);
		$this->_out('endobj');
	}
	//Pages root
	$this->offsets[1]=strlen($this->buffer);
	$this->_out('1 0 obj');
	$this->_out('<</Type /Pages');
	$kids='/Kids [';
	for($i=0;$i<$nb;$i++)
		$kids.=(3+2*$i).' 0 R ';
	$this->_out($kids.']');
	$this->_out('/Count '.$nb);
	$this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]',$wPt,$hPt));
	$this->_out('>>');
	$this->_out('endobj');
}

function _putfonts()
{
	$nf=$this->n;
	foreach($this->diffs as $diff)
	{
		//Encodings
		$this->_newobj();
		$this->_out('<</Type /Encoding /BaseEncoding /WinAnsiEncoding /Differences ['.$diff.']>>');
		$this->_out('endobj');
	}
	foreach($this->FontFiles as $file=>$info)
	{
		//Font file embedding
		$this->_newobj();
		$this->FontFiles[$file]['n']=$this->n;
		$font='';
		$f=fopen($this->_getfontpath().$file,'rb',1);
		if(!$f)
			$this->Error('Font file not found');
		while(!feof($f))
			$font.=fread($f,8192);
		fclose($f);
		$compressed=(substr($file,-2)=='.z');
		if(!$compressed && isset($info['length2']))
		{
			$header=(ord($font[0])==128);
			if($header)
			{
				//Strip first binary header
				$font=substr($font,6);
			}
			if($header && ord($font[$info['length1']])==128)
			{
				//Strip second binary header
				$font=substr($font,0,$info['length1']).substr($font,$info['length1']+6);
			}
		}
		$this->_out('<</Length '.strlen($font));
		if($compressed)
			$this->_out('/Filter /FlateDecode');
		$this->_out('/Length1 '.$info['length1']);
		if(isset($info['length2']))
			$this->_out('/Length2 '.$info['length2'].' /Length3 0');
		$this->_out('>>');
		$this->_putstream($font);
		$this->_out('endobj');
	}
	foreach($this->fonts as $k=>$font)
	{
		//Font objects
		$this->fonts[$k]['n']=$this->n+1;
		$type=$font['type'];
		$name=$font['name'];
		if($type=='core')
		{
			//Standard font
			$this->_newobj();
			$this->_out('<</Type /Font');
			$this->_out('/BaseFont /'.$name);
			$this->_out('/Subtype /Type1');
			if($name!='Symbol' && $name!='ZapfDingbats')
				$this->_out('/Encoding /WinAnsiEncoding');
			$this->_out('>>');
			$this->_out('endobj');
		}
		elseif($type=='Type1' || $type=='TrueType')
		{
			//Additional Type1 or TrueType font
			$this->_newobj();
			$this->_out('<</Type /Font');
			$this->_out('/BaseFont /'.$name);
			$this->_out('/Subtype /'.$type);
			$this->_out('/FirstChar 32 /LastChar 255');
			$this->_out('/Widths '.($this->n+1).' 0 R');
			$this->_out('/FontDescriptor '.($this->n+2).' 0 R');
			if($font['enc'])
			{
				if(isset($font['diff']))
					$this->_out('/Encoding '.($nf+$font['diff']).' 0 R');
				else
					$this->_out('/Encoding /WinAnsiEncoding');
			}
			$this->_out('>>');
			$this->_out('endobj');
			//Widths
			$this->_newobj();
			$cw=&$font['cw'];
			$s='[';
			for($i=32;$i<=255;$i++)
				$s.=$cw[chr($i)].' ';
			$this->_out($s.']');
			$this->_out('endobj');
			//Descriptor
			$this->_newobj();
			$s='<</Type /FontDescriptor /FontName /'.$name;
			foreach($font['desc'] as $k=>$v)
				$s.=' /'.$k.' '.$v;
			$file=$font['file'];
			if($file)
				$s.=' /FontFile'.($type=='Type1' ? '' : '2').' '.$this->FontFiles[$file]['n'].' 0 R';
			$this->_out($s.'>>');
			$this->_out('endobj');
		}
		else
		{
			//Allow for additional types
			$mtd='_put'.strtolower($type);
			if(!method_exists($this,$mtd))
				$this->Error('Unsupported font type: '.$type);
			$this->$mtd($font);
		}
	}
}

function _putimages()
{
	$filter=($this->compress) ? '/Filter /FlateDecode ' : '';
	reset($this->images);
	while(list($file,$info)=each($this->images))
	{
		$this->_newobj();
		$this->images[$file]['n']=$this->n;
		$this->_out('<</Type /XObject');
		$this->_out('/Subtype /Image');
		$this->_out('/Width '.$info['w']);
		$this->_out('/Height '.$info['h']);
		if($info['cs']=='Indexed')
			$this->_out('/ColorSpace [/Indexed /DeviceRGB '.(strlen($info['pal'])/3-1).' '.($this->n+1).' 0 R]');
		else
		{
			$this->_out('/ColorSpace /'.$info['cs']);
			if($info['cs']=='DeviceCMYK')
				$this->_out('/Decode [1 0 1 0 1 0 1 0]');
		}
		$this->_out('/BitsPerComponent '.$info['bpc']);
		if(isset($info['f']))
			$this->_out('/Filter /'.$info['f']);
		if(isset($info['parms']))
			$this->_out($info['parms']);
		if(isset($info['trns']) && is_array($info['trns']))
		{
			$trns='';
			for($i=0;$i<count($info['trns']);$i++)
				$trns.=$info['trns'][$i].' '.$info['trns'][$i].' ';
			$this->_out('/Mask ['.$trns.']');
		}
		$this->_out('/Length '.strlen($info['data']).'>>');
		$this->_putstream($info['data']);
		unset($this->images[$file]['data']);
		$this->_out('endobj');
		//Palette
		if($info['cs']=='Indexed')
		{
			$this->_newobj();
			$pal=($this->compress) ? gzcompress($info['pal']) : $info['pal'];
			$this->_out('<<'.$filter.'/Length '.strlen($pal).'>>');
			$this->_putstream($pal);
			$this->_out('endobj');
		}
	}
}

function _putxobjectdict()
{
	foreach($this->images as $image)
		$this->_out('/I'.$image['i'].' '.$image['n'].' 0 R');
}

function _putresourcedict()
{
	$this->_out('/ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
	$this->_out('/Font <<');
	foreach($this->fonts as $font)
		$this->_out('/F'.$font['i'].' '.$font['n'].' 0 R');
	$this->_out('>>');
	$this->_out('/XObject <<');
	$this->_putxobjectdict();
	$this->_out('>>');
}

function _putresources()
{
	$this->_putfonts();
	$this->_putimages();
	//Resource dictionary
	$this->offsets[2]=strlen($this->buffer);
	$this->_out('2 0 obj');
	$this->_out('<<');
	$this->_putresourcedict();
	$this->_out('>>');
	$this->_out('endobj');
}

function _putinfo()
{
	$this->_out('/Producer '.$this->_textstring('FPDF '.FPDF_VERSION));
	if(!empty($this->title))
		$this->_out('/Title '.$this->_textstring($this->title));
	if(!empty($this->subject))
		$this->_out('/Subject '.$this->_textstring($this->subject));
	if(!empty($this->author))
		$this->_out('/Author '.$this->_textstring($this->author));
	if(!empty($this->keywords))
		$this->_out('/Keywords '.$this->_textstring($this->keywords));
	if(!empty($this->creator))
		$this->_out('/Creator '.$this->_textstring($this->creator));
	$this->_out('/CreationDate '.$this->_textstring('D:'.@date('YmdHis')));
}

function _putcatalog()
{
	$this->_out('/Type /Catalog');
	$this->_out('/Pages 1 0 R');
	if($this->ZoomMode=='fullpage')
		$this->_out('/OpenAction [3 0 R /Fit]');
	elseif($this->ZoomMode=='fullwidth')
		$this->_out('/OpenAction [3 0 R /FitH null]');
	elseif($this->ZoomMode=='real')
		$this->_out('/OpenAction [3 0 R /XYZ null null 1]');
	elseif(!is_string($this->ZoomMode))
		$this->_out('/OpenAction [3 0 R /XYZ null null '.($this->ZoomMode/100).']');
	if($this->LayoutMode=='single')
		$this->_out('/PageLayout /SinglePage');
	elseif($this->LayoutMode=='continuous')
		$this->_out('/PageLayout /OneColumn');
	elseif($this->LayoutMode=='two')
		$this->_out('/PageLayout /TwoColumnLeft');
}

function _putheader()
{
	$this->_out('%PDF-'.$this->PDFVersion);
}

function _puttrailer()
{
	$this->_out('/Size '.($this->n+1));
	$this->_out('/Root '.$this->n.' 0 R');
	$this->_out('/Info '.($this->n-1).' 0 R');
}

function _enddoc()
{
	$this->_putheader();
	$this->_putpages();
	$this->_putresources();
	//Info
	$this->_newobj();
	$this->_out('<<');
	$this->_putinfo();
	$this->_out('>>');
	$this->_out('endobj');
	//Catalog
	$this->_newobj();
	$this->_out('<<');
	$this->_putcatalog();
	$this->_out('>>');
	$this->_out('endobj');
	//Cross-ref
	$o=strlen($this->buffer);
	$this->_out('xref');
	$this->_out('0 '.($this->n+1));
	$this->_out('0000000000 65535 f ');
	for($i=1;$i<=$this->n;$i++)
		$this->_out(sprintf('%010d 00000 n ',$this->offsets[$i]));
	//Trailer
	$this->_out('trailer');
	$this->_out('<<');
	$this->_puttrailer();
	$this->_out('>>');
	$this->_out('startxref');
	$this->_out($o);
	$this->_out('%%EOF');
	$this->state=3;
}
// XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
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
// ROUNDEDRECT
function RoundedRect($x, $y, $w, $h,$r, $style = ''){
// draws rounded corners on a rectangle
$k = $this->k;
$hp = $this->h;
if($style=='F')
$op='f';
elseif($style=='FD' or $style=='DF')
$op='B';
else
$op='S';
$MyArc = 4/3 * (sqrt(2) - 1);
$this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));
$xc = $x+$w-$r ;
$yc = $y+$r;
$this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));
$this->__Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
$xc = $x+$w-$r ;
$yc = $y+$h-$r;
$this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
$this->__Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
$xc = $x+$r ;
$yc = $y+$h-$r;
$this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
$this->__Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
$xc = $x+$r ;
$yc = $y+$r;
$this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
$this->__Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
$this->_out($op);
}
function __Arc($x1, $y1, $x2, $y2, $x3, $y3)
{
$h = $this->h;
$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
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
function SetDash($black=false, $white=false){
// sets the dash for dashed line
      if($black and $white){
          $s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
      }else{
          $s='[] 0 d';
      }
      $this->_out($s);
}

function DottedLine($x,$y,$w,$space=0,$count=1,$lw=0.2){
// produces a dotted line
  $this->SetLineWidth($lw);
  $this->SetDash(0.5,0.5);
  for($i=0;$i<$count;$i++){
    $this->Line($x,$y,$x+$w,$y);
    $y+=$space;
  }
  $this->SetLineWidth(0.2);
  $this->SetDash();
}

function vLine($x,$y,$h,$space=0,$count=1,$lw=0.2){
// produces any number of vertical line
  $this->SetLineWidth($lw);
  for($i=0;$i<$count;$i++){
    $this->Line($x, $y, $x, $y+$h);
    $x+=$space;
  }
  $this->SetLineWidth(0.2);
}

function hLine($x,$y,$w,$space=0,$count=1,$lw=0.2){
// produces any number of horizontal lines
  $this->SetLineWidth($lw);
  for($i=0;$i<$count;$i++){
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

function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5){

    $wide = $baseline;
    $narrow = $baseline / 3 ; 
    $gap = $wide;

    $barChar['0'] = 'nnnwwnwnn';
    $barChar['1'] = 'wnnwnnnnw';
    $barChar['2'] = 'nnwwnnnnw';
    $barChar['3'] = 'wnwwnnnnn';
    $barChar['4'] = 'nnnwwnnnw';
    $barChar['5'] = 'wnnwwnnnn';
    $barChar['6'] = 'nnwwwnnnn';
    $barChar['7'] = 'nnnwnnwnw';
    $barChar['8'] = 'wnnwnnwnn';
    $barChar['9'] = 'nnwwnnwnn';
    $barChar['A'] = 'wnnnnwnnw';
    $barChar['B'] = 'nnwnnwnnw';
    $barChar['C'] = 'wnwnnwnnn';
    $barChar['D'] = 'nnnnwwnnw';
    $barChar['E'] = 'wnnnwwnnn';
    $barChar['F'] = 'nnwnwwnnn';
    $barChar['G'] = 'nnnnnwwnw';
    $barChar['H'] = 'wnnnnwwnn';
    $barChar['I'] = 'nnwnnwwnn';
    $barChar['J'] = 'nnnnwwwnn';
    $barChar['K'] = 'wnnnnnnww';
    $barChar['L'] = 'nnwnnnnww';
    $barChar['M'] = 'wnwnnnnwn';
    $barChar['N'] = 'nnnnwnnww';
    $barChar['O'] = 'wnnnwnnwn'; 
    $barChar['P'] = 'nnwnwnnwn';
    $barChar['Q'] = 'nnnnnnwww';
    $barChar['R'] = 'wnnnnnwwn';
    $barChar['S'] = 'nnwnnnwwn';
    $barChar['T'] = 'nnnnwnwwn';
    $barChar['U'] = 'wwnnnnnnw';
    $barChar['V'] = 'nwwnnnnnw';
    $barChar['W'] = 'wwwnnnnnn';
    $barChar['X'] = 'nwnnwnnnw';
    $barChar['Y'] = 'wwnnwnnnn';
    $barChar['Z'] = 'nwwnwnnnn';
    $barChar['-'] = 'nwnnnnwnw';
    $barChar['.'] = 'wwnnnnwnn';
    $barChar[' '] = 'nwwnnnwnn';
    $barChar['*'] = 'nwnnwnwnn';
    $barChar['$'] = 'nwnwnwnnn';
    $barChar['/'] = 'nwnwnnnwn';
    $barChar['+'] = 'nwnnnwnwn';
    $barChar['%'] = 'nnnwnwnwn';

    $this->SetFont('Arial','',10);
    //$this->Text($xpos, $ypos + $height + 4, $code);
    $this->SetFillColor(0);

    $code = '*'.strtoupper($code).'*';
    for($i=0; $i<strlen($code); $i++){
        $char = $code[$i];
        if(!isset($barChar[$char])){
            $this->Error('Invalid character in barcode: '.$char);
        }
        $seq = $barChar[$char];
        for($bar=0; $bar<9; $bar++){
            if($seq[$bar] == 'n'){
                $lineWidth = $narrow;
            }else{
                $lineWidth = $wide;
            }
            if($bar % 2 == 0){
                $this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
            }
            $xpos += $lineWidth;
        }
        $xpos += $gap;
    }
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
		$font = $this->FontFamily;
		$fontsize = $this->FontSizePt;
		$fontstyle = $this->FontStyle;
     $this->SetFont('ZapfDingbats','',$size);
     $this->Cell(5,5,'4');
	 	$this->SetFont($font,$fontstyle,$fontsize);
   }
   function CheckedBox(){
     $x = $this->GetX();
     $y = $this->GetY();
     $fontsize = $this->GetFontSize();
     $h = $fontsize * 0.352778; // convert point size to mm
     $this->Rect($x,$y,5,5);
     $this->SetXY($x,$y);
     $this->CheckMark();
   }
  
   function CheckBox(){
     $this->SetDrawColor(0);
     $x = $this->GetX();
     $y = $this->GetY();
     $fontsize = $this->GetFontSize();
     $h = $fontsize * 0.352778; // convert point size to mm
     $this->Rect($x,$y,5,5);
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
/*************************/
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

}
//End of class


//Handle special IE contype request
if(isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT']=='contype')
{
	header('Content-Type: application/pdf');
	exit;
}

?>
