<h3>View Tour Enrolment</h3></br>
<?php
if( $this->session->userdata('isLoggedIn') ) {
} else {
    redirect('/login');
}

//echo $controlData['stat']['statFlag'];

if($controlData['stat']['statFlag']==1){
    $tour=$controlData['data']; ?>


    <table class='table table-striped table-bordered table-hover no-footer' cellspacing='0' width='100%'>
        <tr>
            <td>Tour Enrolment ID</td>
            <td><?php echo $tour->tour_Enrolment_Id?></td>
        </tr>
        <tr>
            <td>Customer</td>
            <td><?php echo $tour->customer_First_Name?> <?php echo $tour->customer_Last_Name?></td>
        </tr>
        <tr>
            <td>Driver</td>
            <td><?php echo $tour->driver_Name?></td>
        </tr>
        <tr>
            <td>Number of Persons</td>
            <td>Adults : <?php echo $tour->tour_Enrolment_Number_Of_Persons ?> / Children : <?php echo $tour->tour_Enrolment_Number_Of_Children ?></td>
        </tr>
        <tr>
            <td>Extra Mileage</td>
            <td><?php echo $tour->tour_Enrolment_Extra_Mileage ?></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><?php echo $tour->tour_Enrolment_Description ?></td>
        </tr>
        <tr>
            <td>Arrival date time</td>
            <td><?php echo $tour->tour_Enrolment_Arrives ?> @ <?php echo $tour->tour_Enrolment_Arrive_Time ?></td>
        </tr>
        <tr>
            <td>Departure date</td>
            <td><?php echo $tour->tour_Enrolment_Departure ?></td>
        </tr>
        <tr>
            <td>Number of days</td>
            <td><?php echo $tour->tour_Enrolment_Days ?></td>
        </tr>

    </table>

    <?php $this->load->view('tools/loader',$controlData['stat']) ?>

<?php
}else{

    echo 'No Records Found</br>';
    $this->load->view('tools/loader',$controlData['stat']);
}
?>

