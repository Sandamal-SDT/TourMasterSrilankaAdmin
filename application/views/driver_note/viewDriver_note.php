<?php $this->load->view('master/header') ?>

<!-- Jquery Datatables-->
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.responsive.css" rel="stylesheet" type="text/css">

<!--page styles-->
<link href="<?php echo base_url();?>assets/styles/customer/customer.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/libs/datepicker/css/datepicker.css" rel="stylesheet" type="text/css">

<?php
    $pageTitle['path']="TMSL > Reports > ";
    $pageTitle['pageTitle']="Driver Note";
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
                                            <input type="text" class="form-control" id="tourEnS" placeholder="Tour Enrolment">
                                        <span class="input-group-btn">
                                            <script>var searchControls=['tourEnS'];</script>
                                            <button type="button" id="btnSearch" onclick="searchData('<?php echo base_url('index.php/driver_note/getSearchGrid') ?>',getPostDataSearch(searchControls),'')" class="btn btn-default" aria-label="Left Align">
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

            </div>

        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->


<script>

    function getPostDataSearch(ctrlist){
        var tour_Enrolment_Id=$('#'+ctrlist[0]).val();

        var post={
            'tour_Enrolment_Id':tour_Enrolment_Id
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
<script>$(function () {$('[data-toggle="tooltip"]').tooltip()})</script>

<!-- report scripts-->
<script src="<?php echo base_url();?>assets/libs/jsPdf-1.0/jspdf.min.js"></script>
<script src="<?php echo base_url();?>assets/scripts/reportPdf.js"></script>

<script>

    //getting report view
    function getViewConfig(content){
        $('#tabView').html(content);
        $('#tabViewLink').css("display","block");
        $('.nav-tabs li:eq(1) a').tab('show');
    }

    function convert2Pdf(){
        var innerContent = $('#dynamicContent').html();
        $('#reportContent').html(innerContent);

        $('#im').width($('#tests').width());
        $('#im').height($('#tests').height());

        convertToPDF('tests','im','DriverNote');
    }

    function preview(){
        var innerContent = $('#dynamicContent').html();
        $('#reportContent').html(innerContent);
        var html=$('#dynamicReport').html();
        var strWindowFeatures = "menubar=no,location=no,resizable=no,scrollbars=yes,status=yes,height=1550,width=1120";
        var w = window.open("","print",strWindowFeatures);
        $(w.document.body).html(html);
        w.print();
    }

</script>


<!--stat loader -->
<?php
$this->load->view('tools/loader',$ctrlData);
?>

</body>
</html>
