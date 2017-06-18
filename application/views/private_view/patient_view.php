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
        <title>Mobdoc | Admin:Patients</title>
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
                                <section class="row m-b-md">
                                    <div class="col-sm-6">
                                        <h3 class="m-b-xs text-black">Patients</h3> 
                                    </div>
                                </section>


                                <div class="row">
                                    <div class="col-md-6">

                                        <!-- All inactive/new specialists -->
                                        <section class="panel panel-default">
                                            <div class="panel-heading"> All inactive patients </div>
                                            <div class="table-responsive">
                                                <?php
                                                $inactive_patient = $this->crudmod->get_where_two('user', 'mystatus', 0, 'user_group', 2);

                                                if (count($inactive_patient) > 0) {
                                                    ?>

                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Email address</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($inactive_patient as $inactive_patient_row):
                                                                $iid = $inactive_patient_row->userId;
                                                                $iname = $inactive_patient_row->fullname;
                                                                $iemail = $inactive_patient_row->email;
                                                                ?>
                                                                <tr class="clickable-row" data-href="<?= base_url('admin/user?ref=' . $iid); ?>">
                                                                    <td><?= $iname; ?></td>
                                                                    <td><?= $iemail; ?></td>
                                                                </tr>
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <?php
                                                } else {
                                                    
                                                }
                                                ?>
                                            </div>
                                            <footer class="panel-footer">
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($this->crudmod->get_where_two('user', 'mystatus', 0, 'user_group', 2)); ?> records</div>
                                                </div>
                                            </footer>
                                        </section>
                                    </div>
                                    <div class="col-md-6">

                                        <!-- All active specialists -->
                                        <section class="panel panel-default">
                                            <div class="panel-heading"> All active patients </div>
                                            <div class="table-responsive">

                                                <?php
                                                $active_patient = $this->crudmod->get_where_two('user', 'mystatus', 1, 'user_group', 2);

                                                if (count($active_patient) > 0) {
                                                    ?>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Email address</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($active_patient as $active_patient_row):
                                                                $aid = $active_patient_row->userId;
                                                                $aname = $active_patient_row->fullname;
                                                                $aemail = $active_patient_row->email;
                                                                ?>
                                                                <tr class="clickable-row" data-href="<?= base_url('admin/user?ref=' . $aid); ?>">
                                                                    <td><?= $aname; ?></td>
                                                                    <td><?= $aemail; ?></td>
                                                                </tr>
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <?php
                                                }else {
                                                    
                                                }
                                                ?>
                                            </div>
                                            <footer class="panel-footer">
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($this->crudmod->get_where_two('user', 'mystatus', 1, 'user_group', 2)); ?> records</div>
                                                </div>
                                            </footer>
                                        </section>
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
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(".clickable-row").click(function () {
                    window.location = $(this).data("href");
                });
            });
        </script>

    </body>

</html>