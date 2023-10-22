<?PHP
    $filename = $_POST['name'];
    $text = $_POST['text'];
    if(file_put_contents($filename,$text)){
        echo "Saved";
    }else{
        echo "Could not save";
    }
?>