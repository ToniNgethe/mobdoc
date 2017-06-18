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
        <title>Mobdoc | Appointment</title>
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
                                                <h3 class="m-b-xs text-black">Appointments</h3> 
                                            </div>
                                        </section>

                                        <div class="pad-content">
                                            <div class="row">                                 
                                                <div class="col-md-6">
                                                    <div id="piechart" style="width: 427px; height: 240px;"></div>
                                                </div>                                 
                                                <div class="col-md-6">
                                                    <div id="chart_div" style="width: 427px; height: 240px;"></div>
                                                </div>
                                            </div>

                                            <br/>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <section class="panel panel-default">
                                                        <header class="panel-heading"> 
                                                            A list of all appointments 
                                                        </header>
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
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Status', 'No. of appointments'],
                    ['Waiting confirmation', <?php echo count($this->crudmod->get_where_two('appointment', 'appointmentStatus', 1, 'specialistId', $user_details['userId'])); ?>],
                    ['Confirm', <?php echo count($this->crudmod->get_where_two('appointment', 'appointmentStatus', 2, 'specialistId', $user_details['userId'])); ?>],
                    ['Cleared', <?php echo count($this->crudmod->get_where_two('appointment', 'appointmentStatus', 0, 'specialistId', $user_details['userId'])); ?>]
                ]);

                var options = {
                    title: 'Appointments flow'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            google.charts.load("current", {packages: ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Time of the day', 'Total appointments'],
<?php
$g_time = $this->crudmod->get_where('timeslot', 'specialistId', $user_details['userId']);
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

    </body>

</html>