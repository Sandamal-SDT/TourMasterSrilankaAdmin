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
    $hotel=$controlData['hotelDetails'];
    if(sizeof($hotel)>0)
        $hotel=$hotel[0];
    $room=$controlData['roomDetails'];
    ?>

    <table class='table table-striped table-bordered table-hover no-footer' cellspacing='0' width='100%'>
        <thead>
        <tr>
            <td>Room Type</td>
            <td>Room Accommodation Type</td>
            <td></td>
        </tr>
        </thead>
        <?php foreach ($room as $row) {?>
            <tr>
                <td>
                    <?php echo ($row->room_Type)?>
                </td>
                <td>
                    <?php echo ($row->room_Accommodation_Type)?>
                </td>
                <td>
                    <?php
                    echo "<a class='btn btn-default btn-xs btn-circle' href='javascript:getJson(\"".base_url("index.php/room/getRoomDetailsById") ."/". $row->room_Id ."\",viewRoomDetails,{})' data-toggle='tooltip' data-placement='top' title='Edit'>";
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

