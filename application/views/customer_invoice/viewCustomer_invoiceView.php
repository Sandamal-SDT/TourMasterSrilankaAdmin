
<div style="height: 60px">
    <div style="float: left;">
        <h3>Customer Invoice</h3>
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

<?php
if( $this->session->userdata('isLoggedIn') ) {
} else {
    redirect('/login');
}

//echo $controlData['stat']['statFlag'];

if($controlData['stat']['statFlag']==1){
$tours=$controlData['data'];
$extraCharges=$controlData['extra'];
$ticketCharges=$controlData['ticket'];?>

        <div id="pdf2">
            <!-- Driver Note begin-->
            <div id="dynamicContent" style="padding-left: 25px;padding-right: 25px;padding-top: 15px;padding-bottom: 20px;border:1px solid rgba(66, 60, 60, 0.29);">
                <h3 class="text-center">Invoice</h3>
                <address>
                    <strong>Tourmaster Lanka International  (Pvt) Ltd.</strong><br/>
                    343/2, School Lane,<br/>
                    Negombo. Sri Lanka.<br/>
                    <strong>Telephone</strong>: (+94)77 433 7843<br/>
                    <strong>e-mail</strong>: info@tourmastersrilanka.com<br/>
                    <strong>Website</strong>: www.tourmastersrilanka.com
                </address>

                <hr/>

                <table>
                    <tr>
                        <td>Client Name : </td>
                        <td style="padding-left: 15px"><input class="tableNoEdit" type="text" value="<?php echo $controlData['data'][0]->customer_First_Name?>"/></td>
                    </tr>
                    <tr>
                        <td>Invoice Number : </td>
                        <td style="padding-left: 15px"><input class="tableNoEdit" type="text" value="TMI-.................."/></td>
                    </tr>
                    <tr>
                        <td>Date : </td>
                        <td style="padding-left: 15px"><input class="tableNoEdit" type="text" value="<?php echo(date("Y-m-d"))?>"/></td>
                    </tr>
                </table><br><br>

                <table class='table table-striped table-bordered table-hover no-footer' cellspacing='0'>

                    <tr>
                        <td>From</td>
                        <td>To</td>
                        <td colspan="2">Description</td>
                        <td>No. of Persons</td>
                        <td>Price per person</td>
                        <td>Amount (USD)</td>
                    </tr>

                    <?php
                        /*if(isset($tours)) {

                        $startDate=strtotime($tours[0]->tour_Start_Date);
                        $endDate=strtotime($tours[count($tours)-1]->tour_End_Date);
                        $dayCount=0;
                        $totHotelPrice=0;
                        $totProfit=0;
                        $driverChargePerDate=$tours[0]->driver_Charge_Per_Date;
                        $driver=$tours[0]->driver_Name;
                        //extra km
                        $extraKm=$tours[0]->tour_Enrolment_Extra_Mileage;
                        $extraKmCharge=$tours[0]->driver_Extra_Km_Charge;
                        $description=$tours[0]->tour_Enrolment_Description;
                        //extra kms
                        $driverExtraKmTot=$extraKm*$extraKmCharge;

                        //total tickets
                        $totTickets=0;
                        //number of persons
                        $noOfPersons=$tours[0]->tour_Enrolment_Number_Of_Persons;

                        foreach ($tours as $tour) {
                            //dates
                            $datetime1 = strtotime($tour->tour_Start_Date);
                            $datetime2 = strtotime($tour->tour_End_Date);
                            $secs = $datetime2 - $datetime1;// == <seconds between the two times>
                            $days = $secs / 86400;
                            if($days==0)
                                $days=1;

                            //day count
                            $dayCount+=$days;

                            //price
                            $price=$days*($tour->tour_Number_Of_Rooms);
                            //tot hotel price
                            $totHotelPrice+=$price;

                            //price per person
                            $pricePerPerson=$price/$noOfPersons;

                            //day description
                            $description = $tour->hotel_Name." - ".$tour->room_Type."(".$tour->tour_Number_Of_Rooms." rooms)";*/
                    ?>

                    <!--tr>
                        <td><input class="tableNoEdit" type="text" value="<?php echo date('Y-m-d',$datetime1)?>"/></td>
                        <td><input class="tableNoEdit" type="text" value="<?php echo date('Y-m-d',$datetime2)?>"/></td>
                        <td colspan="2"><input class="tableNoEdit" type="text" value="<?php echo $description?>"/></td>
                        <td><input class="tableNoEdit" type="text" value="<?php echo $noOfPersons?>"/></td>
                        <td><input class="tableNoEdit" type="text" value=""/></td>
                        <td><input class="tableNoEdit" type="text" value=""/></td>
                    </tr-->
                    <?php /*}*/ ?>

                    <tr>
                        <td><input class="tableNoEdit" type="text" placeholder="YYYY-MM-DD"/></td>
                        <td><input class="tableNoEdit" type="text" placeholder="YYYY-MM-DD"/></td>
                        <td colspan="2"><input class="tableNoEdit" type="text" placeholder="Description..."/></td>
                        <td><input class="tableNoEdit" type="text" placeholder=""/></td>
                        <td><input class="tableNoEdit" type="text" placeholder=""/></td>
                        <td><input class="tableNoEdit" type="text" placeholder=""/></td>
                    </tr>
                    <tr>
                        <td><input class="tableNoEdit" type="text" /></td>
                        <td><input class="tableNoEdit" type="text" /></td>
                        <td colspan="2"><input class="tableNoEdit" type="text" /></td>
                        <td><input class="tableNoEdit" type="text" /></td>
                        <td><input class="tableNoEdit" type="text" /></td>
                        <td><input class="tableNoEdit" type="text" /></td>
                    </tr>

                    <tr>
                        <td colspan="6" style="text-align: right">Total Due</td>
                        <td><input class="tableNoEdit" type="text" value=""/></td>
                    </tr>

                    <tr style="padding: 0;height: 0">
                        <td style="width: 14%;padding: 0"></td>
                        <td style="width: 14%;padding: 0"></td>
                        <td style="width: 14%;padding: 0"></td>
                        <td style="width: 14%;padding: 0"></td>
                        <td style="width: 14%;padding: 0"></td>
                        <td style="width: 14%;padding: 0"></td>
                        <td style="width: 14%;padding: 0"></td>
                    </tr>

                </table>

                <p>
                    <b>Payment Mode : </b> Bank Transfer <br>
                    <b>Bank Details :</b> <br/>
                    <input class="tableNoEdit" style="width:35%" type="text" value="Commercial Bank"/><br/>
                    <input class="tableNoEdit" style="width:35%"type="text" value="No.178, Colombo Road, Negombo. Sri Lanka."/><br>
                    <b>Account No. : </b><input class="tableNoEdit" style="width:35%" type="text" value="1118022175"/> <br>
                    <b>Swift Code  : </b> <input class="tableNoEdit" style="width:35%" type="text" value="CCEYLKLX"/><br>
                    <b>Branch Code : </b><input class="tableNoEdit" style="width:35%" type="text" value="118"/> <br>
                </p>
            </div>
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
            $(this).attr("value",$(this).val());//setting value attribute (val != value)
        }
    );

</script>

<?php $this->load->view('tools/loader',$controlData['stat']) ?>

    <?php
/*}else{

    echo 'No Records Found</br>';
    $this->load->view('tools/loader',$controlData['stat']);
}*/
}
?>
