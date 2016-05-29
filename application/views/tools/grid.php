<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-04
 * Time: 12:13 AM
 */


echo "<table id='datatable' class='table table-striped table-bordered table-hover dataTable no-footer' cellspacing='0' width='100%'>";

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
            echo "<a class='btn btn-default btn-xs btn-circle' href='javascript:getJson(\"" . base_url($actA[$i]) . '/' . $row[$gridDataFeilds[0]] . "\"," . $actJ[$i] . ",{})' data-toggle='tooltip' data-placement='top' title='$actH[$i]'>";
            if ($actH[$i] == "view") {
                echo '<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> ';
            }
            else if($actH[$i] == "edit") {
                echo '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> ';
            }
            elseif($actH[$i] == "Report") {
                echo '<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> ';
            }
            echo "</a> ";
        }
        echo "</td>";

        echo "</tr>";

        /*
        echo "<tr>";
        echo "<td>";
        echo $row[0];
        echo "</td><td>";
        echo $row[1];
        echo "</td><td>";
        echo $row[3];
        echo "</td><td>";
        echo $row[4];
        echo "</td><td>";
        //echo "<a href='".base_url('index.php/customer/viewData').'/'.$row->customerId."'>View</a><a href='".base_url('index.php/home/deletestudent').'/'.$row->customerId."'>Delete</a>";
        echo "<a href='javascript:getJson(\"".base_url('index.php/customer/viewData').'/'.$row[0]."\",getCustomerView)'>View</a>";
        echo "</tr>";
        */
    }
}
echo "</tbody>";
echo "</table>";

?>