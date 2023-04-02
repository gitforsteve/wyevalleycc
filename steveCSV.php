<?PHP
/**************************************************
 Construct object with the name of a csv file which should have the field names as the first row
 Sorting: set the sortfield property and call sort
 Find in a field: call find with the name of the field and the text to be found
 Search in all fields: cal;l search with the text to be found
 Always returns an array
***************************************************/
class steveCSV {
    public $file;
    public $fields;
    public $data;
    public $sortfield;
    function __construct($file){
        $this->file = $file;
        $f = fopen($this->file,'r');
        $this->fields = fgetcsv($f);
        $this->data = [];
        while($row = fgetcsv($f)){
            $obj = new stdClass();
            for($i=0;$i<count($this->fields);$i++){
                $obj->{$this->fields[$i]} = $row[$i];
            }
            $this->data[] = $obj;
        }
    }
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
    function dosort($a,$b){
        return $a->{$this->sortfield} <=> $b->{$this->sortfield};
    }
    function sort(){
        usort($this->data,array($this,'dosort'));
    }
    function find($field,$text){
        $found = [];
        foreach($this->data as $item){
            if($this->str_contains(strtoupper($item->$field),strtoupper($text))){
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
            if($this->str_contains(strtoupper($srchstring),strtoupper($text))){
                $found[] = $item;
            }
        }
        return $found;
    }
}
?>