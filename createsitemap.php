<?PHP
class File {
  public $date;
  public $name;
  public $selected;
  function __construct($n) {
    $this->name = $n;
  }
}

$data = array();
clearstatcache();
$allowed = array("php","html");
$site = "https://wyevalleycc.co.uk/";
/*$smap = sprintf("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n  <url>\n    <loc>%s</loc>\n    <lastmod>%s</lastmod>\n    <changefreq>daily</changefreq>\n    <priority>0.9</priority>\n  </url>\n",$site,date('Y-m-d'));*/
$smap = <<<EOT
<?xml version="1.0" encoding="utf-8"?>
  <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  
EOT;

if(isset($_REQUEST['submit'])){
  if(isset($_REQUEST['chk100'])){
    $xml = simplexml_load_file("sitemap.xml");
    $files = [];
    foreach($xml->url as $val){
      $file = new File(basename($val->loc));
      $file->date = date("Y-m-d",filemtime(basename($val->loc)));
      $smap .= sprintf("  <url>\n    <loc>%s%s</loc>\n    <lastmod>%s</lastmod>\n    <changefreq>daily</changefreq>\n    <priority>0.9</priority>\n  </url>\n",$site,$file->name,$file->date);
    }
  }else{ 
    foreach($_REQUEST as $name=>$state){
      if($name !== "submit"){
        $name = implode(".",explode("_",$name));
        $date = date("Y-m-d",filemtime($name));
        $smap .= sprintf("  <url>\n    <loc>%s%s</loc>\n    <lastmod>%s</lastmod>\n    <changefreq>daily</changefreq>\n    <priority>0.9</priority>\n  </url>\n",$site,$name,$date);
      }
    }
  }
  $smap .= "</urlset>";

  if(is_file('sitemap.bak')){
    $suffix = 1;
    while(is_file('sitemap.bak'.$suffix)){
      $suffix += 1;
    }
    rename('sitemap.xml','sitemap.bak'.$suffix);
  }else{
    rename('sitemap.xml','sitemap.bak');
  }
  file_put_contents("sitemap.xml", $smap);
  echo "sitemap.xml created";
}else{
  $files = glob('*.*');
  foreach($files as $file){
    $info = pathinfo($file);
    if(in_array($info['extension'],$allowed)){
      $data[$file] = new File($file);
    }
  }
  echo "<form action='createsitemap.php' method='POST'>";
  $idcount = 1;
  foreach($data as $item){
    printf("<input type='checkbox' id='chk%s' name='%s' checked > <span style='cursor:pointer;' onclick=\"$('#chk%s').trigger('click');\">%s</span><br />",$idcount,$item->name,$idcount,$item->name);
    $idcount++;
  }
  printf("<input type='checkbox' id='chk100' name='chk100' > <span style='cursor:pointer;' >%s</span><br />","Base on last",100,"Base on last");
  echo "<input type='submit' name='submit' value='submit'></form>";
}
?>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script>
  $('#chk100').on("click",function(){
    $('input:checkbox').not(this).prop('checked',false);
  })
</script>