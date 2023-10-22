<?PHP
echo "NEW CSV FILE";
?>
<html>
    <head>
        <link rel="stylesheet" html="skeleton.css">
    </head>
    <body>
        <div class="container">
            <div class="u-full-width">
                <form id="newfileform">
                    <div class="row">
                        <label for="fname">File name 
                            <input type="text" id="fname" name="fname" >
                        </label>
                   </div>
                   <div class="row">
                        <label for="fields">Fields (command separated) 
                            <textarea id="fields"  name="fields" class="u-full-width"></textarea>
                        </label>
                   </div>
                   <div class="row">
                        <label for="noofrows">No of rows to start
                            <input type="number" id="noofrows" name="noofrows" >
                   </div>
                </form>
            </div>
        </div>
        <button id="create">CREATE FILE</button> <button id="back">BACK TO CSVAPP</button>
    </body>
</html>
<script src="jquery-3.7.0.js"></script>
<script>
    $('#create').on("click",function(){
        $.ajax({
            url: "createfile.php",
            data: $('#newfileform').serializeArray()
        }).done(function(result){
            alert(result);
        })
    });
    $('#back').on("click",function(){
        location.replace("csvapp.php");
    })
</script>