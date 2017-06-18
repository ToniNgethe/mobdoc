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
        <title> Your Appointments </title>
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="<?= base_url("admn/css/admin.css"); ?>"/>
        <link href="<?= base_url("admn/js/datatables/jquery.dataTables.min.css"); ?>" rel="stylesheet"/>
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
                                                <h3 class="m-b-xs text-black">My appointments on MobDoc</h3> 
                                            </div>
                                        </section>

                                        <div class="row">
                                            <div class="col-md-12">

                                                <section class="panel panel-default">
                                                    <div class="panel-heading"> All my appointments </div>
                                                    <div class="table-responsive">
                                                        <table id="tblAppointments" class="display" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Number</th>
                                                                    <th>Location</th>
                                                                    <th>Booked on</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody> 
                                                                <?php
                                                                $all_appointments = $this->crudmod->get_where('appointment', 'patientId', $user_details['userId']);
                                                                foreach ($all_appointments as $all_appointments_row):
                                                                    $aid = $all_appointments_row->appointmentId;
                                                                    $aName = $all_appointments_row->patientName;
                                                                    $aDate = $all_appointments_row->appointmentBookTime;
                                                                    $aMobile = $all_appointments_row->patientMobile;
                                                                    $aLocation = $all_appointments_row->patientLocation;
                                                                    if ($all_appointments_row->appointmentStatus == 1) {
                                                                        $aStatus = "Waiting confirmation";
                                                                    } else if ($all_appointments_row->appointmentStatus == 2) {
                                                                        $aStatus = "Confirmed";
                                                                    } else {
                                                                        $aStatus = "Cleared or canceled";
                                                                    }
                                                                    ?>
                                                                    <tr class="clickable-row" data-href="<?= base_url('appointment/detail/' . $aid); ?>">
                                                                        <td><?= $aName; ?></td>
                                                                        <td><?= $aMobile; ?></td>
                                                                        <td><?= $aLocation; ?></td>
                                                                        <td><?= $aDate; ?></td>
                                                                        <td><?= $aStatus; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                endforeach;
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <footer class="panel-footer">
                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($this->crudmod->get_where_two_join('user', 'mystatus', 0, 'user_group', 3, 'specialist', 'userId', 'userId')); ?> records</div>
                                                        </div>
                                                    </footer>
                                                </section>
                                            </div>
                                        </div>



                                    </section>
                                </section>
                            </section>


                        </section>
                    </section>


                </section>
            </section>
        </section>
        <!-- Bootstrap -->
        <!-- App -->
        <script src="<?= base_url("admn/js/admin.js"); ?>"></script>
        <script src="<?= base_url("admn/js/app.plugin.js"); ?>"></script>


        <!-- Datatables-->
        <script src="<?= base_url("admn/js/datatables/jquery-1.12.4.js"); ?>"></script>
        <script src="<?= base_url("admn/js/datatables/jquery.dataTables.min.js"); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#tblAppointments').DataTable();
            });
        </script>


        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(".clickable-row").click(function () {
                    window.location = $(this).data("href");
                });
            });
        </script>

    </body>
</html>