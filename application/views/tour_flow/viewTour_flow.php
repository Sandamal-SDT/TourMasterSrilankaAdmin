<?php $this->load->view('master/header') ?>

<!-- Jquery Datatables-->
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/libs/DataTables-1.10.9/css/dataTables.responsive.css" rel="stylesheet" type="text/css">

<!--page scripts-->
<link href="<?php echo base_url();?>assets/styles/customer/customer.css" rel="stylesheet" type="text/css">


<?php
    $pageTitle['path']="TMSL > Reports > ";
    $pageTitle['pageTitle']="Calc";
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
                                        <input type="text" class="form-control" id="customerS" placeholder="Customer Name">
                                        <span class="input-group-btn">
                                            <script>var searchControls=['customerS'];</script>
                                            <button type="button" id="btnSearch" onclick="searchData('<?php echo base_url('index.php/tour_flow/getSearchGrid') ?>',getPostDataSearch(searchControls),'')" class="btn btn-default">
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



<?php $this->load->view('master/footer') ?>

<!-- Jquery Datatable scripts-->
<script src="<?php echo base_url();?>assets/libs/DataTables-1.10.9/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/DataTables-1.10.9/js/dataTables.bootstrap.min.js"></script>

<!-- page scripts -->
<script src="<?php echo base_url();?>assets/scripts/master/integrate.js"></script>
<script>$(function () {$('[data-toggle="tooltip"]').tooltip()})</script>

