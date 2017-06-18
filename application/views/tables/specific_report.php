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
        <title>MobDoc | System Reports</title>
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="<?= base_url("admn/css/admin.css"); ?>"/>
        <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="<?= base_url("admn/js/datatables/jquery.dataTables.min.css"); ?>" rel="stylesheet"/>
        <link href="<?= base_url("admn/js/datatables/buttons.css"); ?>" rel="stylesheet"/>

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

                                        <h3 class="report-filter">

                                            <?php
                                            if ($reportType == 'app_zip') {
                                                echo $_GET['fil'];
                                            } elseif ($reportType == 'app_sym') {
                                                echo $this->crudmod->read_one('symptoms', array('symptomId' => $_GET['fil']))['symptomName'];
                                            } else {
                                                
                                            }
                                            ?>

                                        </h3>
                                        <div class="alert alert-success">
                                            The data below is a copy of 
                                            <?php
                                            if ($reportType == 'app_zip') {
                                                echo $_GET['fil'];
                                            } elseif ($reportType == 'app_sym') {
                                                echo $this->crudmod->read_one('symptoms', array('symptomId' => $_GET['fil']))['symptomName'];
                                            } else {
                                                echo $this->crudmod->read_one('insurance', array('insuranceId' => $_GET['fil']))['insuranceName'];
                                            }
                                            ?>
                                            's summary report
                                        </div>

                                        <div class="pad-content">

                                            <?php
                                            if ($reportType == "app_zip") {
                                                ?>


                                                <!--Default report-->
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">Summary location activity</div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-8 no-borders padder-v">
                                                                <div id="appointmentBar" style="height: 460px"></div>
                                                            </div>
                                                            <div class="col-md-4 no-borders padder-v">
                                                                <div id="specialistChart"></div>

                                                                <br/>

                                                                <div id="symptomChart"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <section class="panel panel-default">
                                                    <div class="panel-heading"> Appointments made in <?= $_GET['fil']; ?> </div>
                                                    <div class="table-responsive">

                                                        <table  id="tblZipReports" class="display" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Patient name</th>
                                                                    <th>Specialist name</th>
                                                                    <th>Booked on</th>
                                                                    <th>Main reason/Sickness</th>
                                                                    <th>Other symptoms</th>
                                                                    <th>Insurance cover</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                if (count($reportData) > 0) {
                                                                    foreach ($reportData as $reportData_row):
                                                                        ?>
                                                                        <tr class="" data-href="">
                                                                            <td><?= $this->crudmod->read_one('user', array('userId' => $reportData_row->patientId))['fullname']; ?></td>
                                                                            <td><?= $this->crudmod->read_one('specialist', array('userId' => $reportData_row->specialistId))['displayName']; ?></td>
                                                                            <td><?= $reportData_row->appointmentBookTime; ?></td>
                                                                            <td><?= $this->crudmod->read_one('symptoms', array('symptomId' => $reportData_row->visitMainReason))['symptomName']; ?></td>
                                                                            <td><?= $reportData_row->visitReason; ?></td>
                                                                            <td><?= $this->crudmod->read_one('insurance', array('insuranceId' => $reportData_row->insuranceId))['insuranceName']; ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    endforeach;
                                                                } else {
                                                                    
                                                                }
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <footer class="panel-footer">
                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($reportData); ?> reports</div>
                                                        </div>
                                                    </footer>
                                                </section>
                                                <?php
                                            } elseif ($reportType == "app_sym") {
                                                ?>

                                                <!--Default report-->
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">Summary activity</div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-8 no-borders padder-v">
                                                                <div id="symptomBar" style="height: 260px"></div>
                                                            </div>
                                                            <div class="col-md-4 no-borders padder-v">
                                                                <div id="symptomZipChart"></div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <section class="panel panel-default">
                                                    <div class="panel-heading"> Appointments made under <strong><?= $this->crudmod->read_one('symptoms', array('symptomId' => $_GET['fil']))['symptomName']; ?></strong> </div>
                                                    <div class="table-responsive">

                                                        <table  id="tblZipReports" class="display" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Patient name</th>
                                                                    <th>Specialist name</th>
                                                                    <th>Booked on</th>
                                                                    <th>Other symptoms</th>
                                                                    <th>Insurance cover</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                if (count($reportData) > 0) {
                                                                    foreach ($reportData as $reportData_row):
                                                                        ?>
                                                                        <tr class="" data-href="">
                                                                            <td><?= $this->crudmod->read_one('user', array('userId' => $reportData_row->patientId))['fullname']; ?></td>
                                                                            <td><?= $this->crudmod->read_one('specialist', array('userId' => $reportData_row->specialistId))['displayName']; ?></td>
                                                                            <td><?= $reportData_row->appointmentBookTime; ?></td>
                                                                            <td><?= $reportData_row->visitReason; ?></td>
                                                                            <td><?= $this->crudmod->read_one('insurance', array('insuranceId' => $reportData_row->insuranceId))['insuranceName']; ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    endforeach;
                                                                } else {
                                                                    
                                                                }
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <footer class="panel-footer">
                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($reportData); ?> reports</div>
                                                        </div>
                                                    </footer>
                                                </section>

                                                <?php
                                            } elseif ($reportType == 'app_ins') {
                                                ?>


                                                <!--Default report-->
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">Summary activity</div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-8 no-borders padder-v">
                                                                <div id="insuranceBar" style="height: 260px"></div>
                                                            </div>
                                                            <div class="col-md-4 no-borders padder-v">
                                                                <div id="insuranceZipChart"></div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <section class="panel panel-default">
                                                    <div class="panel-heading"> Appointments made under <strong><?= $this->crudmod->read_one('insurance', array('insuranceId' => $_GET['fil']))['insuranceName']; ?></strong> </div>
                                                    <div class="table-responsive">

                                                        <table  id="tblZipReports" class="display" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Patient name</th>
                                                                    <th>Specialist name</th>
                                                                    <th>Booked on</th>
                                                                    <th>Other symptoms</th>
                                                                    <th>Insurance cover</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                if (count($reportData) > 0) {
                                                                    foreach ($reportData as $reportData_row):
                                                                        ?>
                                                                        <tr class="" data-href="">
                                                                            <td><?= $this->crudmod->read_one('user', array('userId' => $reportData_row->patientId))['fullname']; ?></td>
                                                                            <td><?= $this->crudmod->read_one('specialist', array('userId' => $reportData_row->specialistId))['displayName']; ?></td>
                                                                            <td><?= $reportData_row->appointmentBookTime; ?></td>
                                                                            <td><?= $reportData_row->visitReason; ?></td>
                                                                            <td><?= $this->crudmod->read_one('insurance', array('insuranceId' => $reportData_row->insuranceId))['insuranceName']; ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    endforeach;
                                                                } else {
                                                                    
                                                                }
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <footer class="panel-footer">
                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($reportData); ?> reports</div>
                                                        </div>
                                                    </footer>
                                                </section>
                                                <?php
                                            } else {
                                                redirect('admin/reports/appointment');
                                            }
                                            ?>
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
        <script src="<?= base_url("khyp/js/custom.min.js"); ?>"></script>

        <!-- Datatables-->
        <script src="<?= base_url("admn/js/datatables/jquery-1.12.4.js"); ?>"></script>
        <script src="<?= base_url("admn/js/datatables/jquery.dataTables.min.js"); ?>"></script>
        <?php $this->load->view('private_view/datatables'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#tblZipReports').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'pdf', 'print'
                    ]
                });
            });
            jQuery(document).ready(function ($) {
                $(".clickable-row").click(function () {
                    window.location = $(this).data("href");
                });
            });

        </script>




        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <?php
        if ($reportType == "app_zip") {
            ?>
            <script type="text/javascript">
                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                        ['Specialist', 'No. of appointments'],
    <?php
    $specialists = $this->crudmod->read_distinct_records('appointment', 'specialistId', array('patientLocation' => $_GET['fil']));
    foreach ($specialists as $specialists_row):
        echo "['" . $this->crudmod->read_one('specialist', array('userId' => $specialists_row->specialistId))['displayName'] . "', " . count($this->crudmod->read_records('appointment', array('specialistId' => $specialists_row->specialistId, 'patientLocation' => $_GET['fil']))) . "],";
    endforeach;
    ?>
                    ]);

                    var options = {
                        title: 'Specialists activity'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('specialistChart'));

                    chart.draw(data, options);
                }
            </script>
            <script type="text/javascript">
                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                        ['Symptom', 'No. of appointments'],
    <?php
    $symptoms = $this->crudmod->read_distinct_records('appointment', 'visitMainReason', array('patientLocation' => $_GET['fil']));
    foreach ($symptoms as $symptoms_row):
        echo "['" . $this->crudmod->read_one('symptoms', array('symptomId' => $symptoms_row->visitMainReason))['symptomName'] . "', " . count($this->crudmod->read_records('appointment', array('visitMainReason' => $symptoms_row->visitMainReason, 'patientLocation' => $_GET['fil']))) . "],";
    endforeach;
    ?>
                    ]);

                    var options = {
                        title: 'Symptoms activity'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('symptomChart'));

                    chart.draw(data, options);
                }
            </script>
            <script type="text/javascript">
                google.charts.load("current", {packages: ['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Date', 'Total appointments'],
    <?php
    $times = $this->crudmod->read_distinct_records('appointment', 'timeslotId', array('patientLocation' => $_GET['fil']));
    foreach ($times as $times_row):
        $g_time = $this->crudmod->read_one('timeslot', array('timeslotId' => $times_row->timeslotId));

        echo "['" . date("M d", strtotime($g_time['timeslotDate'])) . "', " . count($this->crudmod->read_records('appointment', array('timeslotId' => $times_row->timeslotId))) . "],";

    endforeach;
    ?>
                    ]);
                    var options = {
                        title: "Number of appointments per day",
                        bar: {groupWidth: '100%'},
                        legend: {position: 'none'},
                        hAxis: {
                            title: 'Day'
                        },
                        vAxis: {
                            title: 'Total appointments'
                        }
                    };
                    var chart = new google.visualization.ColumnChart(document.getElementById('appointmentBar'));
                    chart.draw(data, options);
                }
            </script>
            <?php
        }
        elseif ($reportType == "app_sym") {
            ?>

            <script type="text/javascript">
                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                        ['Symptom', 'No. of appointments'],
    <?php
    $symptomsZip = $this->crudmod->read_group_records('appointment', 'patientLocation', array('visitMainReason' => $_GET['fil']));
    foreach ($symptomsZip as $symptomsZip_row):
        echo "['" . $symptomsZip_row->patientLocation . "', " . count($this->crudmod->read_records('appointment', array('patientLocation' => $symptomsZip_row->patientLocation, 'visitMainReason' => $_GET['fil']))) . "],";
    endforeach;
    ?>
                    ]);

                    var options = {
                        title: 'Bookings per location'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('symptomZipChart'));

                    chart.draw(data, options);
                }
            </script>
            <script type="text/javascript">
                google.charts.load("current", {packages: ['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Date', 'Total appointments'],
    <?php
    $syms = $this->crudmod->read_group_records('appointment', 'timeslotId', array('visitMainReason' => $_GET['fil']));
    foreach ($syms as $syms_row):
        $g_time = $this->crudmod->read_one('timeslot', array('timeslotId' => $syms_row->timeslotId));

        echo "['" . date("M d", strtotime($g_time['timeslotDate'])) . "', " . count($this->crudmod->read_records('appointment', array('timeslotId' => $syms_row->timeslotId, 'visitMainReason' => $_GET['fil']))) . "],";

    endforeach;
    ?>
                    ]);
                    var options = {
                        title: "Number of appointments per day",
                        bar: {groupWidth: '100%'},
                        legend: {position: 'none'},
                        hAxis: {
                            title: 'Day'
                        },
                        vAxis: {
                            title: 'Total appointments'
                        }
                    };
                    var chart = new google.visualization.ColumnChart(document.getElementById('symptomBar'));
                    chart.draw(data, options);
                }
            </script>
            <?php
        }
        elseif ($reportType == "app_ins") {
            ?>

            <script type="text/javascript">
                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                        ['Insurance', 'No. of appointments'],
    <?php
    $insuranceZip = $this->crudmod->read_group_records('appointment', 'patientLocation', array('insuranceId' => $_GET['fil']));
    foreach ($insuranceZip as $insuranceZip_row):
        echo "['" . $insuranceZip_row->patientLocation . "', " . count($this->crudmod->read_records('appointment', array('patientLocation' => $insuranceZip_row->patientLocation, 'insuranceId' => $_GET['fil']))) . "],";
    endforeach;
    ?>
                    ]);

                    var options = {
                        title: 'Bookings per location'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('insuranceZipChart'));

                    chart.draw(data, options);
                }
            </script>
            <script type="text/javascript">
                google.charts.load("current", {packages: ['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Date', 'Total appointments'],
    <?php
    $insurances = $this->crudmod->read_group_records('appointment', 'insuranceId', array('insuranceId' => $_GET['fil']));
    foreach ($insurances as $insurances_row):
        $g_time = $this->crudmod->read_one('timeslot', array('timeslotId' => $insurances_row->timeslotId));

        echo "['" . date("M d", strtotime($g_time['timeslotDate'])) . "', " . count($this->crudmod->read_records('appointment', array('insuranceId' => $_GET['fil']))) . "],";

    endforeach;
    ?>
                    ]);
                    var options = {
                        title: "Number of appointments per day",
                        bar: {groupWidth: '100%'},
                        legend: {position: 'none'},
                        hAxis: {
                            title: 'Day'
                        },
                        vAxis: {
                            title: 'Total appointments'
                        }
                    };
                    var chart = new google.visualization.ColumnChart(document.getElementById('insuranceBar'));
                    chart.draw(data, options);
                }
            </script>
            <?php
        }
        ?>

    </body>

</html>