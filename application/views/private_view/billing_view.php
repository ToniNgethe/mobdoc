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
        <title>Mobdoc | Billing</title>
        <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="<?= base_url("admn/css/admin.css"); ?>"/>
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
                                        <h3 class="m-b-xs text-black">Billing</h3> 
                                    </div>
                                </section>



                                <div class="pad-content">
                                    <div class="row">
                                    <div class="col-md-10" id="rev">

                                        <div class="row">
                                            <div class="col-md-8">
                                                <p class="help-block">Do you charge <strong>any FEE</strong> when a patient reserves an appointment with you?</p>
                                                <p class="help-block">If so, fill in the billing details in the table below</p>

                                                
                                                <?php if (null != validation_errors() || null != $this->session->flashdata('error') || null != $this->session->flashdata('success')) { ?>
                                                    <div class="alert alert-<?= null == $this->session->flashdata('success') ? 'warning' : 'success' ?>">
                                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                                        <?= validation_errors() ?>
                                                        <?= $this->session->flashdata('error') ?>
                                                        <?= $this->session->flashdata('success') ?>
                                                    </div>
                                                <?php }
                                                ?>
                                                
                                                
                                                <?php
                                                if (count($billing_details) > 0) {
                                                    ?>
                                                    <form method="post" action="<?= base_url('update-billing'); ?>">
                                                        <div class="form-group">
                                                            <label for="billAmount">Amount charged (in KSh)</label>
                                                            <input type="number" name="billAmount" id="billAmount" value="<?= $billing_details['billAmount']; ?>" required="true" class="form-control" placeholder="Minimum of 1"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="billInfo">Additional info</label>
                                                            <textarea name="billInfo" id="billInfo" required="true" value="<?= $billing_details['billInfo']; ?>" class="form-control" placeholder="Additional information .i.e. conditions of ppayment"><?= $billing_details['billInfo']; ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="billWhen">Can patients pay upon visiting?</label>

                                                            <?php
                                                            if ($billing_details['payLater'] == 1) {
                                                                ?>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="billWhen" id="billWhen" checked="true" value="1"> Yes
                                                                    </label>
                                                                </div>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="billWhen" id="billWhen" value="0">  No
                                                                    </label>
                                                                </div>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="billWhen" id="billWhen" value="1"> Yes
                                                                    </label>
                                                                </div>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="billWhen" id="billWhen" checked="true" value="0">  No
                                                                    </label>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <input value="Update billing" class="btn btn-s-md btn-success" type="submit">
                                                        </div>
                                                    </form>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <form method="post" action="<?= base_url('save-billing'); ?>">
                                                        <div class="form-group">
                                                            <label for="billAmount">Amount charged (in KSh)</label>
                                                            <input type="number" name="billAmount" id="billAmount" required="true" class="form-control" placeholder="Minimum of 1"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="billInfo">Additional info</label>
                                                            <textarea name="billInfo" id="billInfo" required="true" class="form-control" placeholder="Additional information .i.e. conditions of ppayment"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="billWhen">Can patients pay upon visiting?</label>
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="billWhen" id="billWhen" value="1"> Yes
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="billWhen" id="billWhen" value="0">  No
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <input value="Save billing" class="btn btn-s-md btn-primary btn-rounded" type="submit">
                                                        </div>
                                                    </form>
                                                    <?php
                                                }
                                                ?>                                                


                                            </div>

                                            <div class="col-md-4">
                                                <section class="panel b-a">
                                                    <div class="panel-heading b-b"> 
                                                        <a class="font-bold">Current billing info</a>
                                                    </div>
                                                    <div class="panel-body">
                                                        <?php
                                                        if (count($billing_details) > 0) {
                                                            ?>
                                                            <a class="block h4 font-bold m-b text-black">Amount- KSh. <?= $billing_details['billAmount']; ?></a>
                                                            <div class="r b bg-info-ltest wrapper m-b"><?= $billing_details['billInfo']; ?></div>
                                                            <p class="text-sm">
                                                                <?php
                                                                if ($billing_details['payLater'] == 1) {
                                                                    print_r("Patients can pay upon visiting");
                                                                } else {
                                                                    print_r("Patients must pay before visiting");
                                                                }
                                                                ?>
                                                            </p>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <div class="r b bg-danger-ltest wrapper m-b">You have not added any billing information.</div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                    if (count($billing_details) > 0) {
                                                        ?>
                                                        <div class="clearfix panel-footer">
                                                            <small class="text-muted pull-right"><?= $billing_details['createdOn']; ?></small>
                                                            <div class="clear"> 
                                                                <small class="block text-muted">Created on </small>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </section>
                                            </div>
                                        </div>

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



                                    </div>
                                </div>
                                </div>

                            </section>
                        </section>
                    </section>

                </section>
                <a href="<?= current_url(); ?>#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        
                </section>
            </section>
        </section>
        <!-- Bootstrap -->
        <!-- App -->
        <script src="<?= base_url("admn/js/admin.js"); ?>"></script>
        <script src="<?= base_url("admn/js/app.plugin.js"); ?>"></script>
    </body>

</html>