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

<h3>Edit Hotel</h3></br>

<?php

//echo $controlData['stat']['statFlag'];

if($controlData['stat']['statFlag']==1){
    $extraCharge=$controlData['data'][0];
    $enCustomerList=$controlData['data']['enCustomerList'];
    ?>


    <form class="form-horizontal">
        <div class="form-group">
            <input type="hidden" id="ID" value="<?php echo $extraCharge->tour_Extra_Charge_Id?>">
            <label for="tour_Enrolment_Id" class="col-sm-2 control-label">Tour Enrolment</label>
            <div class="col-sm-10">
                <!--<input type="text" class="form-control" id="tour_Enrolment_Id" placeholder="Tour EnrolmentId" value="<?php echo $extraCharge->tour_Extra_Charge_Tour_Enrolment_Id?>">-->
                <select id="tour_Enrolment_Id" class="form-control">
                    <?php foreach($enCustomerList as $key=>$value){ echo "<option value='".$key."'>".$value."</option>"; } ?>
                </select>
                <script>document.getElementById('tour_Enrolment_Id').value=<?php echo $extraCharge->tour_Extra_Charge_Tour_Enrolment_Id?>;</script>
            </div>
        </div>

        <div class="form-group">
            <label for="tour_Extra_Charge_Description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="tour_Extra_Charge_Description" placeholder="Description" value="<?php echo $extraCharge->tour_Extra_Charge_Description?>">
            </div>
        </div>

        <div class="form-group">
            <label for="tour_Extra_Charge_Extra_charge" class="col-sm-2 control-label">Charge</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="tour_Extra_Charge_Extra_charge" placeholder="Charge" value="<?php echo $extraCharge->tour_Extra_Charge_Extra_charge?>">
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <script>var editControls=['ID','tour_Enrolment_Id','tour_Extra_Charge_Description','tour_Extra_Charge_Extra_charge'];</script>
                <button type="button" id="btnSave" onclick="saveData('<?php echo base_url('index.php/extra_charges/saveData/0') ?>',getPostData(editControls),'extra_charges/loadAjaxGrid')" class="btn btn-info">
                    <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Update
                </button>
            </div>
        </div>
    </form>


<?php
}else{
    echo 'No Records Found</br>';

}
    $this->load->view('tools/loader',$controlData['stat']);
?>

