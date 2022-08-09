<?PHP
function describe($pw){
  $trans = array("A"=>"upper case a","B"=>"upper case b","C"=>"upper case c","D"=>"upper case d","E"=>"upper case e","F"=>"upper case f","G"=>"upper case g","H"=>"upper case h","I"=>"upper case i","J"=>"upper case j","K"=>"upper case k","L"=>"upper case l","M"=>"upper case m","N"=>"upper case n","O"=>"upper case o","P"=>"upper case p","Q"=>"upper case q","R"=>"upper case r","S"=>"upper case s","T"=>"upper case t","U"=>"upper case u","V"=>"upper case v","W"=>"upper case w","X"=>"upper case x","Y"=>"upper case y","Z"=>"upper case z","a"=>"lower case a","b"=>"lower case b","c"=>"lower case c","d"=>"lower case d","e"=>"lower case e","f"=>"lower case f","g"=>"lower case g","h"=>"lower case h","i"=>"lower case i","j"=>"lower case j","k"=>"lower case k","l"=>"lower case l","m"=>"lower case m","n"=>"lower case n","o"=>"lower case o","p"=>"lower case p","q"=>"lower case q","r"=>"lower case r","s"=>"lower case s","t"=>"lower case t","u"=>"lower case u","v"=>"lower case v","w"=>"lower case w","x"=>"lower case x","y"=>"lower case y","z"=>"lower case z","0"=>"zero","1"=>"one","2"=>"two","3"=>"three","4"=>"four","5"=>"five","6"=>"six","7"=>"seven","8"=>"eight","9"=>"nine","!"=>"exclamation mark","_"=>"underscore");
  $s = "";
  $chars = str_split($pw);
  foreach($chars as $char){
    $s .= $trans[$char] . ", ";
  }
  return $s;
}
echo describe("Apijmu_3233");
?>