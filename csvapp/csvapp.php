<?PHP
require "steveCSV.php";
if(file_exists('csvpath')){
    $path = file_get_contents('csvpath');
}else{
    $path = "";
}

if(!isset($_REQUEST['file']) OR $_REQUEST['file']===''){
    $csvs = glob($path."*.csv");
    for($i=0;$i<count($csvs);$i++){
        printf("<a href='index.php?file=%s'>%s</a><br />",$csvs[$i],$csvs[$i]);
    }
    print("<br /><button id='create' onclick='location.href =\"newfile.php\"'>CREATE NEW FILE</button>");
    exit();
}
$filename = $_REQUEST['file']; 

$d = new steveCSV($filename);
$data = $d->data;
$fields = $d->fields;
$colcount = count($fields);

$table = "<table id='mainTable' style='border:1px solid gray;border-collapse:collapse;'><thead><tr>";
$blankRow = "<tr>";
for($i=0;$i<$colcount;$i++){
    $table .= sprintf("<th style='border:1px solid gray;'>%s</th>",$fields[$i]);
    $blankRow .= "<td contenteditable style='border 1px solid gray;min-height:15px;'></td>";
}
$table .= "</tr></thead><tbody>";
$blankRow .= "</tr>";
$id = 0;
foreach($data as $rec){
    $id = $id + 1;
    $table .= "<tr id=".$id.">";
    for($i=0;$i<$colcount;$i++){
        $n = $fields[$i];
        if(is_numeric($rec->$n)){
            $style = "style='text-align:right;border:1px solid gray;'";
        }else{
            $style = "style='border:1px solid gray;'";
        }
        $table .= sprintf("<td contenteditable %s>%s</td>",$style,$rec->$n);
    }
    $table .= "</tr>";
}
$table .= "</tbody><tfoot><tr id='footer'>";
for($i=0;$i<$colcount;$i++){
    $table.="<td contenteditable style='border: 1px solid gray;min-height:15px;background-color:lightgray;'>";
}
$table.="</tr></tfoot></table>";
//print($table);
?>
<html>
    <head>
        <link rel="stylesheet" html="csvapp.css">
    </head>
    <body>
        <?
        print($table);
        ?>
        <button id="newfile">NEW FILE</button> <button id="save">DISPLAY</button> <button id="addrow">ADD ROW</button> <button id="delrow">DELETE ROW</button> <button id="total">TOTALS</button>
    </body>
</html>
<script src="jquery-3.7.0.js"></script>
<script>
    var output = "";
    var currentID = 0;
    var rowIndex = -1;
    $('#mainTable').on("click",'td',function(e){
        rowIndex = $(this).closest('tr').index();
        console.log(rowIndex);
        $('#mainTable > tbody > tr').each(function(){
            $(this).addClass('active');
        });
        currentID = $(this).parent("tr").attr('id');
    });
    $('body').on("click",'#newfile',function(){
        location.href = "newfile.php";
    })
    $('body').on("click","#total",function(){
        $('#mainTable > thead th').each(function(i){
            var total = 0;
            $('#mainTable tr').not('thead tr, tfoot tr').each(function(){
                var value = parseFloat($('td', this).eq(i).text());
                if(!isNaN(value)){
                    total += value;
                }
            })
            if(total !== 0){
                $('#mainTable tfoot td').eq(i).text(total.toFixed(2));
            }else($('#mainTable tfoot td').eq(i).text(""));   
        //console.log(totals);
        })
    })
    $('body').on("click","th",function(){
        var title = $(this).text();;
        var ok = confirm("WARNING! CANNOT BE UNDONE\nDelete selected column headed "+title+". Are you sure");
        if(ok){
            var iIndex = $(this).closest("th").prevAll("th").length;
            $(this).parents("#mainTable").find("tr").each(function() {
                $(this).find("td:eq(" + iIndex + ")").remove();
                $(this).find("th:eq(" + iIndex + ")").remove();
            });
        }
    });
    $('#addrow').on("click",function(){
        var lastID = $('#mainTable tr:last').prev().attr('id');
        var s="<tr>";
        if(lastID !== 'footer'){
            for(i=0;i<<?=$colcount?>;i++){
                s += "<td contenteditable style='border:1px solid gray;min-height:15px;'></td>";
            }
            s += "</tr>";
            $('#mainTable tbody tr').eq(rowIndex).after(s);
            id = 0;
            $('#mainTable > tbody tr').each(function(){
                id++;
                $(this).attr('id',id);
            });
        }
    })
    $('#delrow').on("click",function(){
        if(currentID === "footer"){
            alert("Footer row may not be removed");
        }else{
            ok = confirm("WARNING! CANNOT BE UNDONE\nDelete row ID "+currentID+" are you sure?");
            if(ok){
                $('#'+currentID).remove();
            }
        }
    })
    $('#save').on("click",function(){
        $('#mainTable > thead tr').each(function(){
            $(this).find('th').each(function(){
                if($(this).text() > ''){
                    output += $(this).text() + ','
                }
           })
            output = output.slice(0,-1) + "\n";
        })
        $('#mainTable > tbody tr').each(function(){
            $(this).find('td').each(function(){
                output += $(this).text() + ','
            });
            output = output.slice(0,-1) + "\n";
        });
        $('#mainTable > tfoot tr').each(function(){
            var footoutput = "";
            $(this).find('td').each(function(){
                if($(this).text()){
                    output += $(this).text() + ',';
                }
            });
            output = output.slice(0,-1) + "\n";
            //console.log(output);
        });
        $('body').on("click",'#writefile',function(){
            name = $('body > #savefile').val();
            text = $('body > #output').val();
            $.ajax({
                url: 'checkfile.php',
                type: 'POST',
                data: {
                    name: name
                }
            }).done(function(result){
                if(result !== ""){
                    ok = confirm("file exists - overwrite");
                }else{
                    ok = true;
                }
                if(ok){ 
                    $.ajax({
                        url: 'writefile.php',
                        type: 'POST',
                        data: {
                            name: name,
                            text: text
                        }
                    }).done(function(result){
                        alert(result);
                    });
                }
            });
        });
        $('body').append("<textarea id='output' class='selected' style='width:100%;height:300px;'>"+output+"</textarea><br /><button id='newfile'>NEW FILE</button> Save to <input type='text' id='savefile' value='<?=$filename?>'><button id='writefile'>SAVE TO FILE</button>");
        $('body').animate({scrollTop: '+=300px'}, 800);
    });
</script>