<?PHP
/*****************************************************
 * STEVECSV IS CREATED BY STEVE EVANS AND IS COPYRIGHT
 * (C) 2023, LICENCED ON THIS SYSTEM AND APPLICATION
 * ONLY
 Construct object with the name of a csv file which should have the field names as the first row
 If the first row does not contain field name these can be added as a comma separated string as a second parameter.
 Display: display() will show the whole data in a table. If only selected fields are to be shown these should be entered as a string with field names spearated as a parameter.
 Sorting: call sort() with the field name as the parameter. An additional parameter 'desc' will sort descending
 Find in a field: call find with the name of the field and the text to be found
 Search in all fields: call search with the text to be found
 Exact match: call match with field name and text to return the first match
 Total: get the total for any field. Call total with the field name. The decimal count may also be stated as a second parameter
 Average: get the average for any field. Call average with the field name. The decimal count may also be stated as a second parameter
 Valueaverage: get the average of any field as in above but average is calculated only on actual values.
 Greater than: call gt with the field and value (handles numeric and string)
 Less than: call lt with the field and value (handles numeric and string)
 Between: call between with the field and two values (handle numeric and string)
 Always returns an array except in total and average if the field is non numeric
 Unique: finds unique values for a field returning an array of objects Parms: field name optional field for total
 Schema: display the details for the object. Call schema()
 Copy: creates a clone of the object and returns it.
 subSets : gathers objects based on the field given

 display: displays the data in a table
***************************************************/
if(!function_exists('str_contains')){
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}
class Obj {
    public function __set($item, $v)
    {
        $this->$item = $v;
    }
}
class steveCSV {
    public $file;
    public $fields;
    public $data;
    public $total;
    public $version = "Release 1.0";
    function __construct($file,$fields = '',$msg=true){
        $this->file = $file;
        $f = fopen($this->file,'r');
        if(!$f){
            if($msg){
                exit("The data file '".$file."' could not be opened");
            }
        }
        if($fields > ''){
            $this->fields = explode(',',$fields);
          }else{
            $this->fields = fgetcsv($f);
        }
        $this->data = [];
        while($row = fgetcsv($f)){
            $obj = new stdClass();
            for($i=0;$i<count($this->fields);$i++){
                $obj->{$this->fields[$i]} = @$row[$i];
            }
            $this->data[] = $obj;
        }
    }
    public function __set($property,$value){
        $this->property = $value;
    }
    function about(){
        printf("steveCSV was created by Steve Evans<br />The version you are using is %s<br />This class reads a csv file and allows data manipulation:<br />Call the class with the name of the csv file as a parameter<br />",$this->version);
    }
    // lt = less than
    function lt($field,$string){
        $found = [];
        foreach($this->data as $dta){
            if(is_numeric($dta->$field)){
                if(floatval($dta->$field) < floatval($string)){
                    $found[] = $dta;
                }                
            }else{
                if($dta->$field < $string){
                    $found[] = $dta;
                }
            }
        }
        return(count($found)>0?$found:NULL);
    }
    // gt = greater than
    function gt($field,$string){
        $found = [];
        foreach($this->data as $dta){
            if(is_numeric($dta->$field)){
                if(floatval($dta->$field) > floatval($string)){
                    $found[] = $dta;
                }                
            }else{
                if($dta->$field > $string){
                    $found[] = $dta;
                }
            }
        }
        return(count($found)>0?$found:NULL);
    }
    // between
    function between($field, $string1, $string2){
        $found = [];
        foreach($this->data as $dta){
            if(is_numeric($dta->$field)){
                if((floatval($dta->$field) >= floatval($string1)) && (floatval($dta->$field) <= floatval($string2))){
                    $found[] = $dta;
                }
            }else{
                if(($dta->$field >= $string1) && ($dta->$field <= $string2)){
                    $found[] = $dta;
                }
            }
        }
        return(count($found)>0?$found:NULL);
    }
    function schema(){
        $fieldstring = implode(", ",$this->fields);
        $fieldcount = count($this->fields);
        $reccount = count($this->data);
        $s = <<<txt
            File: {$this->file}<br />
            No of fields: {$fieldcount}<br />
            Fields: {$fieldstring}<br />
            No of records: {$reccount}
        txt;
        echo $s;
    }
    function display($reqd = 'all'){
        $str = "<table border=true style='border-collapse:collapse;width:80%;'><tr>";
        $fieldnames = $this->fields;
        for($i=0;$i<count($fieldnames);$i++){
            if($reqd === 'all' OR str_contains($reqd,$fieldnames[$i])){
                $str .= "<th style='padding-left:5px;padding-right:5px;'>".$fieldnames[$i]."</th>";
            }
        }
        $str .= "</tr>";
		foreach($this->data as $dta){
            $str .= "<tr>";
			for($i=0;$i<count($fieldnames);$i++){
                if($reqd === 'all' OR str_contains($reqd,$fieldnames[$i])){
                    if(is_numeric($dta->{$this->fields[$i]})){
                        $str.="<td style='text-align:right;padding-left:5px;padding-right:5px;'>";
                    }else{
                        $str.="<td style='padding-left:5px;padding-right:5px;'>";
                    }
				    $str .= $dta->{$this->fields[$i]}."</td>";
                }
			}
			$str .= "</tr>";
		}
        $str .= "</table>";
        echo $str;
    }
    function sort($field,$dir='asc'){
        usort($this->data, function($a, $b) use ($field,$dir) {
            if(is_numeric($a->$field) && is_numeric($b->$field)){
                if($dir==='desc'){
                    return floatval($b->$field) <=> floatval($a->$field);
                }else{
                    return floatval($a->$field) <=> floatval($b->$field);
                }
            }else{
                if($dir==='desc'){
                    return $b->$field <=> $a->field;
                }else{
        	        return $a->$field <=> $b->$field;
                }
            }
        });
    }
    function copy(){
        $obj = clone $this;
        return $obj;
    }
    function pop(){
        $found = null;
        var_dump($this->data[0]);
    }
    function find($field,$text){
        $found = [];
        foreach($this->data as $item){
            if(str_contains(strtoupper($item->$field),strtoupper($text))){
                $found[] = $item;
            }
        }
        return count($found) > 0 ? $found : "Not found";
    }
    function search($text){
        $found = [];
        foreach($this->data as $item){
            $srchstring = "";
            for($i=0;$i<count($this->fields);$i++){
                $srchstring.=$item->{$this->fields[$i]};
            }
            if(strpos(strtoupper($srchstring),strtoupper(($text)))!==false){
                $found[] = $item;
            }
        }
        return count($found) > 0 ? $found : "Not found";
    }
    function match($field,$text){
        foreach($this->data as $item){
            if($item->$field === $text){
                return $item;
            }
        }
        return NULL;
    }
    function unique($field,$totfield=""){
        $obj = new Obj();
        // build the unique array
        foreach($this->data as $item){
            $obj->{$item->$field} += $item->$totfield;
        }
        return $obj;
    }
    function total($field, $decimals = NULL, $prefix = ""){
        $total = 0;
        foreach($this->data as $item) {
            if(is_numeric($item->$field)){
                $total += $item->$field;
            }
        }
        if(!is_numeric($total)){
            return "Not numeric";
        }
        if(is_null($decimals)){
            return $prefix.$total;
        }else{
            return $prefix.number_format($total,$decimals,'.',',');
        }
    }
    function valueaverage($field,$decimals = NULL,$prefix=''){
        $count = $total = 0;
        foreach($this->data as $item){
            if(is_numeric($item->$field)){
                $count++;
                $total+=$item->$field;
            }
        }
        if($count > 0){
            if(is_null($decimals)){
                return($prefix.$total / $count);
            }else
                return $prefix.number_format($total/$count,$decimals,'.',',');
        }
    }
    function average($field,$decimals = NULL,$prefix=''){
        if(!is_numeric($this->total($field))){
            return "Not numeric";
        }
        $avg = $this->total($field) / count($this->data);
        if(is_null($decimals)){
            return $avg;
        }else{
            return $prefix.number_format($avg,$decimals,'.',',');
        }
    }
    function subSets($field,$like=null){
        $ar = $t = [];
        $thiskey = "";
        if(!is_null($like)){
            foreach($this->data as $item){
               if(strpos($item->$field,$like) !== false){
                    if(!array_key_exists($item->$field,$t)){
                        $t[$item->$field] = $item->$field;
                        $thiskey = $item->$field;
                    }
                    $ar[$thiskey] = $item;
                }
            }
        }else{
            foreach($this->data as $item){
                if(!array_key_exists($item->$field,$t)){
                    $t[$item->$field] = $item->$field;
                    $thiskey = $item->$field;
                }
                $ar[$thiskey] = $item;
            }
        }
        return $ar;
    }
}
?>