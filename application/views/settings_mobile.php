<?php
$session_data = $this->session->userdata('user_sess');
$userGroup = $session_data['usergroup'];
$userId = $session_data['userId'];
$my_details = $this->crudmod->get_record('user', 'userId', $userId);
?>
<!DOCTYPE html>
<html lang="en" class="app">

    <head>
        <meta charset="utf-8" />
        <title> Mobile and Email Settings </title>
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url("admn/css/admin.css"); ?>"/>
        <!--[if lt IE 9]> 
        <script src="js/ie/html5shiv.js"></script> 
        <script src="js/ie/respond.min.js"></script> 
        <script src="js/ie/excanvas.js"></script> 
        <![endif]-->
    </head>

    <body class="">
        <section class="vbox">
            <!-- .header -->
            <?php $this->load->view('private_view/header_view'); ?>
            <!-- /.header -->
            <section>
                <section class="hbox stretch">


                    <!-- .aside -->
                    <?php $this->load->view('private_view/aside_left'); ?>
                    <!-- /.aside -->




                    <section id="content">
                        <section class="hbox stretch">
                            <section>
                                <section class="vbox">
                                    <section class="scrollable wrapper">
                                        <section class="row m-b-md header-banner">
                                            <div class="col-sm-6">
                                                <h3 class="m-b-xs text-black">Mobile and Email Settings</h3> 
                                            </div>
                                        </section>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="list-group">
                                                    <a href="<?= base_url('user/profile'); ?>" class="list-group-item">Profile</a>
                                                    <a href="<?= base_url('settings/account'); ?>" class="list-group-item">Account</a>
                                                    <a href="<?= base_url('settings/mobile'); ?>" class="list-group-item active"><span class="hidden-sm hidden-xs">Mobile and Emails</span><span class="hiddev-md hidden-lg">Contact</span></a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">


                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <p class="help-block">Your <strong>email address</strong> will be used for account-related notifications</p>
                                                                <p class="help-block">You can't change it for now</p>
                                                                <form>
                                                                    <div class="form-group">
                                                                        <label for="pemail" class="hidden">Email address</label>
                                                                        <input disabled="" type="email" class="form-mine" name="pemail" id="pemail" placeholder="e.g. joedoe@gmail.com" required="" value="<?= $user_details['email'] ?>"/>
                                                                    </div>
                                                                    <div class="form-group hidden">
                                                                        <input type="submit" value="Update email" class="form-btn"/>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <br/>


                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <p class="help-block">Your <strong>mobile number</strong> will help in improving your connection with clients</p>
                                                                <form method="post" action="<?= base_url('update-phone'); ?>">
                                                                    <div class="form-group">
                                                                        <label for="pmobile">Mobile number</label>
                                                                        <input type="tel" class="form-mine" name="pmobile" id="pmobile" placeholder="e.g. 07*******" required="" value="<?= $user_details['myphone']; ?>"/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="submit" value="Update mobile" class="form-btn"/>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>



                                    </section>
                                </section>
                            </section>


                        </section>
                    </section>



                    <div class="<?= $show_error; ?>">
                        <div class="alert-danger navbar navbar-fixed-bottom">
                            <div class="container">
                                <div class="my-error">
                                    <strong>Oops! Check the error(s) below :-</strong>
                                    <?= $error; ?>
                                </div>
                            </div>
                        </div>
                    </div>


                </section>
            </section>
        </section>
        <!-- Bootstrap -->
        <!-- App -->
        <script src="<?= base_url("admn/js/admin.js"); ?>"></script>
        <script src="<?= base_url("admn/js/app.plugin.js"); ?>"></script>
        <script src="<?= base_url('khyp/js/custom.min.js'); ?>"></script>

    </body>
</html>