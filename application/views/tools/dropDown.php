<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-04
 * Time: 11:15 AM
 */
echo("<option value=''>Select ".$title."</option>");
//print_r($data);

if(isset($data)) {
    foreach ($data as $key=>$value) {
        echo "<option value='".$key."'>".$value."</option>";
    }
}
?>