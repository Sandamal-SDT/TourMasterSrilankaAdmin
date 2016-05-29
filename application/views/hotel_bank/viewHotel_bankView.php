<h3>Tour Enrollment</h3></br>
<?php
if( $this->session->userdata('isLoggedIn') ) {
} else {
    redirect('/login');
}

//echo $controlData['stat']['statFlag'];

if($controlData['stat']['statFlag']==1){
    $tourEn=$controlData['tourEnDetails'];
    if(sizeof($tourEn)>0)
        $tourEn=$tourEn[0];
    $day=$controlData['tourDayDetails'];
    ?>


    <table class='table table-striped table-bordered table-hover no-footer' cellspacing='0' width='100%'>
        <tr>
            <td style="width: 20%">Tour Enrolment</td>
            <td>
                <input type="hidden" id="tourEnId" value="<?php echo $tourEn->tour_Enrolment_Id?>"/>
                <?php echo $tourEn->tour_Enrolment_Id?>
            </td>
        </tr>
        <tr>
            <td>Customer</td>
            <td><?php echo $tourEn->customer_First_Name?></td>
        </tr>
    </table>


    <h3 style="float: left">Tour Days</h3>


    <div id="gridContainer">
        <table class='table table-striped table-bordered table-hover no-footer' cellspacing='0' width='100%'>
        <thead>
            <tr>
                <td>Start Date</td>
                <td>End Date</td>
                <td>Hotel Description</td>
            </tr>
        </thead>
        <?php foreach ($day as $row) {?>
            <tr>
                <td>
                    <?php echo ($row->tour_Start_Date)?>
                </td>
                <td>
                    <?php echo ($row->tour_End_Date)?>
                </td>
                <td>
                    <?php echo ($row->hotel_Name)?>
                </td>
            </tr>
        <?php }?>
        </table>
        <button type="button" id="btnPrint"  class="btn btn-info" style="float: right"
                onclick=<?php
        echo "getJson(\"".base_url("index.php/hotel_bank/getHotelDetailsById") ."/". $tourEn->tour_Enrolment_Id ."\",getEdit,{})";
        ?>>

        <span class="glyphicon glyphicon-print" aria-hidden="true"></span> View
        </button>
        </br></br></br>
    </div>
    <?php $this->load->view('tools/loader',$controlData['stat']) ?>

<?php
}else{

    echo 'No Records Found</br>';
    $this->load->view('tools/loader',$controlData['stat']);
}
?>

