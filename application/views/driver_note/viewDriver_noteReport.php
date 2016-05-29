<?php
if( $this->session->userdata('isLoggedIn') ) {
} else {
    redirect('/login');
}

//echo $controlData['stat']['statFlag'];

if($controlData['stat']['statFlag']==1){
    $tour=$controlData['data'][0];
    //print_r($tour)
    ?>
    <div style="height: 60px">
        <div style="float: left;">
            <h3>Driver Note : <small><?php echo $tour->tour_Enrolment_Id?> -> tour : <?php echo $tour->tour_Id?>
                (<?php
                    $inDate=new DateTime($tour->tour_Start_Date);
                    $outDate=new DateTime($tour->tour_End_Date);
                    echo date_format($inDate,"Y-m-d"); ?> to <?php echo date_format($outDate,"Y-m-d"); ?>)
                </small>
            </h3>
        </div>
        <div style="float: right;margin-top: 20px;margin-right: 2%">
            <button type="button" id="btnSave"  class="btn btn-info"
                    onclick="convert2Pdf()">
                <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> PDF
            </button>
            <button type="button" id="btnPrint"  class="btn btn-info"
                    onclick="preview()">
                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print
            </button>
        </div>
    </div>

    <div id="pdf2">

        <!-- Driver Note begin-->
        <div id="dynamicContent" style="border: none;background-color: white;overflow: hidden;padding-bottom: 12px;">

            <table class='table table-striped table-bordered table-hover no-footer' cellspacing='0' width='100%'>
                <tr>
                    <td colspan="6" style="padding: 3px"><h4 align="center">TourMaster SriLanka - <input style="width: 20%" class="tableNoEdit" type="text" value="<?php echo $tour->hotel_Name?>"/></h4></td>
                </tr>
                <tr>
                    <td>To : </td>
                    <td>Reservation Manager</td>
                    <td>Email : </td>
                    <td colspan="3"><input class="tableNoEdit" type="text" value="<?php echo $tour->hotel_ExtraEmail ?>"/></td>
                </tr>
                <tr>
                    <td>From : </td>
                    <td colspan="5">Anton Perera</td>
                </tr>
                <tr>
                    <td colspan="6" style="padding: 3px"><h4 align="center">Confirmation Voucher</h4></td>
                </tr>
                <tr>
                    <td>Agency Name : </td>
                    <td colspan="5">TourMaster Srilanka</td>
                </tr>
                <tr>
                    <td>In/Out : </td>
                    <?php
                    /*$inDate=new DateTime($tour->tour_Start_Date);
                    $outDate=new DateTime($tour->tour_End_Date);*/
                    $days = $inDate->diff($outDate); //date_diff($datetime1, $datetime2);
                    ?>

                    <td>In : <input class="tableNoEdit" style="width: 80px" type="text" value="<?php echo date_format($inDate,"Y-m-d"); ?>"/></td>
                    <td>Out : <input class="tableNoEdit" style="width: 80px" type="text" value="<?php echo date_format($outDate,"Y-m-d"); ?>"/></td>
                    <td>Nights : <input class="tableNoEdit" style="width: 80px" type="text" value="<?php echo $days->format('%a') ?>"/></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>Guest name : </td>
                    <td colspan="5"><input class="tableNoEdit" type="text" value="<?php echo($tour->customer_First_Name." ".$tour->customer_Last_Name)?>"/></td>
                </tr>
                <tr>
                    <td>Hotel : </td>
                    <td colspan="5"><input class="tableNoEdit" type="text" value="<?php echo $tour->hotel_Name?>"/></td>
                </tr>
                <tr>
                    <td>Hotel Address : </td>
                    <td colspan="5"><input class="tableNoEdit" type="text" value="<?php echo $tour->hotel_Address?>"/></td>
                </tr>
                <tr>
                    <td>Hotel Phone : </td>
                    <td colspan="2"><input class="tableNoEdit" type="text" value="<?php echo $tour->hotel_Telephone?>"/></td>
                    <td>Reservations Phone : </td>
                    <td colspan="2"><input class="tableNoEdit" type="text" value="<?php echo $tour->hotel_Telephone?>"/></td>
                </tr>
                <tr></tr>
                <tr>
                    <td colspan="4">Rooms</td>
                    <td colspan="2">Guests</td>
                </tr>
                <tr>
                    <td>No. Rooms</td>
                    <td>Basis</td>
                    <td>Room Configuration</td>
                    <td>Room Type</td>
                    <td>Adults</td>
                    <td>Children</td>
                </tr>
                <tr>
                    <td><input class="tableNoEdit" type="text" value="<?php echo $tour->tour_Number_Of_Rooms?>"/></td>
                    <td><input class="tableNoEdit" type="text" value="<?php echo $tour->room_Accommodation_Type?>"/></td>
                    <td><input class="tableNoEdit" type="text" value="............."/></td>
                    <td><input class="tableNoEdit" type="text" value="<?php echo $tour->room_Type?>"/></td>
                    <td><input class="tableNoEdit" type="text" value="<?php echo $tour->tour_Enrolment_Number_Of_Persons?>"/></td>
                    <td><input class="tableNoEdit" type="text" value="<?php echo $tour->tour_Enrolment_Number_Of_Children?>"/></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <u>Amount to pay</u><br/>
                        Directly to TourMaster SriLanka
                    </td>
                    <td colspan="3">
                        <u>Additional Requirements</u><br/>
                        <div style="min-height: 50px;padding-bottom: 2px">
                            <textarea class="tableNoEdit" placeholder="Additional Requirements..."></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Payment Terms</td>
                    <td colspan="4">Payment to be made 14 days prior to guests arrival.</td>
                </tr>
                <tr>
                    <td colspan="6">
                        <p style="text-align: center;">
                            <b>Note to Driver</b><br/>
                            Please present this Confirmation voucher if asked to the hotel receptionist upon check in.<br/>
                            <b>Important Notice to Hotel</b><br/>
                            If you have any question regarding this booking, Please contact Anton by phone 0771779894 or<br/>
                            e-mail reservation@tourmastersrilanka.com.<br/>
                            Invoice for the above services will be settled by TourMaster SriLanka.<br/>
                            Please do not charge the guest for the services listed on this voucher.<br/>
                            Any additional charges are to be billed direct to the guest and collect by the hotel at the time of check out.<br/>
                            With Thanks.<br>
                        </p>
                    </td>
                </tr>

                <tr style="padding: 0;height: 0">
                    <td style="width: 16%;padding: 0"></td>
                    <td style="width: 16%;padding: 0"></td>
                    <td style="width: 16%;padding: 0"></td>
                    <td style="width: 16%;padding: 0"></td>
                    <td style="width: 16%;padding: 0"></td>
                    <td style="width: 16%;padding: 0"></td>
                </tr>

            </table>

        </div>
        <!-- Driver Note end-->
    </div>

    <?php $this->load->view('tools/report');?>

    <script type="text/javascript">

        $('.tableNoEdit').focusin(
            function(control){
                $(this).removeClass( "tableNoEdit" );
                $(this).addClass( "tableEdit" );
                $(this).select();
            }
        ).focusout(
            function(){
                $(this).removeClass( "tableEdit" );
                $(this).addClass( "tableNoEdit" );
            }
        ).keyup(
            function(){
                if(this.type == "textarea") //text area inner html
                    $(this).html($(this).val());
                else
                    $(this).attr("value",$(this).val());//setting value attribute (val != value)
            }
        );

    </script>

    <?php $this->load->view('tools/loader',$controlData['stat']) ?>
<?php
}else{

    echo 'No Records Found</br>';
    $this->load->view('tools/loader',$controlData['stat']);
}
?>

