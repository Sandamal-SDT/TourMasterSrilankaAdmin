<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TMSL - Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/styles/master/master.css" rel="stylesheet">

</head>
<body>

    <div class="container">

        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="">Tourmaster Lanka International (Pvt) Ltd.<br/><small>Tour Enrolment System</small></h1>
                <img src="<?php echo base_url();?>assets/images/logo.png" alt="Tour Master Sri Lanka Logo" class="img-responsive" style="margin-left: auto;margin-right: auto; height: 80px;">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open('login/login_user') ?>
                        <form>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="UserName" name="userName" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" name="submit" class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <address>
                    <strong>Tourmaster Lanka International  (Pvt) Ltd.</strong><br/>
                    343/2, School Lane,<br/>
                    Negombo. Sri Lanka.<br/>
                    <abbr title="Phone"><span class="fa fa-phone" aria-hidden="true"></span>:</abbr> (+94)77 433 7843<br/>
                    <abbr title="e-mail"><span class="fa fa-envelope-o" aria-hidden="true"></span>:</abbr> info@tourmastersrilanka.com<br/>
                    <abbr title="Website"><span class="fa fa-globe" aria-hidden="true"></span>:</abbr> <a href="http://tourmastersrilanka.com/" target="_blank">www.tourmastersrilanka.com</a>
                </address>
            </div>
        </div>

    </div>
    
</body>

</html>
