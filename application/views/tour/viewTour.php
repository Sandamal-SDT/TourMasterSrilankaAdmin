<?php $this->load->view('master/header') ?>

<!-- Jquery Datatables-->
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.responsive.css" rel="stylesheet" type="text/css">

<!--page styles-->
<link href="<?php echo base_url();?>assets/styles/customer/customer.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/libs/datepicker/css/datepicker.css" rel="stylesheet" type="text/css">

<?php
    $pageTitle['path']="TMSL > Tours > ";
    $pageTitle['pageTitle']="Days";
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
                                            <button type="button" id="btnSearch" onclick="searchData('<?php echo base_url('index.php/tour/getSearchGrid') ?>',getPostDataSearch(searchControls),'')" class="btn btn-default" aria-label="Left Align">
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

            </div>

        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->


<script>
    function getPostData(ctrlist){

        var tour_id=$('#'+ctrlist[0]).val();
        var tour_Start_Date=$('#'+ctrlist[1]).val();
        var tour_End_Date=$('#'+ctrlist[2]).val();
        var tour_Room_Id=$('#'+ctrlist[3]).val();
        var noOfRooms=$('#'+ctrlist[4]).val();
        var tourEnId =$('#tourEnId').val();

        var post={
            'tour_id':tour_id,
            'tour_Start_Date':tour_Start_Date,
            'tour_Enrolment_Id':tourEnId,
            'tour_End_Date':tour_End_Date,
            'tour_Room_Id':tour_Room_Id,
            'tour_Number_Of_Rooms':noOfRooms
        };

        var postList={
            'post':post,
            'ctrList':ctrlist
        }
        return postList;
    }

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

    //save function for update/insert
    function saveEData(url,postList,refreshUrl){
        setJson(url,refreshGrid,postList.post,refreshUrl);
        clearCtrl(postList.ctrList);
    }

    function refreshGrid(){
        unLoadEditPad();

        var enId=$('#tourEnId').val();
        var url="<?php echo base_url('index.php/tour/refreshGrid') ?>"+"/"+enId;
        getJson(url,reloadGrid,null,null);
    }

    function reloadGrid(data){
        $( "#gridContainer").html(data);
    }

    function filterSelection(urlF,postData,targetSelection){
        var post={
            'key':postData
        };
        getJson(urlF,loadDropDown,post,targetSelection);
    }

    function loadDropDown(data,targetSelection){
        $("#"+targetSelection).html(data);
    }

    function viewDayDetails(data){
        //alert(data);
        $( "#editPad").html(data);
        loadEditPad();
    }

    function loadEditPad(){
        $('html, body').animate({
            scrollTop: $("#editPadHeading").offset().top-50
        }, 500);
        $( "#editPad" ).addClass( "fadeInEf");
        $( "#editPad" ).removeClass( "fadeOutEf");
    }

    function unLoadEditPad(){
        $( "#editPad" ).addClass( "fadeOutEf");
        $( "#editPad" ).removeClass( "fadeInEf");
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
<script>$('#tour_Start_Datei,#tour_End_Datei').datepicker({
        format:'yyyy-mm-dd'
    });
</script>

<!--stat loader -->
<?php
$this->load->view('tools/loader',$ctrlData);
?>

</body>
</html>
