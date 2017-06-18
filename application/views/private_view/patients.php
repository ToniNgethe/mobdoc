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
        <title>Mobdoc | Patients</title>
        <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="<?= base_url("admn/css/admin.css"); ?>"/>
        <link href="<?= base_url("admn/js/datatables/jquery.dataTables.min.css"); ?>" rel="stylesheet"/>
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
                                                <h3 class="m-b-xs text-black">My patients</h3> 
                                            </div>
                                        </section>

                                        <div class="pad-content">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <section class="panel panel-default">
                                                        <header class="panel-heading"> 
                                                            A list of all my patients 
                                                        </header>
                                                        <div class="table-responsive">
                                                            <table id="tblPatients" class="display" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Number</th>
                                                                        <th>Location</th>
                                                                        <th>No. of Appointments</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody> 
                                                                    <?php
                                                                    foreach ($all_patients as $all_patients_row):
                                                                        $pId = $all_patients_row->patientId;
                                                                        $patientDetails = $this->crudmod->read_one('user', array('userId' => $pId));
                                                                        ?>
                                                                        <tr class="clickable-row" data-href="<?= base_url('patient/detail/' . $pId); ?>">
                                                                            <td><?= $patientDetails['fullname']; ?></td>
                                                                            <td><?= $patientDetails['myphone'] ?></td>
                                                                            <td><?= $patientDetails['zipcode']; ?></td>
                                                                            <td><?= count($this->crudmod->read_records('appointment', array('patientId'=>$pId))); ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    endforeach;
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </section>
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


        <!-- Datatables-->
        <script src="<?= base_url("admn/js/datatables/jquery-1.12.4.js"); ?>"></script>
        <script src="<?= base_url("admn/js/datatables/jquery.dataTables.min.js"); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#tblPatients').DataTable();
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