<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2016-01-23
 * Time: 11:23 PM
 */?>
<?php
if( $this->session->userdata('isLoggedIn') ) {
} else {
redirect('/login');
}
?>
<?php

//echo $controlData['stat']['statFlag'];

if($controlData['stat']['statFlag']==1){
$enLocationList=$controlData['data']['enLocationList'];
?>

<h3 id="editPadHeading">Add Day</h3>

<div style="border: 2px solid rgb(184, 184, 195);">
    <form class="form-horizontal">
        <div class="form-group">
            <input type="hidden" id="IDi" value="-1">
        </div>

        <div class="form-group">
            <label for="tour_Start_Datei" class="col-sm-2 control-label">Start Day</label>
            <div class="col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="tour_Start_Datei" placeholder="Start Day">
                    <span class="input-group-addon">
                        <span aria-hidden="true"><i class="glyphicon glyphicon-calendar"></i></span>
                    </span>
                </div>
            </div>
            <script>$('#tour_Start_Datei').datepicker({
                    format:'yyyy-mm-dd'
                });
            </script>

            <label for="tour_End_Datei" class="col-sm-2 control-label">End Day</label>
            <div class="col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="tour_End_Datei" placeholder="End Date">
                    <span class="input-group-addon">
                        <span aria-hidden="true"><i class="glyphicon glyphicon-calendar"></i></span>
                    </span>
                </div>
            </div>
            <script>$('#tour_End_Datei').datepicker({
                    format:'yyyy-mm-dd'
                });
            </script>

        </div>

        <div class="form-group">
            <label for="tour_Location_Idi" class="col-sm-2 control-label">Room</label>
            <div>

                <div class="col-sm-3">
                    <select id="tour_Location_Idi" class="form-control" onchange="filterSelection('<?php echo base_url('index.php/tour/getHotelsForLocation') ?>',this.value,'tour_Hotel_Idi')">
                        <option value="">Select Location</option>
                        <?php
                        if(isset($enLocationList))
                            foreach($enLocationList as $loc){
                                echo "<option value='".$loc->hotel_Location."'>".$loc->hotel_Location."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select id="tour_Hotel_Idi" class="form-control" onchange="filterSelection('<?php echo base_url('index.php/tour/getRoomsForHotel') ?>',this.value,'tour_Room_Idi')">
                        <option value="">Select Hotel</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select id="tour_Room_Idi" class="form-control">
                        <option value="">Select Room</option>
                        <?php
                        if(isset($enRoomList))
                            foreach($enRoomList as $key=>$value){
                                echo "<option value='".$key."'>".$value."</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="tour_Number_Of_Roomsi" class="col-sm-2 control-label">Number of Rooms</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="tour_Number_Of_Roomsi" placeholder="No. of Rooms">
            </div>
            <div class="col-sm-offset-2 col-sm-10">
                <script>
                    var saveControls=['IDi','tour_Start_Datei','tour_End_Datei','tour_Room_Idi','tour_Number_Of_Roomsi'];
                </script>
                <button type="button" id="btnInsert" onclick="saveEData('<?php echo base_url('index.php/tour/saveData/1') ?>',getPostData(saveControls),'tour/loadAjaxGrid')" class="btn btn-primary">
                    <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Insert
                </button>
            </div>
        </div>

    </form>
</div>

<?php
}else{
    echo 'No Records Found</br>';

}
$this->load->view('tools/loader',$controlData['stat']);
?>