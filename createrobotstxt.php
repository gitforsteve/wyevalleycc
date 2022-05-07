<?PHP
// *EXCLUDE*
// get directories
$dirs = glob('*', GLOB_ONLYDIR);
$files = glob('*.*');
$allowed = array("html","htm","php","robots.txt","sitemap.xml");
foreach($files as $file){
  $info = pathinfo($file);
  if(in_array($info['extension'],$allowed) OR in_array($info['basename'],$allowed)){
    $txt = file_get_contents($file);
    if(strpos($txt,"*EXCLUDE*") OR substr($info['extension'],0,3) === 'bak'){
      $excludes[] = $file;		
    }    
  }else{
    $excludes[] = $file;
  }
}

$robots = "User-agent: *\n";
for($i=0;$i<count($dirs);$i++){
  if(!in_array($dirs[$i],$allowed)){
    $robots .= "Disallow: /".$dirs[$i]."/\n";
  }
}
for($i=0;$i<count($excludes);$i++){
  $robots .= sprintf("Disallow: %s\n",$excludes[$i]);
}
$robots .= "Sitemap: https://wyevalleycc.co.uk/sitemap.xml";
if(is_file("robots.bak")){
  $suffix = 1;
  while(is_file('robots.bak'.$suffix)){
    $suffix += 1;
  }
  rename('robots.txt','robots.bak'.$suffix);
 }else{
  rename("robots.txt","robots.bak");
}
file_put_contents("robots.txt", $robots);
echo "robots.txt file created";
?>
