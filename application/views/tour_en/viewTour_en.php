<?php $this->load->view('master/header') ?>

<!-- Jquery Datatables-->
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.responsive.css" rel="stylesheet" type="text/css">

<!--page styles-->
<link href="<?php echo base_url();?>assets/styles/customer/customer.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/styles/tour_en/tour_en.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/libs/datepicker/css/datepicker.css" rel="stylesheet" type="text/css">

<?php
    $pageTitle['path']="TMSL > Tour > ";
    $pageTitle['pageTitle']="Tour Enrolment";
    $this->load->view('master/navigation',$pageTitle)
?>


    
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row"><div class="col-sm-12 col-md-12"> <br/> </div></div>

        <div class="row">
            <ul class="nav nav-tabs">
                <li id="tabSearchLink" class="active"><a data-toggle="tab" href="#tabSearch"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search</a></li>
                <li id="tabViewLink" style="display:none"><a data-toggle="tab" href="#tabView"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a></li> <!--display:none-->
                <li id="tabEditLink" style="display:none"><a data-toggle="tab" href="#tabEdit"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a></li> <!--display:none-->
                <?php if(validateEdit()){?>
                <li id="tabAddLink"><a data-toggle="tab" href="#tabAdd"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Add</a></li>
                <?php } ?>
            </ul>

            <div class="tab-content">
                <div id="tabSearch" class="tab-pane fade in active">

                    <div class="row"><div class="col-sm-12 col-md-12"> <br/> </div></div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <form class="form-inline">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                        </span>
                                        <input type="text" class="form-control" id="customerS" placeholder="Customer Name">
                                        <span class="input-group-btn">
                                            <script>var searchControls=['customerS'];</script>
                                            <button type="button" id="btnSearch" onclick="searchData('<?php echo base_url('index.php/tour_en/getSearchGrid') ?>',getPostDataSearch(searchControls),'')" class="btn btn-default" aria-label="Left Align">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row"><div class="col-sm-12 col-md-12"> <br/> </div></div>

                    <div id="tableContainer">
                        <!-- grid -->
                        <?php $this->load->view('tools/grid',$gridData); ?>
                    </div>
                </div>
                <div id="tabView" class="tab-pane fade">
                </div>
                <div id="tabEdit" class="tab-pane fade">
                </div>
                <div id="tabAdd" class="tab-pane fade">
                    <h3>Add Tour</h3>
                    <br/>

                    <form class="form-horizontal">

                        <div class="form-group">
                            <input type="hidden" id="IDi" value="-1">
                            <label for="customer_Idi" class="col-sm-2 control-label">Customer</label>
                            <div class="col-sm-10">
                                <!--<input type="text" class="form-control" id="customer_Idi" placeholder="Customer" >-->
                                <select id="customer_Idi" class="form-control">
                                    <option value="">Select one</option>
                                    <?php foreach($customerList as $key=>$value){ echo "<option value='".$key."'>".$value."</option>"; } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="driver_Idi" class="col-sm-2 control-label">Driver</label>
                            <div class="col-sm-10">
                                <!--<input type="text" class="form-control" id="customer_Idi" placeholder="Customer" >-->
                                <select id="driver_Idi" class="form-control">
                                    <option value="">Select one</option>
                                    <?php foreach($driverList as $key=>$value){ echo "<option value='".$key."'>".$value."</option>"; } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tour_Enrolment_Number_Of_Personsi" class="col-sm-2 control-label">Number of Persons</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tour_Enrolment_Number_Of_Personsi" placeholder="Number of Adults">
                                    <span class="btn input-group-addon">
                                        <span aria-hidden="true">Adults</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tour_Enrolment_Number_Of_Childreni" placeholder="Number of Children">
                                    <span class="btn input-group-addon">
                                        <span aria-hidden="true">Children</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tour_Enrolment_Extra_Mileagei" class="col-sm-2 control-label">Extra Mileage</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tour_Enrolment_Extra_Mileagei" maxlength="4" placeholder="Extra Mileage">
                                    <span class="input-group-addon">
                                        <span aria-hidden="true">Km</span>
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="tour_Enrolment_Descriptioni" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <textarea name="Descriptioni" id="tour_Enrolment_Descriptioni" placeholder="Tour enrolment description..." class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="tour_Enrolment_Arrivesi" class="col-sm-2 control-label">Arrives</label>

                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" class="form-control datePicker" id="tour_Enrolment_Arrivesi" placeholder="Customer Arrives at">
                                    <span class="btn input-group-addon btnDatePicker">
                                        <span aria-hidden="true"><i class="glyphicon glyphicon-calendar"></i></span>
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tour_Enrolment_Arrive_Timei" placeholder="Customer Arrives HH:MM">
                                    <span class="btn input-group-addon btnDatePicker">
                                        <span aria-hidden="true"><i class="glyphicon glyphicon-time"></i></span>
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">

                            <label for="tour_Enrolment_Departurei" class="col-sm-2 control-label">Departure</label>

                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" class="form-control datePicker" id="tour_Enrolment_Departurei" placeholder="Customer Departure on">
                                    <span class="btn input-group-addon btnDatePicker">
                                        <span aria-hidden="true"><i class="glyphicon glyphicon-calendar"></i></span>
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="tour_Enrolment_Daysi" class="col-sm-2 control-label">No of days</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tour_Enrolment_Daysi" placeholder="Tour enrolment days">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <script>var saveControls=['IDi','customer_Idi','driver_Idi','tour_Enrolment_Number_Of_Personsi','tour_Enrolment_Extra_Mileagei','tour_Enrolment_Descriptioni','tour_Enrolment_Arrivesi','tour_Enrolment_Departurei','tour_Enrolment_Daysi','tour_Enrolment_Number_Of_Childreni','tour_Enrolment_Arrive_Timei'];</script>
                                <button type="button" id="btnInsert" onclick="saveData('<?php echo base_url('index.php/tour_en/saveData/1') ?>',getPostData(saveControls),'tour_en/loadAjaxGrid')" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Insert
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->


