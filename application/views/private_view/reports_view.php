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
                                        <h1 class="report-filter">Filter report by date</h1>
                                        <form method="get" action="">
                                            <section class="row m-b-md header-banner">
                                                <div class="col-md-3">
                                                    <div id="datetimepicker1" class="input-append form-group">
                                                        <input data-format="MM/dd/yyyy" type="text" name="date_from" placeholder="From" value="<?php
                                                        if (isset($_GET['date_from'])) {
                                                            echo $_GET['date_from'];
                                                        }
                                                        ?>" required="true" class="form-control">
                                                        <span class="add-on">
                                                            <i data-date-icon="i i-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div id="datetimepicker2" class="input-append form-group">
                                                        <input data-format="MM/dd/yyyy" type="text" name="date_to" placeholder="To" value="<?php
                                                        if (isset($_GET['date_to'])) {
                                                            echo $_GET['date_to'];
                                                        }
                                                        ?>" required="true" class="form-control">
                                                        <span class="add-on">
                                                            <i data-date-icon="i i-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                </div>
                                            </section>
                                        </form>

                                        <?php
                                        if (!isset($_GET['date_from']) & (!isset($date_to))) {
                                            ?>
                                            <div class="alert alert-warning">
                                                The data below is a copy of the system's daily reports. Use the date filter above for data from or within specific dates
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="alert alert-success">
                                                The data below is a copy of the system's reports from dates <strong><?= $_GET['date_from']; ?></strong> to <strong><?= $_GET['date_to']; ?></strong>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div class="pad-content">
                                            <?php
                                            if ($reportType == "user") {
                                                ?>

                                                <!--Default report-->
                                                <section class="panel panel-default">
                                                    <div class="panel-heading"> User report </div>
                                                    <div class="table-responsive">

                                                        <table  id="tblUserReports" class="display" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>User</th>
                                                                    <th>User group</th>
                                                                    <th>Joined on</th>
                                                                    <th>Location</th>
                                                                    <th>Total sessions</th>
                                                                    <th>Total Appointments</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                if (count($reportData) > 0) {
                                                                    foreach ($reportData as $reportData_row):
                                                                        $user_id = $reportData_row->userId;
                                                                        $userGroup_id = $reportData_row->user_group;
                                                                        $user_name = $reportData_row->fullname;
                                                                        $user_session = $reportData_row->email;
                                                                        ?>
                                                                        <tr class="clickable-row" data-href="<?= base_url('u/user/' . $user_id) ?>">
                                                                            <td><?= $user_name; ?></td>
                                                                            <td><?= $this->crudmod->read_one('user_group', array('user_group_id' => $userGroup_id))['group_name']; ?></td>
                                                                            <td><?= $reportData_row->joindate; ?></td>
                                                                            <td><?= $reportData_row->zipcode; ?></td>
                                                                            <td><?= count($this->crudmod->read_records('user_logs', array('userId' => $user_id, 'logMessage' => "Logged into the system"))); ?></td>
                                                                            <td><?= count($this->crudmod->read_records('appointment', array('patientId' => $user_id))); ?></td>
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
                                            } elseif ($reportType == "appointment") {
                                                if ($userGroup == 1) {
                                                    $dir_report = "admin";
                                                } else {
                                                    $dir_report = "specialist";
                                                }
                                                ?>
                                                <!--Default report-->
                                                <!-- More report filters -->
                                                <h4 class="m-t-lg">Group appointments by</h4>
                                                <div class="m-b-sm">
                                                    <div class="btn-group"> 
                                                        <a href="<?= base_url($dir_report . '/reports/f_appointment/zipcode'); ?>" class="btn btn-default">Location</a> 
                                                        <a href="<?= base_url($dir_report . '/reports/f_appointment/symptoms'); ?>" class="btn btn-default">Symptoms</a>
                                                        <a href="<?= base_url($dir_report . '/reports/f_appointment/insurance'); ?>" class="btn btn-default">Insurance Cover</a> 
                                                    </div>
                                                </div>


                                                <section class="panel panel-default">
                                                    <div class="panel-heading"> Appointment report </div>
                                                    <div class="table-responsive">

                                                        <table  id="tblAppointmentReports" class="display" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Patient name</th>
                                                                    <th>Specialist name</th>
                                                                    <th>Booked on</th>
                                                                    <th>Location</th>
                                                                    <th>Main reason/Sickness</th>
                                                                    <th>Insurance cover</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                if (count($reportData) > 0) {
                                                                    foreach ($reportData as $reportData_row):
                                                                        ?>
                                                                        <tr class="clickable-row" data-href="">
                                                                            <td><?= $this->crudmod->read_one('user', array('userId' => $reportData_row->patientId))['fullname']; ?></td>
                                                                            <td><?= $this->crudmod->read_one('specialist', array('userId' => $reportData_row->specialistId))['displayName']; ?></td>
                                                                            <td><?= $reportData_row->appointmentBookTime; ?></td>
                                                                            <td><?= $reportData_row->patientLocation; ?></td>
                                                                            <td><?= $this->crudmod->read_one('symptoms', array('symptomId' => $reportData_row->visitMainReason))['symptomName']; ?></td>
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

        <!-- Datatables-->
        <script src="<?= base_url("admn/js/datatables/jquery-1.12.4.js"); ?>"></script>
        <script src="<?= base_url("admn/js/datatables/jquery.dataTables.min.js"); ?>"></script>
        <?php $this->load->view('private_view/datatables'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#tblUserReports').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'pdf', 'print'
                    ]
                });
                $('#tblAppointmentReports').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'pdf', 'print'
                    ]
                });
            });

        </script>
        <script type="text/javascript"
                src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
        </script>
        <script type="text/javascript"
                src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
        </script>


        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker({
                    language: 'en',
                    pick12HourFormat: true
                });
                $('#datetimepicker2').datetimepicker({
                    language: 'en',
                    pick12HourFormat: true
                });
            });


            var dateToday = new Date();


            $.fn.datetimepicker.defaults = {
                maskInput: true, // disables the text input mask
                pickDate: true, // disables the date picker
                pickTime: false, // disables de time picker
                pick12HourFormat: false, // enables the 12-hour format time picker
                pickSeconds: false, // disables seconds in the time picker
                startDate: Infinity, // set a minimum date
                endDate: Infinity          // set a maximum date
            };
        </script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages: ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Time of the day', 'Total appointments'],
<?php
$g_time = $this->crudmod->get_where('timeslot', 'specialistId', $userId);
foreach ($g_time as $g_row):
    echo "['" . $g_row->timeslotTime . "', " . count($this->crudmod->get_where('appointment', 'timeslotId', $g_row->timeslotId)) . "],";
endforeach;
?>
                ]);
                var options = {
                    title: "Totals number of appointments per timeslot",
                    bar: {groupWidth: '100%'},
                    legend: {position: 'none'},
                    hAxis: {
                        title: 'Time of the day'
                    },
                    vAxis: {
                        title: 'Total appointments'
                    }
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Status', 'No. of appointments'],
                    ['Waiting confirmation', <?php echo count($this->crudmod->get_where_two('appointment', 'appointmentStatus', 1, 'specialistId', $userId)); ?>],
                    ['Confirmed', <?php echo count($this->crudmod->get_where_two('appointment', 'appointmentStatus', 2, 'specialistId', $userId)); ?>],
                    ['Cleared', <?php echo count($this->crudmod->get_where_two('appointment', 'appointmentStatus', 0, 'specialistId', $userId)); ?>]
                ]);

                var options = {
                    title: 'Appointments summary'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
        </script>
    </body>

</html>