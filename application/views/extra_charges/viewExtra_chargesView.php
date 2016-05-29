<h3>View Tour</h3></br>
<?php
if( $this->session->userdata('isLoggedIn') ) {
} else {
    redirect('/login');
}

//echo $controlData['stat']['statFlag'];

if($controlData['stat']['statFlag']==1){
    $extraCharges=$controlData['data']; ?>


    <table class='table table-striped table-bordered table-hover no-footer' cellspacing='0' width='100%'>
        <tr>
            <td>Extra Charges ID</td>
            <td><?php echo $extraCharges->tour_Extra_Charge_Id?></td>
        </tr>
        <tr>
            <td>Tour Enrolment</td>
            <td><?php echo $extraCharges->tour_Extra_Charge_Tour_Enrolment_Id?></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><?php echo $extraCharges->tour_Extra_Charge_Description?></td>
        </tr>
        <tr>
            <td>Charge</td>
            <td><?php echo $extraCharges->tour_Extra_Charge_Extra_charge?></td>
        </tr>

    </table>

    <?php $this->load->view('tools/loader',$controlData['stat']) ?>

<?php
}else{

    echo 'No Records Found</br>';
    $this->load->view('tools/loader',$controlData['stat']);
}
?>

