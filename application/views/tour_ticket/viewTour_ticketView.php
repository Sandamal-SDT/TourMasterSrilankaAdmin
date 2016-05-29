<h3>View Tour</h3></br>
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
            <td>Tour-Ticket ID</td>
            <td><?php echo $tour->tour_Ticket_Id?></td>
        </tr>
        <tr>
            <td>Tour Enrolment</td>
            <td><?php echo $tour->tour_Ticket_Tour_Enrolment_Id?></td>
        </tr>
        <tr>
            <td>Ticket</td>
            <td><?php echo $tour->ticket_Name?></td>
        </tr>
        <tr>
            <td>No Of Tickets</td>
            <td><?php echo $tour->tour_Ticket_No_Of_Tickets?></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><?php echo $tour->tour_Ticket_Description?></td>
        </tr>

    </table>

    <?php $this->load->view('tools/loader',$controlData['stat']) ?>

<?php
}else{

    echo 'No Records Found</br>';
    $this->load->view('tools/loader',$controlData['stat']);
}
?>

