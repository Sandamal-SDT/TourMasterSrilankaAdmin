<?php $this->load->view('master/header') ?>

<!-- Jquery Datatables-->
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.responsive.css" rel="stylesheet" type="text/css">

<!--page scripts-->
<link href="<?php echo base_url();?>assets/styles/customer/customer.css" rel="stylesheet" type="text/css">


<?php
    $pageTitle['path']="TMSL > Charges > ";
    $pageTitle['pageTitle']="Extra Charges";
    $this->load->view('master/navigation',$pageTitle)
?>


    
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12 col-md-12">
                <br/>
            </div>
        </div>

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

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <br/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <form class="form-inline">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-road"></i>
                                        </span>
                                        <input type="text" class="form-control" id="extra_chargesEnS" placeholder="Tour Enrolment">
                                        <span class="input-group-btn">
                                            <script>var searchControls=['extra_chargesEnS'];</script>
                                            <button type="button" id="btnSearch" onclick="searchData('<?php echo base_url('index.php/extra_charges/getSearchGrid') ?>',getPostDataSearch(searchControls),'')" class="btn btn-default" aria-label="Left Align">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <br/>
                        </div>
                    </div>

                    <div id="tableContainer">
                        <!-- grid -->
                        <?php
                            $this->load->view('tools/grid',$gridData);
                        ?>
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
                            <label for="extra_charges_Enrolment_Idi" class="col-sm-2 control-label">Tour Enrolment</label>
                            <div class="col-sm-10">
                                <!--<input type="text" class="form-control" id="extra_charges_Enrolment_Idi" placeholder="Tour Enrolment" >-->
                                <select id="extra_charges_Enrolment_Idi" class="form-control">
                                    <option value="">Select One</option>
                                    <?php
                                    if(isset($enCustomerList))
                                    foreach($enCustomerList as $key=>$value){
                                        echo "<option value='".$key."'>".$value."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tour_Extra_Charge_Descriptioni" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tour_Extra_Charge_Descriptioni" placeholder="Description">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tour_Extra_Charge_Extra_chargei" class="col-sm-2 control-label">Charge</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tour_Extra_Charge_Extra_chargei" placeholder="Charge">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <script>var saveControls=['IDi','extra_charges_Enrolment_Idi','tour_Extra_Charge_Descriptioni','tour_Extra_Charge_Extra_chargei'];</script>
                                <button type="button" id="btnInsert" onclick="saveData('<?php echo base_url('index.php/extra_charges/saveData/1') ?>',getPostData(saveControls),'extra_charges/loadAjaxGrid')" class="btn btn-primary">
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

        var tour_Extra_Charge_Id=$('#'+ctrlist[0]).val();
        var tour_Extra_Charge_Tour_Enrolment_Id=$('#'+ctrlist[1]).val();
        var tour_Extra_Charge_Description=$('#'+ctrlist[2]).val();
        var tour_Extra_Charge_Extra_charge=$('#'+ctrlist[3]).val();

        var post={
            'tour_Extra_Charge_Id':tour_Extra_Charge_Id,
            'tour_Extra_Charge_Tour_Enrolment_Id':tour_Extra_Charge_Tour_Enrolment_Id,
            'tour_Extra_Charge_Description':tour_Extra_Charge_Description,
            'tour_Extra_Charge_Extra_charge':tour_Extra_Charge_Extra_charge
        };

        var postList={
            'post':post,
            'ctrList':ctrlist
        }
        return postList;
    }

    function getPostDataSearch(ctrlist){
        var tour_Extra_Charge_Tour_Enrolment_Id=$('#'+ctrlist[0]).val();

        var post={
            'tour_Extra_Charge_Tour_Enrolment_Id':tour_Extra_Charge_Tour_Enrolment_Id
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

<!-- page scripts -->
<script src="<?php echo base_url();?>assets/scripts/master/integrate.js"></script>
<script>$(function () {$('[data-toggle="tooltip"]').tooltip()})</script>

<!--stat loader -->
<?php
$this->load->view('tools/loader',$ctrlData);
?>

</body>
</html>
