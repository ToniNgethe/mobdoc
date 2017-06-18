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
        <title> Your Medical History </title>
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
                                                <h3 class="m-b-xs text-black">Medical history</h3> 
                                            </div>
                                        </section>



                                        <div id="profile">


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            Appointment status
                                                        </div>
                                                        <div class="panel-body">
                                                            <div id="piechartAppointment" style="width: 100%; height: 250px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            Insurance covers used
                                                        </div>
                                                        <div class="panel-body">
                                                            <div id="piechartInsurance" style="width: 100%; height: 250px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <br/>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <section class="panel panel-default">
                                                        <header class="panel-heading"> 
                                                            My past appointments 
                                                        </header>
                                                        <div class="table-responsive">
                                                            <table id="tblAppointments" class="display" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Specialist name</th>
                                                                        <th>Number</th>
                                                                        <th>Visit reason</th>                                                                        
                                                                        <th>Other symptoms</th>
                                                                        <th>Booked on</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody> 
                                                                    <?php
                                                                    $all_appointments = $this->crudmod->read_records('appointment', array('patientId' => $userId, 'appointmentStatus'=> FALSE));
                                                                    foreach ($all_appointments as $all_appointments_row):
                                                                        $aid = $all_appointments_row->appointmentId;
                                                                        $aName = $this->crudmod->read_one('specialist', array('userId'=>$all_appointments_row->specialistId));
                                                                        $aDate = $all_appointments_row->appointmentBookTime;
                                                                        $aMobile = $all_appointments_row->patientMobile;
                                                                        $aReason = $this->crudmod->read_one('symptoms', array('symptomId'=>$all_appointments_row->visitMainReason));
                                                                        $aSymptoms = $all_appointments_row->visitReason;
                                                                        if ($all_appointments_row->appointmentStatus == 1) {
                                                                            $aStatus = "Waiting confirmation";
                                                                        } else if ($all_appointments_row->appointmentStatus == 2) {
                                                                            $aStatus = "Confirmed";
                                                                        } else {
                                                                            $aStatus = "Cleared or canceled";
                                                                        }
                                                                        ?>
                                                                        <tr class="clickable-row" data-href="<?= base_url('appointment/detail/' . $aid); ?>">
                                                                            <td><?= $aName['displayName']; ?></td>
                                                                            <td><?= $aMobile; ?></td>
                                                                            <td><?= $aReason['symptomName']; ?></td>
                                                                            <td><?= $aSymptoms;?></td>
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

        <?php
        $w_app = $this->crudmod->read_records('appointment', array('appointmentStatus' => 1, 'patientId' => $userId));
        $co_app = $this->crudmod->read_records('appointment', array('appointmentStatus' => 2, 'patientId' => $userId));
        $cl_app = $this->crudmod->read_records('appointment', array('appointmentStatus' => 0, 'patientId' => $userId));
        echo $cl_app;
        ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Status', 'No. of appointments'],
                    ['Waiting confirmation', <?= count($w_app); ?>],
                    ['Confirmed', <?= count($co_app); ?>],
                    ['Cleared', <?= count($cl_app); ?>]
                ]);

                var options = {
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechartAppointment'));

                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Insurance', 'No. of appointments'],
                    <?php
$insuranceZip = $this->crudmod->get_all('insurance', 'insuranceId');
foreach ($insuranceZip as $insuranceZip_row):
    echo "['" . $insuranceZip_row->insuranceName . "', " . count($this->crudmod->read_records('appointment', array('patientId' => $userId, 'insuranceId' => $insuranceZip_row->insuranceId))) . "],";
endforeach;
?>
                ]);

                var options = {
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechartInsurance'));

                chart.draw(data, options);
            }
        </script>


    </body>
</html>