<script>
    function getPostData(ctrlist){
        var tour_en_Id=$('#'+ctrlist[0]).val();
        var tour_en_customer_Id=$('#'+ctrlist[1]).val();
        var tour_Enrolment_Driver_Id=$('#'+ctrlist[2]).val();

        var tour_Enrolment_Number_Of_Persons=$('#'+ctrlist[3]).val();
        var tour_Enrolment_Extra_Mileage=$('#'+ctrlist[4]).val();
        var tour_Enrolment_Description=$('#'+ctrlist[5]).val();

        var tour_Enrolment_Arrives=$('#'+ctrlist[6]).val();
        var tour_Enrolment_Departure=$('#'+ctrlist[7]).val();
        var tour_Enrolment_Days=$('#'+ctrlist[8]).val();

        var tour_Enrolment_Number_Of_Children=$('#'+ctrlist[9]).val();
        var tour_Enrolment_Arrive_Time=$('#'+ctrlist[10]).val();

        var post={
            'tour_en_Id':tour_en_Id,
            'tour_en_customer_Id':tour_en_customer_Id,
            'tour_Enrolment_Driver_Id':tour_Enrolment_Driver_Id,
            'tour_Enrolment_Number_Of_Persons':tour_Enrolment_Number_Of_Persons,
            'tour_Enrolment_Extra_Mileage':tour_Enrolment_Extra_Mileage,
            'tour_Enrolment_Description':tour_Enrolment_Description,
            'tour_Enrolment_Arrives':tour_Enrolment_Arrives,
            'tour_Enrolment_Departure':tour_Enrolment_Departure,
            'tour_Enrolment_Days':tour_Enrolment_Days,
            'tour_Enrolment_Number_Of_Children':tour_Enrolment_Number_Of_Children,
            'tour_Enrolment_Arrive_Time':tour_Enrolment_Arrive_Time
        };

        var postList={
            'post':post,
            'ctrList':ctrlist
        }
        return postList;
    }

    function getPostDataSearch(ctrlist){
        var tour_en_customer_Id=$('#'+ctrlist[0]).val();

        var post={
            'tour_en_customer_Id':tour_en_customer_Id
        };

        var postList={
            'post':post,
            'ctrList':ctrlist
        }
        return postList;
    }

</script>


<?php $this->load->view('master/footer') ?>

<!-- Jquery Datatable scripts-->
<script src="<?php echo base_url();?>assets/libs/DataTables-1.10.9/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/DataTables-1.10.9/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/datepicker/js/bootstrap-datepicker.js"></script>

<!-- page scripts -->
<script src="<?php echo base_url();?>assets/scripts/master/integrate.js"></script>
<script>$(function () {$('[data-toggle="tooltip"]').tooltip()});$('.datePicker').datepicker({format:'yyyy-mm-dd'});</script>

<!--stat loader -->
<?php
$this->load->view('tools/loader',$ctrlData);
?>

</body>
</html>
