<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-04
 * Time: 12:13 AM
 */


echo "<table id='".$gridId."' class='table table-striped table-bordered table-hover dataTable no-footer' cellspacing='0' width='100%'>";

//grid header
$head="<thead class='borderHead'><tr>";
foreach($gridHeader as $col){
    $head.="<th>".$col."</th>";
}
$head.="</tr></thead>";


echo $head;
echo "<tbody class='borderHead'>";

$actH=$actions[0];
$actJ=$actions[1];
$actA=$actions[2];

//print_r($data);

if(isset($data)) {
    foreach ($data as $row) {
        //print_r($row);

        echo "<tr>";
        foreach ($gridDataFeilds as $key) {
            echo "<td>";
            echo $row[$key];
            echo "</td>";
        }
        echo "<td>";
        for ($i = 0; $i < count($actH); $i++) {
            echo "<a href='javascript:getJson(\"" . base_url($actA[$i]) . '/' . $row[$gridDataFeilds[0]] . "\"," . $actJ[$i] . ",{})'>" . $actH[$i] . "</a> || ";
        }
        echo "</td>";

        echo "</tr>";

    }
}
echo "</tbody>";
echo "</table>";

?>