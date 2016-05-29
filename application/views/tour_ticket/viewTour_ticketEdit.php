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
    $tour_Ticket=$controlData['data'][0];
    $enCustomerList=$controlData['data']['enTour_enList'];
    $enTicketList=$controlData['data']['enTicketList'];
    ?>


    <form class="form-horizontal">
        <div class="form-group">
            <input type="hidden" id="ID" value="<?php echo $tour_Ticket->tour_Ticket_Id?>">
            <label for="tour_Ticket_Tour_Enrolment_Id" class="col-sm-2 control-label">Tour Enrolment</label>
            <div class="col-sm-10">
                <!--<input type="text" class="form-control" id="tour_Enrolment_Id" placeholder="Tour EnrolmentId" value="<?php echo $tour_Ticket->tour_Tour_Enrolment_Id?>">-->
                <select id="tour_Ticket_Tour_Enrolment_Id" class="form-control">
                    <?php
                    foreach($enCustomerList as $key=>$value){
                        echo "<option value='".$key."'>".$value."</option>";
                    }
                    ?>
                </select>
                <script>document.getElementById('tour_Ticket_Tour_Enrolment_Id').value=<?php echo $tour_Ticket->tour_Ticket_Tour_Enrolment_Id?>;</script>
            </div>
        </div>

        <div class="form-group">
            <label for="tour_Ticket_Ticket_Id" class="col-sm-2 control-label">Ticket</label>
            <div class="col-sm-10">
                <!--<input type="text" class="form-control" id="tour_Room_Id" placeholder="Room Id" value="<?php echo $tour_Ticket->tour_Room_Id?>">-->
                <select id="tour_Ticket_Ticket_Id" class="form-control">
                    <?php
                    foreach($enTicketList as $key=>$value){
                        echo "<option value='".$key."'>".$value."</option>";
                    }
                    ?>
                </select>
                <script>document.getElementById('tour_Ticket_Ticket_Id').value=<?php echo $tour_Ticket->tour_Ticket_Ticket_Id?>;</script>
            </div>
        </div>

        <div class="form-group">
            <label for="tour_Ticket_No_Of_Tickets" class="col-sm-2 control-label">No Of Tickets</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="tour_Ticket_No_Of_Tickets" placeholder="Start Day" value="<?php echo $tour_Ticket->tour_Ticket_No_Of_Tickets?>">
            </div>
        </div>

        <div class="form-group">
            <label for="tour_Ticket_Description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="tour_Ticket_Description" placeholder="End Day" value="<?php echo $tour_Ticket->tour_Ticket_Description?>">
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <script>
                    var editControls=['ID','tour_Ticket_Tour_Enrolment_Id','tour_Ticket_Ticket_Id','tour_Ticket_No_Of_Tickets','tour_Ticket_Description'];
                </script>
                <button type="button" id="btnSave" onclick="saveData('<?php echo base_url('index.php/tour_ticket/saveData/0') ?>',getPostData(editControls),'tour_ticket/loadAjaxGrid')" class="btn btn-info">
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

