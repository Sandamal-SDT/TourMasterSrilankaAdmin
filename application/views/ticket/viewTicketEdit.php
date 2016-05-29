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
    $ticket=$controlData['data'][0];
    ?>


    <form class="form-horizontal">
        <div class="form-group">
            <input type="hidden" id="ID" value="<?php echo $ticket->ticket_Id?>">
            <label for="ticket_Name" class="col-sm-2 control-label">Ticket</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="ticket_Name" placeholder="Ticket" value="<?php echo $ticket->ticket_Name?>">
            </div>
        </div>

        <div class="form-group">
            <label for="ticket_Description" class="col-sm-2 control-label">Ticket Description</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="ticket_Description" placeholder="Ticket Description" value="<?php echo $ticket->ticket_Description?>">
            </div>
        </div>

        <div class="form-group">
            <label for="ticket_Price" class="col-sm-2 control-label">Ticket Price</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="ticket_Price" placeholder="Ticket Price" value="<?php echo $ticket->ticket_Price?>">
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <script>var editControls=['ID','ticket_Name','ticket_Description','ticket_Price'];</script>
                <button type="button" id="btnSave" onclick="saveData('<?php echo base_url('index.php/ticket/saveData/0') ?>',getPostData(editControls),'ticket/loadAjaxGrid')" class="btn btn-info">
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

