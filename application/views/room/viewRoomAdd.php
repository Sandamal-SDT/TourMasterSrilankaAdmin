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
?>

<div class="alert alert-info alert-dismissible" style="padding-top: 0px !important;padding-right: 15px !important;" role="alert">
    <div>
        <button type="button" class="close" style="right: -5px !important;top: -15px !important;font-size: 30px;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 id="editPadHeading">Add Room</h3>
        <div style="border: 2px solid rgb(184, 184, 195);">
            <form class="form-horizontal">

                <div class="form-group">
                    <input type="hidden" id="IDi" value="-1">
                </div>

                <div class="form-group">
                    <input type="hidden" id="IDi" value="-1">

                    <label for="room_Typei" class="col-sm-2 control-label">Room Type</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="room_Typei">
                            <option value="">Select One</option>
                            <option value="Single">Single</option>
                            <option value="Double">Double</option>
                            <option value="Triple">Triple</option>
                            <option value="Family">Family</option>
                            <option value="Special">Special</option>
                        </select>
                    </div>

                    <label for="room_Accommodation_Typei" class="col-sm-3 control-label">Accommodation Type</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="room_Accommodation_Typei">
                            <option value="">Select One</option>
                            <option value="BB">BB</option>
                            <option value="HB">HB</option>
                            <option value="FB">FB</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="room_Commentsi" class="col-sm-2 control-label">Comments</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="room_Commentsi" rows="3" placeholder="Comments..."></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="room_Pricei" class="col-sm-2 control-label"><i class="fa fa-money fa-lg"></i></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="room_Pricei" placeholder="Room Price">
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
                            <tr>
                                <td width="60%"><input type="text" class="tableNoEdit dateRange" placeholder="Date Range"></td>
                                <td><input type="text" class="tableNoEdit" placeholder="Room Price"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <script>
                            var saveControls=['IDi','room_Typei','room_Pricei','room_Accommodation_Typei','room_Commentsi'];
                        </script>
                        <button type="button" id="btnInsert" onclick="saveEData('<?php echo base_url('index.php/room/saveData/1') ?>',getPostData(saveControls),'room/loadAjaxGrid')" class="btn btn-primary">
                            <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Insert
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