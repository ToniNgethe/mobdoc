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
        <title>Mobdoc | Admin:Specialists</title>
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
                                        <h3 class="m-b-xs text-black">Specialists</h3> 
                                    </div>
                                </section>


                                <div class="row">
                                    <div class="col-md-6">

                                        <!-- All inactive/new specialists -->
                                        <section class="panel panel-default">
                                            <div class="panel-heading"> All inactive/new specialists </div>
                                            <div class="table-responsive">
                                                <?php
                                                $inactive_specialist = $this->crudmod->get_where_two_join('user', 'mystatus', 0, 'user_group', 3, 'specialist', 'userId', 'userId');

                                                if (count($inactive_specialist) > 0) {
                                                    ?>

                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Registration No.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($inactive_specialist as $inactive_specialist_row):
                                                                $iid = $inactive_specialist_row->userId;
                                                                $iname = $inactive_specialist_row->fullname;
                                                                $iemail = $inactive_specialist_row->email;
                                                                $iregno = $inactive_specialist_row->registrationNumber;
                                                                $ispecialty = $inactive_specialist_row->specialtyId;

                                                                $cur_specialty = $this->crudmod->get_record('specialty', 'specialtyId', $ispecialty);
                                                                $iSpecialtyName = $cur_specialty['sName'];
                                                                ?>
                                                                <tr class="clickable-row" data-href="<?= base_url('admin/user?ref=' . $iid); ?>">
                                                                    <td><?= $iname; ?></td>
                                                                    <td><?= $iregno; ?></td>
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
                                                    <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($this->crudmod->get_where_two_join('user', 'mystatus', 0, 'user_group', 3, 'specialist', 'userId', 'userId')); ?> records</div>
                                                </div>
                                            </footer>
                                        </section>
                                    </div>
                                    <div class="col-md-6">

                                        <!-- All active specialists -->
                                        <section class="panel panel-default">
                                            <div class="panel-heading"> All active specialists </div>
                                            <div class="table-responsive">

                                                <?php
                                                $active_specialist = $this->crudmod->get_where_two_join('user', 'mystatus', 1, 'user_group', 3, 'specialist', 'userId', 'userId');

                                                if (count($active_specialist) > 0) {
                                                    ?>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Registration No.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($active_specialist as $active_specialist_row):
                                                                $aid = $active_specialist_row->userId;
                                                                $aname = $active_specialist_row->fullname;
                                                                $aemail = $active_specialist_row->email;
                                                                $aregno = $active_specialist_row->registrationNumber;
                                                                $aspecialty = $active_specialist_row->specialtyId;

                                                                $cura_specialty = $this->crudmod->get_record('specialty', 'specialtyId', $aspecialty);
                                                                $aSpecialtyName = $cura_specialty['sName'];
                                                                ?>
                                                                <tr class="clickable-row" data-href="<?= base_url('admin/user?ref=' . $aid); ?>">
                                                                    <td><?= $aname; ?></td>
                                                                    <td><?= $aregno; ?></td>
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
                                                    <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($this->crudmod->get_where_two_join('user', 'mystatus', 1, 'user_group', 3, 'specialist', 'userId', 'userId')); ?> records</div>
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