<script>
    function getPostData(ctrlist){
        var tour_en_Id=$('#'+ctrlist[0]).val();
        var tour_en_customer_Id=$('#'+ctrlist[1]).val();
        var tour_Enrolment_Driver_Id=$('#'+ctrlist[2]).val();

        var post={
            'tour_en_Id':tour_en_Id,
            'tour_en_customer_Id':tour_en_customer_Id,
            'tour_Enrolment_Driver_Id':tour_Enrolment_Driver_Id
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


<!-- report scripts-->

<script src="<?php echo base_url();?>assets/libs/jsPdf-1.0/jspdf.min.js"></script>
<script src="<?php echo base_url();?>assets/scripts/reportPdf.js"></script>


<script>

    function resizeSVG(){
        setTimeout(function() {
            $('#tests').attr('width',$('#tabView').width());
            $('#tests').attr('height',$('#innerContent').height()+($('#innerContent').height()*0.1));//height computing error
        }, 1000)//this timeout is for rendering
    }

    //getting report view
    function getViewConfig(content){
        $('#tabView').html(content);
        $('#tabViewLink').css("display","block");
        $('.nav-tabs li:eq(1) a').tab('show');
        resizeSVG();
    }

    function convert2Pdf(){
        //$('#tests').attr('width',$(window).width()*0.98);
        //$('#tests').attr('height',$('#innerContent').height()+5);
        //alert($('#tests').height());
        $('#im').width($('#tests').width());
        $('#im').height($('#tests').height());

        convertToPDF('tests','im','TourCal');
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if(charCode == 46) //decimal point
            return true;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function calculateTot(tdElement){
        var row= tdElement.closest('tr');
        var noOfPersons = parseInt($('#noOfPersons').val());

        //current person per details
        var currentTotSubProfitCell=$('#totalSubProfit');
        var currentPricePerPersonCell=$('#pricePerPerson');
        var currentProfitPerPersonCell=$('#profitPerPerson');

        var currentTotSubProfit = convert2float(currentTotSubProfitCell.val());


        //hotel calculations (hotel rows)
        if(row.children('td').length==10){
            var cellEdit=row.children('td').eq(7).children('input');
            var dayPriceCell=row.children('td').eq(9);
            var dayProfitCell=row.children('td').eq(8);
            var cellSubTot=$('#subTot');
            var cellTot=$('#totalCost');
            var cellTotProfit=$('#Profit');

            var subProfitPercentage=convert2float(cellEdit.val());
            var dayPrice=convert2float(dayPriceCell.html());
            var tot=convert2float(cellTot.html());
            var currentSubTotal=convert2float(cellSubTot.html());
            var currentTotProfit=convert2float(cellTotProfit.html());
            var dayProfit=convert2float(dayProfitCell.html());


            var numberOfDays=parseInt(row.children('td').eq(2).html());
            var numberOfRooms=parseInt(row.children('td').eq(6).html());
            var roomPrice=parseInt(row.children('td').eq(5).html());

            var newDayProfit=numberOfDays*numberOfRooms*((roomPrice*subProfitPercentage)/100);
            var newDayPrice=numberOfDays*numberOfRooms*(roomPrice+((roomPrice*subProfitPercentage)/100));


            var diffDayProfit=newDayProfit-dayProfit;
            var diffDayPrice=newDayPrice-dayPrice;

            //total sub profit
            currentTotSubProfit += diffDayProfit;

            //console.log(diffDayProfit+" : "+diffDayPrice);

            dayPriceCell.html(convert2Currency(dayPrice+diffDayPrice));
            cellTot.html(convert2Currency(tot+diffDayPrice));
            cellSubTot.html(convert2Currency(currentSubTotal+diffDayPrice));
            dayProfitCell.html(convert2Currency(dayProfit+diffDayProfit));
            cellTotProfit.html(convert2Currency(currentTotProfit+diffDayProfit));

            //total sub profit
            currentTotSubProfitCell.val(convert2Currency(currentTotSubProfit));
            $(currentTotSubProfitCell).attr('value',convert2Currency(currentTotSubProfit));

            highlightCell([dayPriceCell,cellTot,cellSubTot,cellTotProfit,dayProfitCell,currentTotSubProfitCell]);
        }
        //driver rows
        else if(row.children('td').length==6){
            var cellEdit=row.children('td').eq(3).children('input');
            var dayPriceCell=row.children('td').eq(5);
            var cellSubTot=$('#subDriverTot');
            var cellTot=$('#totalCost');

            var subProfitPercentage=convert2float(cellEdit.val());
            var dayPrice=convert2float(dayPriceCell.html());
            var tot=convert2float(cellTot.html());
            var currentSubTotal=convert2float(cellSubTot.html());

            var numberOfDays=parseInt(row.children('td').eq(1).children('input')[0].value);
            var driverPrice=convert2float(row.children('td').eq(2).children('input')[0].value);

            var newDayProfit=numberOfDays*((driverPrice*subProfitPercentage)/100);
            var newDayPrice=numberOfDays*(driverPrice+((driverPrice*subProfitPercentage)/100));


            var diffDayPrice=newDayPrice-dayPrice;

            //console.log(diffDayProfit+" : "+diffDayPrice);
            //total sub profit
            currentTotSubProfit += diffDayPrice;

            dayPriceCell.html(convert2Currency(dayPrice+diffDayPrice));
            cellTot.html(convert2Currency(tot+diffDayPrice));
            cellSubTot.html(convert2Currency(currentSubTotal+diffDayPrice));
            //total sub profit
            currentTotSubProfitCell.val(convert2Currency(currentTotSubProfit));
            $(currentTotSubProfitCell).attr('value',convert2Currency(currentTotSubProfit));

            highlightCell([dayPriceCell,cellTot,cellSubTot,currentTotSubProfitCell]);
        }
        //extra charges
        else if(row.children('td').length==5){
            var cellEdit=row.children('td').eq(2).children('input');
            var dayPriceCell=row.children('td').eq(4);
            var cellSubTot=$('#subExtraTot');
            var cellTot=$('#totalCost');

            var subProfitPercentage=convert2float(cellEdit.val());
            var dayPrice=convert2float(dayPriceCell.html());
            var tot=convert2float(cellTot.html());
            var currentSubTotal=convert2float(cellSubTot.html());

            var extraPrice=parseInt(row.children('td').eq(1).children('input')[0].value);

            var newDayPrice=extraPrice+((extraPrice*subProfitPercentage)/100);

            var diffDayPrice=newDayPrice-dayPrice;

            //console.log(diffDayProfit+" : "+diffDayPrice);
            //total sub profit
            currentTotSubProfit += diffDayPrice;

            dayPriceCell.html(convert2Currency(dayPrice+diffDayPrice));
            cellTot.html(convert2Currency(tot+diffDayPrice));
            cellSubTot.html(convert2Currency(currentSubTotal+diffDayPrice));
            //total sub profit
            currentTotSubProfitCell.val(convert2Currency(currentTotSubProfit));
            $(currentTotSubProfitCell).attr('value',convert2Currency(currentTotSubProfit));

            highlightCell([dayPriceCell,cellTot,cellSubTot,currentTotSubProfitCell]);
        }

        //per person calculations
        var total = convert2float($('#totalCost').html());
        var totSubProfit = convert2float(currentTotSubProfitCell.val());
        var newTotPerPerson=total/noOfPersons;
        var newProfitPerPerson = totSubProfit/noOfPersons;

        currentPricePerPersonCell.val(convert2Currency(newTotPerPerson));
        $(currentPricePerPersonCell).attr('value',convert2Currency(newTotPerPerson));
        currentProfitPerPersonCell.val(convert2Currency(newProfitPerPerson));
        $(currentProfitPerPersonCell).attr('value',convert2Currency(newProfitPerPerson));

        highlightCell([currentPricePerPersonCell,currentProfitPerPersonCell]);

    }

    function convert2float(stri){
        //return isNaN(stri)?0:parseInt(stri);
        if(isNaN(parseFloat(stri)))
            return 0;
        else
            return parseFloat(stri);
    }

    function convert2Currency(num){
        return parseFloat(num).toFixed(2);
    }

    function highlightCell(cellArray){

        $(cellArray).each(function() {
            var cell=this;
            cell.addClass("highLight");
            setTimeout(function(){cell.removeClass("highLight"); }, 750);
        });

    }

</script>

<!--stat loader -->
<?php
$this->load->view('tools/loader',$ctrlData);
?>

</body>
</html>
