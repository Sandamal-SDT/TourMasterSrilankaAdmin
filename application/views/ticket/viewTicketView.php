<h3>View Tour</h3></br>
<?php
if( $this->session->userdata('isLoggedIn') ) {
} else {
    redirect('/login');
}

//echo $controlData['stat']['statFlag'];

if($controlData['stat']['statFlag']==1){
    $ticket=$controlData['data'][0]; ?>


    <table class='table table-striped table-bordered table-hover no-footer' cellspacing='0' width='100%'>
        <tr>
            <td>Ticket ID</td>
            <td><?php echo $ticket->ticket_Id?></td>
        </tr>
        <tr>
            <td>Ticket</td>
            <td><?php echo $ticket->ticket_Name?></td>
        </tr>
        <tr>
            <td>Ticket Description</td>
            <td><?php echo $ticket->ticket_Description?></td>
        </tr>
        <tr>
            <td>Ticket Price</td>
            <td><?php echo $ticket->ticket_Price?></td>
        </tr>

    </table>

    <?php $this->load->view('tools/loader',$controlData['stat']) ?>

<?php
}else{

    echo 'No Records Found</br>';
    $this->load->view('tools/loader',$controlData['stat']);
}
?>

