<?PHP
$title = "Search Minutes of Council meetings";
$desc = "Search the last 12 months of published minutes of our meetings";
require 'top.html';
print("<div class='nine columns' id='content' style='border-radius:0 0 15px 0;' >");
echo "<h1 style='font-size: 3vh;'>Searching minutes for '".$_POST['srch']."'</h1><br />"; 
function highlight_words( $text, $keywords ){
    $text = preg_replace( "/($keywords)/i", '<span style="background-color:yellow;">$1</span>', $text );
    return( $text );
}
    $dir = "./minutes/";
    $search = $_POST['srch'];
    $searchok = false;
    if($dh = opendir($dir)){
        while(($file = readdir($dh)) !== false){
            if(pathinfo($file,PATHINFO_EXTENSION) === "txt"){
                $realname = substr($file,0,1)==="a"?substr($file,1):$file;
                $dt = substr($realname,0,4)."-".substr($realname,4,2)."-".substr($realname,6,2);
                if(strtotime($dt) > strtotime('-360 days')){
                    $f = fopen("./minutes/".$file,"r");
                    $found = 0;
                    while(!feof($f)){
                        $s = fgets($f);
                        if( preg_match_all('/('.preg_quote($search,'/').')/i', $s, $matches)){
                            $found ++;
                            $searchok = true;
                            if($found === 1){echo "<strong>Minutes for ".date("jS F Y",strtotime($dt))."</strong><br />";}
                            echo highlight_words($s,$search)."<br />";
                        }
                    }
                    fclose($f);
                    if($found > 0){echo "<hr />";}
                }
            }
        }
        closedir($dh);
    }
    if(!$searchok){ echo "Sorry '".$search."' was not found<br><a href='minutes.php'>Back to Minutes</a>";}
?>
</div>
<script type="text/javascript">
  handleMenu($('#minutes'));
  //$('#current').html("Meeting Agenda");
</script>
<?PHP
require 'bottom.html';
?>