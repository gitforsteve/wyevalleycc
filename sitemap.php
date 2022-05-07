<?PHP
$title = "Site Map text links to pages";
$desc = "A textual site map containing links to our pages";
require 'classes.php';
class Map {
  public $page;
  public $title;
  function __construct($p,$t) {
    $this->page = $p;
    $this->title = $t;
  }
}
function getBetween($content,$start,$end){
    $r = explode($start, $content);
    if(strlen($r[0]) === 0 OR strlen($r[1] === 0)){
      return $content;
    }
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}
function mapsSort($a, $b){
  if($a->title === $b->title) return 0;
  return ($a->title<$b->title)?-1:1;
}
$maps = array();
$filename = "sitemap.xml";
$t = simplexml_load_file($filename);
foreach($t as $url){
  $urls[basename($url->loc)] = '';
}
array_shift($urls);
foreach($urls as $fname=>$t){
  if(file_exists($fname)){
    $txt = file_get_contents($fname);
    $t = getBetween($txt,'$title = "','";');
    $urls[$fname] = $t;
  }
}

foreach($urls as $url=>$t){
  $map = new Map($url,$t);
  $maps[] = $map;
}

usort($maps, "mapsSort");

require 'top.html';
?>
<div class="nine columns" id="content" style="border-radius:0 0 15px 0;">
    <h1>Site Map</h1>
    <p>Providing a list of text links to the pages on our site.</p>
    <ul>
    <?PHP
    foreach($maps as $map){
      if($map->title > ""){
	if($map->page !== 'electorsrights.php' OR $showrights){
	  printf("<li><a href='%s'>%s</a></li>",$map->page,$map->title);
	}
      }
    }
    ?>
    </ul>
    <br />
</div>
<?PHP
include 'bottom.html';
?>
<script type='text/javascript'>
  handleMenu($('#sitemap'));
</SCRIPT>