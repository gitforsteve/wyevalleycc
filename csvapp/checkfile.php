<?PHP
    if(file_exists($_REQUEST['name'])){
        echo "File exists";
    }else{
        echo "";
    }
?>