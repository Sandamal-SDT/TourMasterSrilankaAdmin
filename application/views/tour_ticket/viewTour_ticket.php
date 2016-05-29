<?php $this->load->view('master/header') ?>

<!-- Jquery Datatables-->
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.responsive.css" rel="stylesheet" type="text/css">

<!--page scripts-->
<link href="<?php echo base_url();?>assets/styles/customer/customer.css" rel="stylesheet" type="text/css">


<?php
    $pageTitle['path']="TMSL > Tour > ";
    $pageTitle['pageTitle']="Tour-Ticket";
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
                                            <input type="text" class="form-control" id="tour_ticketEnS" placeholder="Ticket">
                                        <span class="input-group-btn">
                                            <script>var searchControls=['tour_ticketEnS'];</script>
                                            <button type="button" id="btnSearch" onclick="searchData('<?php echo base_url('index.php/tour_ticket/getSearchGrid') ?>',getPostDataSearch(searchControls),'')" class="btn btn-default" aria-label="Left Align">
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

                <div id="tabView" class="tab-pane fade"></div>

                <div id="tabEdit" class="tab-pane fade"></div>

                <div id="tabAdd" class="tab-pane fade">
                    <h3>Add Tour-Ticket</h3>

                    <div class="row"><div class="col-sm-12 col-md-12"> <br/> </div></div>

                    <form class="form-horizontal">
                        <div class="form-group">
                            <input type="hidden" id="IDi" value="-1">
                            <label for="tour_ticket_Enrolment_Idi" class="col-sm-2 control-label">Tour Enrolment</label>
                            <div class="col-sm-10">
                                <!--<input type="text" class="form-control" id="tour_ticket_Enrolment_Idi" placeholder="Tour Enrolment" >-->
                                <select id="tour_ticket_Enrolment_Idi" class="form-control">
                                    <option value="">Select One</option>
                                    <?php if(isset($enTour_enList)) foreach($enTour_enList as $key=>$value){ echo "<option value='".$key."'>".$value."</option>"; } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tour_Ticket_Ticket_Idi" class="col-sm-2 control-label">Ticket</label>
                            <div class="col-sm-10">
                                <!--<input type="text" class="form-control" id="tour_ticket_Room_Idi" placeholder="room Id">-->
                                <select id="tour_Ticket_Ticket_Idi" class="form-control">
                                    <option value="">Select One</option>
                                    <?php
                                    if(isset($enTicketList))
                                        foreach($enTicketList as $key=>$value){
                                            echo "<option value='".$key."'>".$value."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tour_Ticket_No_Of_Ticketsi" class="col-sm-2 control-label">No Of Tickets</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tour_Ticket_No_Of_Ticketsi" placeholder="No Of Tickets">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tour_Ticket_Descriptioni" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tour_Ticket_Descriptioni" placeholder="Description">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <script>
                                    var saveControls=['IDi','tour_ticket_Enrolment_Idi','tour_Ticket_Ticket_Idi','tour_Ticket_No_Of_Ticketsi','tour_Ticket_Descriptioni'];
                                </script>
                                <button type="button" id="btnInsert" onclick="saveData('<?php echo base_url('index.php/tour_ticket/saveData/1') ?>',getPostData(saveControls),'tour_ticket/loadAjaxGrid')" class="btn btn-primary">
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

        var tour_Ticket_Id=$('#'+ctrlist[0]).val();
        var tour_Ticket_Tour_Enrolment_Id=$('#'+ctrlist[1]).val();
        var tour_Ticket_Ticket_Id=$('#'+ctrlist[2]).val();
        var tour_Ticket_No_Of_Tickets=$('#'+ctrlist[3]).val();
        var tour_Ticket_Description=$('#'+ctrlist[4]).val();

        var post={
            'tour_Ticket_Id':tour_Ticket_Id,
            'tour_Ticket_Tour_Enrolment_Id':tour_Ticket_Tour_Enrolment_Id,
            'tour_Ticket_Ticket_Id':tour_Ticket_Ticket_Id,
            'tour_Ticket_No_Of_Tickets':tour_Ticket_No_Of_Tickets,
            'tour_Ticket_Description':tour_Ticket_Description
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
