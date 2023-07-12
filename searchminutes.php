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
    $output.="<form action='searchminutes.php' method='POST'><label for='srch' style='font-weight:normal;'>Search minutes again <input type='text' id='srch' name='srch' autocomplete='off' placeholder='At least 4 characters' > <button class='shadow' id='srchbtn' disabled>SEARCH</button></label>
    </form>";
    $found = 0;
    //if($dh = opendir($dir)){
        $files = scandir($dir,SCANDIR_SORT_DESCENDING);
        foreach($files as $file){
            if(pathinfo($file,PATHINFO_EXTENSION) === "txt"){
                $realname = substr($file,0,1)==="a"?substr($file,1):$file;
                $dt = substr($realname,0,4)."-".substr($realname,4,2)."-".substr($realname,6,2);
                if(strtotime($dt) > strtotime('-2 years')){
                    $f = fopen("./minutes/".$file,"r");
                    while(!feof($f)){
                        $s = fgets($f);
                        if( preg_match_all('/('.preg_quote($search,'/').')/i', $s, $matches)){
                            $found ++;
                            $searchok = true;
                            $output.="<strong>Minutes for ".date("jS F Y",strtotime($dt))."</strong><br />".highlight_words($s,$search)."<br /><hr />";
                        }
                    }
                    fclose($f);
                }
            }
        }
        //closedir($dh);
    //}
    if($found < 1){ $output.="Sorry '".$search."' was not found<br><a href='minutes.php'>Back to Minutes</a>";}else{
        $output.=sprintf("<p>%s minutes contain your search</p>",$found);
        echo $output;
    }
?>
</div>
<script type="text/javascript">
  handleMenu($('#minutes'));
  $('#srchbtn').attr("disabled",true);
  $('#srch').on("keyup",function(){
    if($('#srch').val().length > 3){
      $('#srchbtn').attr("disabled",false);
    }else{
      $('#srchbtn').attr("disabled",true);
    }
  });

//$('#current').html("Meeting Agenda");
</script>
<?PHP
require 'bottom.html';
?>