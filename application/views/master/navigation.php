</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 col-sm-3 navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo base_url() ?>">
                            <img src="<?php echo base_url();?>assets/images/logo.png" alt="Tour Master Sri Lanka Logo" class="img-responsive" style="margin-left: auto;margin-right: auto; height: 50px;">
                        </a>
                    </div>

                    <div class="col-md-4 col-xs-5 col-sm-4">
                        <ol class="pagePath nav navbar-nav">
                            <li><h3><small><i><?php echo $path?></i></small><?php echo $pageTitle?></h3></li>
                        </ol>
                    </div>

                    <div class="col-md-3 col-xs-4 col-sm-2">
                        <div id="loaderWrapper" class="" role="search">
                            <div style="float:left">
                                <img id="loaderImg" src="<?php echo base_url() ?>assets/images/loader.gif">
                            </div>
                            <div id="loaderContent"  class="alert alert-success" role="alert">
                                Loading...
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3 col-xs-3 col-sm-3">
                        <ul class="nav navbar-nav navbar-top-links navbar-right">

                            <li>
                                <h3> <small>Welcome </small><?php echo ucfirst($this->session->userdata('UserName')); ?></h3>
                            </li>
                            <!-- /.dropdown -->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li> <a href="<?php echo base_url() ?>index.php/user"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                                    <li> <a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a> </li>
                                    <li class="divider"> </li>
                                    <li> <a href="<?php echo base_url() ?>/index.php/login/logout_user"><i class="fa fa-sign-out fa-fw"></i> Logout</a> </li>
                                </ul>
                                <!-- /.dropdown-user -->
                            </li>
                            <!-- /.dropdown -->
                        </ul>
                        <!-- /.navbar-top-links -->
                    </div>

                </div>
            </div>

            <div class="navbar-default sidebar" role="navigation">

                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <!--div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                            </div-->
                            <!-- /input-group -->
                        </li>
                        <li class="active">
                            <a href="<?php echo base_url() ?>index.php/dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>index.php/customer"><i class="fa fa-user-plus fa-fw"></i> Customer</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-building fa-fw"></i> Hotel<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>index.php/hotel">Hotel</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>index.php/room">Room</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-usd"></i> Charges<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>index.php/driver">Driver</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>index.php/extra_charges">Extra Charges</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>index.php/ticket">Tickets</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-road fa-fw"></i> Tours<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>index.php/tour_en">Tour Enrolment</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>index.php/tour">Days</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>index.php/tour_ticket">Tour-Ticket</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>index.php/tour_flow">Calc</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>index.php/driver_note">Driver Note</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>index.php/customer_invoice">Customer Invoice</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>index.php/hotel_bank">Hotel Bank Note</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>

        </nav>