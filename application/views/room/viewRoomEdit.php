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
    $room=$controlData['data'][0];
    $seasonList = $controlData['seasonList'];
    //print_r($seasonList);
    ?>

<div class="alert alert-success alert-dismissible" style="padding-top: 0px !important;padding-right: 15px !important;" role="alert">
    <div>
        <button type="button" class="close" style="right: -5px !important;top: -15px !important;font-size: 30px;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h3 id="editPadHeading">Edit Room</h3>
        <div style="border: 2px solid rgb(184, 184, 195);">
            <form class="form-horizontal">
                <div class="form-group">
                    <input type="hidden" id="ID" value="<?php echo $room->room_Id?>">
                </div>

                <div class="form-group">
                    <label for="room_Type" class="col-sm-2 control-label">Room Type</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="room_Type">
                            <option value="">Select One</option>
                            <option value="Single">Single</option>
                            <option value="Double">Double</option>
                            <option value="Triple">Triple</option>
                            <option value="Family">Family</option>
                            <option value="Special">Special</option>
                        </select>
                    </div>
                    <script>document.getElementById('room_Type').value='<?php echo $room->room_Type ?>';</script>

                    <label for="room_Accommodation_Type" class="col-sm-3 control-label">Accommodation Type</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="room_Accommodation_Type">
                            <option value="">Select One</option>
                            <option value="BB">BB</option>
                            <option value="HB">HB</option>
                            <option value="FB">FB</option>
                        </select>
                        <script>document.getElementById('room_Accommodation_Type').value='<?php echo $room->room_Accommodation_Type ?>';</script>
                    </div>
                </div>

                <div class="form-group">
                    <label for="room_Comments" class="col-sm-2 control-label">Comments</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="room_Comments" rows="3" placeholder="Comments..."><?php echo $room->room_Comments ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="room_Price" class="col-sm-2 control-label"><i class="fa fa-money fa-lg"></i></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="room_Price" placeholder="Room Price" value="<?php echo $room->room_Price ?>">
                    </div>

                </div>

                <div class="form-group">
                    <label for="room_Seasoni" class="col-sm-2 control-label">Seasons</label>
                    <div class="col-sm-1">
                        <a class='btn btn-default btn-xs btn-circle' href="javascript:addNewSeason()">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <table id="tableSeasons" class='table table-hover table-bordered no-footer'>
                            <?php if(!$seasonList || count($seasonList)==0){?>
                                <tr>
                                    <td width="60%"><input type="text" class="tableNoEdit dateRange" placeholder="Date Range"></td>
                                    <td><input type="text" class="tableNoEdit" placeholder="Room Price"></td>
                                </tr>
                            <?php } ?>

                            <?php foreach($seasonList as $season){
                                $startDate = new DateTime($season->tour_Season_Start_Date);
                                $endDate = new DateTime($season->tour_Season_End_Date)
                                ?>
                            <tr>
                                <td width="60%"><input type="text" class="tableNoEdit dateRange" placeholder="Date Range" value="<?php echo($startDate->format('m/d/YYYY')." - ".$endDate->format('m/d/YYYY'))?>"></td>
                                <td><input type="text" class="tableNoEdit" placeholder="Room Price" value="<?php echo $season->tour_Season_Price?>"></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <script>
                            var saveControls=['ID','room_Type','room_Price','room_Accommodation_Type','room_Comments'];
                        </script>
                        <button type="button" id="btnSave" onclick="saveEData('<?php echo base_url('index.php/room/saveData/0') ?>',getPostData(saveControls),'room/loadAjaxGrid')" class="btn btn-info">
                            <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Update
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
    <?php
}else{
    echo 'No Record Found</br>';

}
$this->load->view('tools/loader',$controlData['stat']);
?>