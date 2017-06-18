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
        <title>MobDoc | Online Medical Scheduling</title>
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
                                    <section class="scrollable padder">
                                        <section class="row m-b-md">
                                            <div class="col-sm-6">
                                                <h3 class="m-b-xs text-black">Dashboard</h3> 
                                                <small>Welcome back <?= $my_details['fullname']; ?></small>
                                            </div>
                                        </section>

                                        <?php
                                        if ($userGroup == 1) {
                                            ?>

                                            <h2 class="stats-heade">User stats</h2>
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <div class="panel b-a bg-patients text-white">
                                                                <small class="text-uppercase ban-head">Patients</small>
                                                                <div class="padder-v text-left clearfix">
                                                                    <div class="h3 font-bold">
                                                                        <i class="i i-users2"></i>
                                                                        <?= count($this->crudmod->get_where_two('user', 'mystatus', 1, 'user_group', 2)); ?>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <div class="panel b-a bg-specialists text-white">
                                                                <small class="text-uppercase ban-head">Specialists</small>
                                                                <div class="padder-v text-left clearfix">
                                                                    <div class="h3 font-bold">
                                                                        <i class="i i-users3"></i>
                                                                        <?= count($this->crudmod->get_where_two('user', 'mystatus', 1, 'user_group', 3)); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="panel b-a bg-admin text-white">
                                                                <small class="text-uppercase ban-head">Administrators</small>
                                                                <div class="padder-v text-left clearfix">
                                                                    <div class="h3 font-bold">
                                                                        <i class="i i-user2"></i>
                                                                        <?= count($this->crudmod->get_where_two('user', 'mystatus', 1, 'user_group', 1)); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="panel b-a bg-dis text-black">
                                                                <small class="text-uppercase ban-head">Inactive/Disabled</small>
                                                                <div class="padder-v text-left clearfix">
                                                                    <div class="h3 font-bold">
                                                                        <i class="i i-users2"></i>
                                                                        <?= count($this->crudmod->get_where('user', 'mystatus', 0)); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="usertrends">
                                                        <h2 class="stats-heade">User Registration Trends </h2>
                                                        <div id="user-trends"></div>
                                                    </div>
                                                </div>


                                            </div>


                                            <h2 class="stats-heade">System billing</h2>

                                            <!-- All payments -->
                                            <section class="panel panel-default">
                                                <div class="panel-heading"> All payments made on the system </div>
                                                <div class="table-responsive">

                                                    <table  id="tblPay" class="display" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Payee</th>
                                                                <th>Phone number</th>
                                                                <th>Appointment ID</th>
                                                                <th>Amount paid (in KSh.)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $payment_details = $this->crudmod->read_table('payments');

                                                            if (count($payment_details) > 0) {
                                                                foreach ($payment_details as $payment_details_row):
                                                                    $my_appointments = $this->crudmod->read_records('appointment', array('appointmentId' => $payment_details_row->appointment_id));
                                                                    if (count($my_appointments) > 0) {
                                                                        ?>
                                                                        <tr class="clickable-row" data-href="">
                                                                            <td><?= $payment_details_row->payment_id; ?></td>
                                                                            <td><?= $payment_details_row->first_name . ' ' . $payment_details_row->last_name; ?></td>
                                                                            <td><?= $payment_details_row->sender_phone; ?></td>
                                                                            <td><?= $payment_details_row->appointment_id; ?></td>
                                                                            <td><?= $payment_details_row->amount; ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                endforeach;
                                                            } else {
                                                                
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <footer class="panel-footer">

                                                </footer>
                                            </section>

                                            <?php
                                        } elseif ($userGroup == 3) {
                                            ?>


                                            <h2 class="stats-heade">Practice stats</h2>
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <div class="panel b-a bg-patients text-white">
                                                                <small class="text-uppercase ban-head">Appointments</small>
                                                                <div class="padder-v text-left clearfix">
                                                                    <div class="h3 font-bold">
                                                                        <i class="i i-calendar"></i>
                                                                        <?= count($this->crudmod->get_where('appointment', 'specialistId', $my_details['userId'])); ?>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <div class="panel b-a bg-specialists text-white">
                                                                <small class="text-uppercase ban-head">Schedules</small>
                                                                <div class="padder-v text-left clearfix">
                                                                    <div class="h3 font-bold">
                                                                        <i class="i i-clock2"></i>
                                                                        <?= count($this->crudmod->get_where('timeslot', 'specialistId', 1)); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="panel b-a bg-admin text-white">
                                                                <small class="text-uppercase ban-head">Insurance Covers</small>
                                                                <div class="padder-v text-left clearfix">
                                                                    <div class="h3 font-bold">
                                                                        <i class="i i-stack"></i>
                                                                        <?= count($this->crudmod->get_where_two('specialist_insurance', 'specInsStatus', 1, 'specialistId', $my_details['userId'])); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="usertrends">
                                                        <h2 class="stats-heade">User Appointment Trends </h2>
                                                        <div id="appointment-trends"></div>
                                                    </div>
                                                </div>


                                            </div>

                                            <h2 class="stats-heade">My recent billing</h2>

                                            <!-- All payments -->
                                            <section class="panel panel-default">
                                                <div class="panel-heading"> All payments made on my specialty </div>
                                                <div class="table-responsive">

                                                    <table  id="tblPay" class="display" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Payee</th>
                                                                <th>Phone number</th>
                                                                <th>Appointment ID</th>
                                                                <th>Amount paid (in KSh.)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $payment_details = NULL;
                                                            $my_apps = $this->crudmod->read_records('appointment', array('specialistId' => $userId));
                                                            foreach ($my_apps as $my_apps_row):
                                                                $payment_details = $this->crudmod->read_records('payments', array('appointment_id' => $my_apps_row->appointmentId));

                                                                if (count($payment_details) > 0) {
                                                                    foreach ($payment_details as $payment_details_row):
                                                                        $my_appointments = $this->crudmod->read_records('appointment', array('appointmentId' => $payment_details_row->appointment_id, 'specialistId' => $userId));
                                                                        if (count($my_appointments) > 0) {
                                                                            ?>
                                                                            <tr class="clickable-row" data-href="">
                                                                                <td><?= $payment_details_row->payment_id; ?></td>
                                                                                <td><?= $payment_details_row->first_name . ' ' . $payment_details_row->last_name; ?></td>
                                                                                <td><?= $payment_details_row->sender_phone; ?></td>
                                                                                <td><?= $payment_details_row->appointment_id; ?></td>
                                                                                <td><?= $payment_details_row->amount; ?></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    endforeach;
                                                                } else {
                                                                    
                                                                }
                                                            endforeach;
                                                            ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <footer class="panel-footer">

                                                </footer>
                                            </section>


                                            <?php
                                        } else {
                                            redirect("login");
                                        }
                                        ?>

                                    </section>
                                </section>
                            </section>
                        </section>
                        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
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
                $('#tblPay').DataTable();
            });


        </script>


        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <?php
        if ($userGroup == 1) {
            ?>

            <script type="text/javascript">
                google.charts.load('current', {packages: ['corechart', 'line']});
                google.charts.setOnLoadCallback(drawCurveTypes);

                function drawCurveTypes() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'X');
                    data.addColumn('number', 'Patients');
                    data.addColumn('number', 'Specialists');

                    data.addRows([
    <?php
    foreach ($this->db->select("DISTINCT(date(joindate)) as tims")->from('md_user')->order_by('userId asc')->get()->result() as $users) {
        $users_patients = $this->db->select("*")->from('md_user')->where(['date(joindate)' => $users->tims, 'user_group' => 2])->get()->result();
        $users_specialists = $this->db->select("*")->from('md_user')->where(['date(joindate)' => $users->tims, 'user_group' => 3])->get()->result();
        echo "['" . date("M d", strtotime($users->tims)) . "'," . count($users_patients) . ", " . count($users_specialists) . "],";
    }
    ?>
                    ]);

                    var options = {
                        hAxis: {
                        },
                        vAxis: {
                        }

                    };

                    var chart = new google.visualization.LineChart(document.getElementById('user-trends'));
                    chart.draw(data, options);
                }
            </script>
            <?php
        } else {
            ?>

            <script type="text/javascript">
                google.charts.load('current', {packages: ['corechart', 'line']});
                google.charts.setOnLoadCallback(drawCurveTypes);

                function drawCurveTypes() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'X');
                    data.addColumn('number', 'Appointments');

                    data.addRows([
    <?php
    $g_time = $this->crudmod->get_where('timeslot', 'specialistId', $my_details['userId']);
    foreach ($g_time as $g_row):
        echo "['" . $g_row->timeslotTime . "', " . count($this->crudmod->get_where('appointment', 'timeslotId', $g_row->timeslotId)) . "],";
    endforeach;
    ?>
                    ]);

                    var options = {
                        hAxis: {
                        },
                        vAxis: {
                        }

                    };

                    var chart = new google.visualization.LineChart(document.getElementById('appointment-trends'));
                    chart.draw(data, options);
                }
            </script>
            <?php
        }
        ?>






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