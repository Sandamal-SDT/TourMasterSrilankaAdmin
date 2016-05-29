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
$tour=$controlData['data'][0];
$enCustomerList=$controlData['data']['enCustomerList'];
$enRoomList=$controlData['data']['enRoomList'];
$enLocationList=$controlData['data']['enLocationList'];
?>


<h3 id="editPadHeading">Edit Day</h3>

<div style="border: 2px solid rgb(184, 184, 195);">
    <form class="form-horizontal">
        <div class="form-group">
            <input type="hidden" id="ID" value="<?php echo $tour->tour_Id?>">
        </div>

        <div class="form-group">
            <label for="tour_Start_Date" class="col-sm-2 control-label">Start Day</label>
            <div class="col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="tour_Start_Date" placeholder="Start Day" value="<?php echo $tour->tour_Start_Date?>">
                    <span class="input-group-addon">
                        <span aria-hidden="true"><i class="glyphicon glyphicon-calendar"></i></span>
                    </span>
                </div>
            </div>
            <script>$('#hotel_Contract_Expire_Date').datepicker({
                    format:'yyyy-mm-dd'
                });
            </script>

            <label for="tour_End_Date" class="col-sm-2 control-label">End Day</label>
            <div class="col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="tour_End_Date" placeholder="End Day" value="<?php echo $tour->tour_End_Date?>">
                    <span class="input-group-addon">
                        <span aria-hidden="true"><i class="glyphicon glyphicon-calendar"></i></span>
                    </span>
                </div>
            </div>
            <script>$('#tour_Start_Date,#tour_End_Date').datepicker({
                    format:'yyyy-mm-dd'
                });
            </script>

        </div>

        <div class="form-group">
            <label for="tour_Room_Id" class="col-sm-2 control-label">Room</label>
            <div>

                <div class="col-sm-3">
                    <select id="tour_Location_Id" class="form-control" onchange="filterSelection('<?php echo base_url('index.php/tour/getHotelsForLocation') ?>',this.value,'tour_Hotel_Id')">
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
                    <select id="tour_Hotel_Id" class="form-control" onchange="filterSelection('<?php echo base_url('index.php/tour/getRoomsForHotel') ?>',this.value,'tour_Room_Id')">
                        <option value="">Select Hotel</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select id="tour_Room_Id" class="form-control">
                        <?php
                        foreach($enRoomList as $key=>$value){
                            echo "<option value='".$key."'>".$value."</option>";
                        }
                        ?>
                    </select>
                    <script>document.getElementById('tour_Room_Id').value=<?php echo $tour->tour_Room_Id?>;</script>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="tour_Number_Of_Rooms" class="col-sm-2 control-label">Number of Rooms</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="tour_Number_Of_Rooms" placeholder="No. of Rooms" value="<?php echo $tour->tour_Number_Of_Rooms?>">
            </div>
            <div class="col-sm-offset-2 col-sm-10">
                <script>
                    var editControls=['ID','tour_Start_Date','tour_End_Date','tour_Room_Id','tour_Number_Of_Rooms'];
                </script>
                <button type="button" id="btnSave" onclick="saveEData('<?php echo base_url('index.php/tour/saveData/0') ?>',getPostData(editControls),'tour/loadAjaxGrid')" class="btn btn-info">
                    <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Update
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
