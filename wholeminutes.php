<?PHP
function highlight_words( $text, $keywords ){
    $text = preg_replace( "/($keywords)/i", '<span style="background-color:yellow;">$1</span>', $text );
    return( $text );
}
$search = "hayward";
if($dh = opendir("./minutes/")){
    while(($file = readdir($dh)) !== false){
        if(pathinfo($file,PATHINFO_EXTENSION) === "txt"){
            $realname = substr($file,0,1)==="a"?substr($file,1):$file;
            $dt = substr($realname,0,4)."-".substr($realname,4,2)."-".substr($realname,6,2);
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
        }
    }
}
?>