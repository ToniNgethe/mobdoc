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
        <title>Mobdoc | System Logs</title>
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
                                        <h3 class="m-b-xs text-black">All system logs and activities</h3> 
                                    </div>
                                </section>




                                <div class="pad-content">

                                    <div class="row">
                                        <div class="col-md-12" id="rev">

                                            <div class="row hidden">
                                                <div class="col-md-7">
                                                    <div id="session_chart_div" style="height: 100%;"></div>
                                                </div>
                                            </div>

                                            <br/>

                                            <div class="row">
                                                <div class="col-md-12">

                                                    <p class="help-block hidden">Click on the <strong>accept</strong> button to add a given cover to your profile</p>


                                                    <!-- All inactive/new specialists -->
                                                    <section class="panel panel-default">
                                                        <div class="panel-heading"> All logs </div>
                                                        <div class="table-responsive">

                                                            <table  id="tblLogs" class="display" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Log date/time</th>
                                                                        <th>Affected user ID</th>
                                                                        <th>Performing user ID</th>
                                                                        <th>Log info</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php
                                                                    if (count($allLogs) > 0) {
                                                                        foreach ($allLogs as $allLogs_row):
                                                                            $logId = $allLogs_row->logId;
                                                                            $logTime = $allLogs_row->logTime;
                                                                            $affectedUser = $allLogs_row->userId;
                                                                            $performingUser = $allLogs_row->actor;
                                                                            $logMessage = $allLogs_row->logMessage;
                                                                            ?>
                                                                            <tr class="clickable-row" data-href="">
                                                                                <td><?= $logId; ?></td>
                                                                                <td><?= $logTime; ?></td>
                                                                                <td><?= $affectedUser; ?></td>
                                                                                <td><?= $performingUser; ?></td>
                                                                                <td><?= $logMessage; ?></td>
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
                                                                <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($allLogs); ?> records</div>
                                                            </div>
                                                        </footer>
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
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <!-- Datatables-->
        <script src="<?= base_url("admn/js/datatables/jquery-1.12.4.js"); ?>"></script>
        <script src="<?= base_url("admn/js/datatables/jquery.dataTables.min.js"); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#tblLogs').DataTable();
            });

            google.charts.load('current', {packages: ['corechart', 'line']});
            google.charts.setOnLoadCallback(drawBasic);

            function drawBasic() {

                var data = new google.visualization.DataTable();
                data.addColumn('number', 'X');
                data.addColumn('number', 'Dogs');

                data.addRows([
                    [0, 0], [1, 10], [2, 23], [3, 17], [4, 18], [5, 9],
                    [6, 11], [7, 27], [8, 33], [9, 40], [10, 32], [11, 35],
                    [12, 30], [13, 40], [14, 42], [15, 47], [16, 44], [17, 48],
                    [18, 52], [19, 54], [20, 42], [21, 55], [22, 56], [23, 57],
                    [24, 60], [25, 50], [26, 52], [27, 51], [28, 49], [29, 53],
                    [30, 55], [31, 60], [32, 61], [33, 59], [34, 62], [35, 65],
                    [36, 62], [37, 58], [38, 55], [39, 61], [40, 64], [41, 65],
                    [42, 63], [43, 66], [44, 67], [45, 69], [46, 69], [47, 70],
                    [48, 72], [49, 68], [50, 66], [51, 65], [52, 67], [53, 70],
                    [54, 71], [55, 72], [56, 73], [57, 75], [58, 70], [59, 68],
                    [60, 64], [61, 60], [62, 65], [63, 67], [64, 68], [65, 69],
                    [66, 70], [67, 72], [68, 75], [69, 80]
                ]);

                var options = {
                    hAxis: {
                        title: 'Time'
                    },
                    vAxis: {
                        title: 'Popularity'
                    }
                };

                var chart = new google.visualization.LineChart(document.getElementById('session_chart_div'));

                chart.draw(data, options);
            }
        </script>
    </body>

</html>