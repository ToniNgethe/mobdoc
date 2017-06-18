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
        <title> Account Settings </title>
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
                                                <h3 class="m-b-xs text-black">Account settings</h3> 
                                            </div>
                                        </section>


                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="list-group">
                                                    <a href="<?= base_url('user/profile'); ?>" class="list-group-item">Profile</a>
                                                    <a href="<?= base_url('settings/account'); ?>" class="list-group-item active">Account</a>
                                                    <a href="<?= base_url('settings/mobile'); ?>" class="list-group-item"><span class="hidden-sm hidden-xs">Mobile and Emails</span><span class="hiddev-md hidden-lg">Contact</span></a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">

                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <form method="post" action="<?= base_url('update-password'); ?>">
                                                                    <div class="form-group">
                                                                        <label for="pold">Old password</label>
                                                                        <input type="password" class="form-mine" name="pold" id="pold" placeholder="e.g. *******" required="" value=""/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="pnew">New password</label>
                                                                        <input type="password" class="form-mine" name="pnew" id="pnew" placeholder="e.g. *******" required="" value=""/>
                                                                        <p class="help-block">Must be more than 6 characters </p>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="pconfirm">Confirm password</label>
                                                                        <input type="password" class="form-mine" name="pconfirm" id="pconfirm" placeholder="e.g. *******" required="" value=""/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="submit" value="Update password" class="form-btn"/>
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
                                                                <p class="help-block">Once you delete your account the changes are irreversible</p>
                                                                <form method="post" action="<?= base_url('update-delete'); ?>">
                                                                    <div class="form-group">
                                                                        <input type="submit" value="Delete account" class="form-btn-disable"/>
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