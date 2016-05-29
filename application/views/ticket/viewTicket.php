<?php $this->load->view('master/header') ?>

<!-- Jquery Datatables-->
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.responsive.css" rel="stylesheet" type="text/css">

<!--page scripts-->
<link href="<?php echo base_url();?>assets/styles/customer/customer.css" rel="stylesheet" type="text/css">


<?php
    $pageTitle['path']="TMSL > Charges > ";
    $pageTitle['pageTitle']="Tickets";
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
                                        <input type="text" class="form-control" id="ticketS" placeholder="Ticket Name">
                                        <span class="input-group-btn">
                                            <script>var searchControls=['ticketS'];</script>
                                            <button type="button" id="btnSearch" onclick="searchData('<?php echo base_url('index.php/ticket/getSearchGrid') ?>',getPostDataSearch(searchControls),'')" class="btn btn-default" aria-label="Left Align">
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
                    <h3>Add Ticket</h3>
                    <br/>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <input type="hidden" id="IDi" value="-1">
                            <label for="ticket_Namei" class="col-sm-2 control-label">Ticket</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="ticket_Namei" placeholder="Ticket">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ticket_Descriptioni" class="col-sm-2 control-label">Ticket Description</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="ticket_Descriptioni" placeholder="Ticket Description">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ticket_Pricei" class="col-sm-2 control-label">Ticket Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="ticket_Pricei" placeholder="Ticket Price">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <script>var saveControls=['IDi','ticket_Namei','ticket_Descriptioni','ticket_Pricei'];</script>
                                <button type="button" id="btnInsert" onclick="saveData('<?php echo base_url('index.php/ticket/saveData/1') ?>',getPostData(saveControls),'ticket/loadAjaxGrid')" class="btn btn-primary">
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

        var ticket_Id=$('#'+ctrlist[0]).val();
        var ticket_Name=$('#'+ctrlist[1]).val();
        var ticket_Description=$('#'+ctrlist[2]).val();
        var ticket_Price=$('#'+ctrlist[3]).val();

        var post={
            'ticket_Id':ticket_Id,
            'ticket_Name':ticket_Name,
            'ticket_Description':ticket_Description,
            'ticket_Price':ticket_Price
        };

        var postList={
            'post':post,
            'ctrList':ctrlist
        }
        return postList;
    }

    function getPostDataSearch(ctrlist){
        var ticket_Name=$('#'+ctrlist[0]).val();

        var post={
            'ticket_Name':ticket_Name
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
