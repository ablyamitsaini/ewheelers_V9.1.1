<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<?php
foreach($options  as $key=>$value){
    
    echo "<option value={$key}> ".$value. "</option>";
    
}


?>