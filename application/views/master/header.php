<?php
    if( $this->session->userdata('isLoggedIn') ) {
        } else {
            redirect('/login');
        }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="cHiN">

    <title>TMSL Admin Module</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url();?>assets/libs/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/styles/master/master.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>assets/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

