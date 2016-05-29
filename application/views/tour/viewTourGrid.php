<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2016-02-08
 * Time: 2:20 AM
 */
?>
<?php
if( $this->session->userdata('isLoggedIn') ) {
} else {
    redirect('/login');
}

//echo $controlData['stat']['statFlag'];

if($controlData['stat']['statFlag']==1){
    $tourEn=$controlData['tourEnDetails'];
    if(sizeof($tourEn)>0)
        $tourEn=$tourEn[0];
    $day=$controlData['tourDayDetails'];
    ?>

    <table class='table table-striped table-bordered table-hover no-footer' cellspacing='0' width='100%'>
        <thead>
        <tr>
            <td>Start Date</td>
            <td>End Date</td>
            <td>Room Description</td>
            <td></td>
        </tr>
        </thead>
        <?php foreach ($day as $row) {?>
            <tr>
                <td>
                    <?php echo ($row->tour_Start_Date)?>
                </td>
                <td>
                    <?php echo ($row->tour_End_Date)?>
                </td>
                <td>
                    <?php echo ($row->hotel_Name." -> ".$row->room_Type." (".$row->room_Accommodation_Type).") ".$row->tour_Number_Of_Rooms." Rooms"?>
                </td>
                <td>
                    <?php
                    echo "<a class='btn btn-default btn-xs btn-circle' href='javascript:getJson(\"".base_url("index.php/tour/getDayDetailsById") ."/". $row->tour_Id ."\",viewDayDetails,{})' data-toggle='tooltip' data-placement='top' title='Edit'>";
                    echo '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> ';
                    echo "</a> ";
                    ?>
                </td>
            </tr>
        <?php }?>
    </table>

    <?php $this->load->view('tools/loader',$controlData['stat']) ?>

    <?php
    }else{

        echo 'No Records Found</br>';
        $this->load->view('tools/loader',$controlData['stat']);
    }
?>

