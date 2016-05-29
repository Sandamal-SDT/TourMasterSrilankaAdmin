<?php
/**
 * Created by PhpStorm.
 * User: cHiN
 * Date: 2015-09-04
 * Time: 7:43 PM
 */
if( $this->session->userdata('isLoggedIn') ) {
} else {
    redirect('/login');
}
?>

<h3>Edit Tour</h3>
<br/>

<?php

//echo $controlData['stat']['statFlag'];

if($controlData['stat']['statFlag']==1){
    $tour=$controlData['data'][0];
    $customerList=$controlData['data']['customerList'];
    $driverList=$controlData['data']['driverList'];
    ?>


    <form class="form-horizontal">
        <div class="form-group">
            <input type="hidden" id="ID" value="<?php echo $tour->tour_Enrolment_Id?>">
            <label for="tour_en_customer_Id" class="col-sm-2 control-label">Customer</label>

            <div class="col-sm-10">
                <select id="tour_en_customer_Id" class="form-control">
                    <?php
                    foreach($customerList as $key=>$value){
                        echo "<option value='".$key."'>".$value."</option>";
                    }
                    ?>
                </select>
                <script>document.getElementById('tour_en_customer_Id').value=<?php echo $tour->tour_Enrolment_Customer_Id?>;</script>
            </div>

        </div>
        <div class="form-group">
            <label for="tour_Enrolment_Driver_Id" class="col-sm-2 control-label">Driver</label>
            <div class="col-sm-10">
                <select id="tour_Enrolment_Driver_Id" class="form-control">
                    <?php
                    foreach($driverList as $key=>$value){
                        echo "<option value='".$key."'>".$value."</option>";
                    }
                    ?>
                </select>
            </div>
            <script>document.getElementById('tour_Enrolment_Driver_Id').value=<?php echo $tour->tour_Enrolment_Driver_Id?>;</script>
        </div>

        <div class="form-group">
            <label for="tour_Enrolment_Number_Of_Persons" class="col-sm-2 control-label">Number of Persons</label>
            <div class="col-sm-5">
                <div class="input-group">
                    <input type="text" class="form-control" id="tour_Enrolment_Number_Of_Persons" placeholder="Number of Adults" value="<?php echo $tour->tour_Enrolment_Number_Of_Persons?>">
                    <span class="btn input-group-addon">
                        <span aria-hidden="true">Adults</span>
                    </span>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="input-group">
                    <input type="text" class="form-control" id="tour_Enrolment_Number_Of_Children" placeholder="Number of Children" value="<?php echo $tour->tour_Enrolment_Number_Of_Children ?>">
                    <span class="btn input-group-addon">
                        <span aria-hidden="true">Children</span>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="tour_Enrolment_Extra_Mileage" class="col-sm-2 control-label">Extra Mileage</label>
            <div class="col-sm-5">
                <div class="input-group">
                    <input type="text" maxlength="4" class="form-control" id="tour_Enrolment_Extra_Mileage" placeholder="Extra Mileage" value="<?php echo $tour->tour_Enrolment_Extra_Mileage?>">
                     <span class="input-group-addon">
                            <span aria-hidden="true">Km</span>
                     </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="tour_Enrolment_Description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
                <textarea name="Description" id="tour_Enrolment_Description" placeholder="Tour enrolment description..." class="form-control"><?php echo $tour->tour_Enrolment_Description?></textarea>
            </div>
        </div>

        <div class="form-group">

            <label for="tour_Enrolment_Arrives" class="col-sm-2 control-label">Arrives</label>

            <div class="col-sm-5">
                <div class="input-group">
                    <input type="text" class="form-control datePicker" id="tour_Enrolment_Arrives" placeholder="Customer Arrives at" value="<?php echo $tour->tour_Enrolment_Arrives ?>">
                    <span class="btn input-group-addon">
                        <span aria-hidden="true"><i class="glyphicon glyphicon-calendar"></i></span>
                    </span>
                </div>
            </div>

            <div class="col-sm-5">
                <div class="input-group">
                    <input type="text" class="form-control" id="tour_Enrolment_Arrive_Time" placeholder="Customer Arrives HH:MM" value="<?php echo $tour->tour_Enrolment_Arrive_Time ?>">
                    <span class="btn input-group-addon">
                        <span aria-hidden="true"><i class="glyphicon glyphicon-time"></i></span>
                    </span>
                </div>
            </div>

        </div>

        <div class="form-group">

            <label for="tour_Enrolment_Departure" class="col-sm-2 control-label">Departure</label>

            <div class="col-sm-5">
                <div class="input-group">
                    <input type="text" class="form-control datePicker" id="tour_Enrolment_Departure" placeholder="Customer Departure on" value="<?php echo $tour->tour_Enrolment_Departure ?>">
                    <span class="btn input-group-addon btnDatePicker">
                        <span aria-hidden="true"><i class="glyphicon glyphicon-calendar"></i></span>
                    </span>
                </div>
            </div>

        </div>

        <div class="form-group">
            <label for="tour_Enrolment_Days" class="col-sm-2 control-label">No of days</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="tour_Enrolment_Days" placeholder="Tour enrolment days" value="<?php echo $tour->tour_Enrolment_Days ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <script>
                    var editControls=['ID','tour_en_customer_Id','tour_Enrolment_Driver_Id',
                    'tour_Enrolment_Number_Of_Persons','tour_Enrolment_Extra_Mileage','tour_Enrolment_Description',
                    'tour_Enrolment_Arrives','tour_Enrolment_Departure','tour_Enrolment_Days',
                    'tour_Enrolment_Number_Of_Children','tour_Enrolment_Arrive_Time'];
                </script>
                <button type="button" id="btnSave" onclick="saveData('<?php echo base_url('index.php/tour_en/saveData/0') ?>',getPostData(editControls),'tour_en/loadAjaxGrid')" class="btn btn-info">
                    <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Update
                </button>

            </div>
        </div>
    </form>

    <script>$(function () {$('[data-toggle="tooltip"]').tooltip()});$('.datePicker').datepicker({format:'yyyy-mm-dd'});</script>

<?php
}else{
    echo 'No Records Found</br>';

}
    $this->load->view('tools/loader',$controlData['stat']);
?>

