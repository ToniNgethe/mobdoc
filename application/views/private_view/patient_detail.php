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
        <title>Mobdoc | Patient</title>
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
                                                <h3 class="m-b-xs text-black">Patient details</h3> 
                                            </div>
                                        </section>

                                        <div class="pad-content">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <section class="panel clearfix bg-white dk">
                                                        <div class="panel-body">
                                                            <a class="thumb pull-left m-r">
                                                                <img src="<?= base_url("avatars/default_profile.png"); ?>" alt="P" class="img-circle b-a b-3x b-white"> 
                                                            </a>
                                                            <div class="clear">
                                                                <a class="text-black">
                                                                    <?= $patientDetails['fullname']; ?>
                                                                </a> 
                                                                <small class="block text-muted">
                                                                    <i class="i i-location"></i> <?= $patientDetails['zipcode']; ?>
                                                                    <br/>
                                                                    <i class="i i-mail"></i> <?= $patientDetails['email']; ?>
                                                                    <br/>
                                                                    <i class="i i-phone3"></i> <?= $patientDetails['myphone']; ?>
                                                                </small> 

                                                            </div>
                                                        </div>
                                                    </section>

                                                </div>

                                                <div class="col-md-8">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <section class="panel panel-default">
                                                        <header class="panel-heading"> 
                                                            A list of all appointments and medical history
                                                        </header>
                                                        <div class="table-responsive">
                                                            <table id="tblAppointments" class="display" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Reason</th>
                                                                        <th>Location</th>
                                                                        <th>Booked on</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody> 
                                                                    <?php
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
                                                                            <td><?= $this->crudmod->read_one('symptoms', array('symptomId'=>$all_appointments_row->visitMainReason))['symptomName']; ?></td>
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
                                                    </section>
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
        
        

        <!-- Datatables-->
        <script src="<?= base_url("admn/js/datatables/jquery-1.12.4.js"); ?>"></script>
        <script src="<?= base_url("admn/js/datatables/jquery.dataTables.min.js"); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#tblAppointments').DataTable();
            });
        </script>
    </body>

</html>