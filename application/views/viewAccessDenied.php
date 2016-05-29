<?php $this->load->view('master/header') ?>




<!--page styles-->

<link href="<?php echo base_url();?>assets/styles/customer/customer.css" rel="stylesheet" type="text/css">

<?php

$pageTitle['path']="TMSL > ";

$pageTitle['pageTitle']="Access Denied !";

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

            <div class="col-sm-12 col-md-12">
                <h2 align="center" style="color: red"> Access Denied !</h2>
                <br/>
            </div>

        </div>

    </div>

    <!-- /.container-fluid -->

</div>

<!-- /#page-wrapper -->





<script>


</script>





<?php $this->load->view('master/footer') ?>



<!-- Jquery Datatable scripts-->

<script src="<?php echo base_url();?>assets/libs/DataTables-1.10.9/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url();?>assets/libs/DataTables-1.10.9/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/datepicker/js/bootstrap-datepicker.js"></script>


<!-- page scripts -->

<script src="<?php echo base_url();?>assets/scripts/master/integrate.js"></script>


</body>

</html>

