
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
        <title>Mobdoc | Schedules</title>
        <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
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
                                        <section class="row m-b-md header-banner">
                                            <div class="col-sm-6">
                                                <h3 class="m-b-xs text-black">Schedule - Available timeslots</h3> 
                                            </div>
                                        </section>


                                        <div class="pad-content">

                                            <div class="row">
                                                <div class="col-md-12" id="rev">

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="help-block">Create a <strong>new timeslot</strong> which will be added to your availability schedules</p>
                                                            <p class="help-block">Click on the <strong><i class="i i-calendar"></i></strong> icon to select date & time</p>


                                                            <?php if (null != validation_errors() || null != $this->session->flashdata('error') || null != $this->session->flashdata('success')) { ?>
                                                                <div class="alert alert-<?= null == $this->session->flashdata('success') ? 'warning' : 'success' ?>">
                                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                                    <?= validation_errors() ?>
                                                                    <?= $this->session->flashdata('error') ?>
                                                                    <?= $this->session->flashdata('success') ?>
                                                                </div>
                                                            <?php }
                                                            ?>

                                                            <form method="post" action="<?= base_url('save-timeslot'); ?>">
                                                                <div id="datetimepicker2" class="input-append form-group">
                                                                    <input data-format="MM/dd/yyyy HH:mm PP" type="text" name="timeslot" placeholder="MM/DD/YYYY HH:mm PP" class="form-control">
                                                                    <span class="add-on">
                                                                        <i data-time-icon="i i-clock2" data-date-icon="i i-calendar"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input value="Save timeslot" class="btn btn-s-md btn-success" type="submit">
                                                                </div>
                                                            </form>

                                                            <br/>                         

                                                            <!-- All inactive/new specialists -->
                                                            <section class="panel panel-default">
                                                                <div class="panel-heading"> All timeslots </div>
                                                                <div class="table-responsive">

                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>Time</th>
                                                                                <th>Status</th>
                                                                                <th>Trash</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <?php
                                                                            if (count($timeslots) > 0) {
                                                                                foreach ($timeslots as $timeslots_row):
                                                                                    $timeslotId = $timeslots_row->timeslotId;
                                                                                    $timeslotDate = $timeslots_row->timeslotDate;
                                                                                    $timeslotTime = $timeslots_row->timeslotTime;

                                                                                    $day_today = date("d");
                                                                                    $month_today = date('m');

                                                                                    $timeslot_day = substr($timeslotDate, 3, 2);
                                                                                    $timeslot_month = substr($timeslotDate, 0, 2);

                                                                                    if ($timeslot_month - $month_today >= 0 && $timeslot_day - $day_today >= 0) {
                                                                                        $timeslotStatus = "Active";
                                                                                    } else {
                                                                                        $timeslotStatus = "Passed";
                                                                                    }
                                                                                    ?>
                                                                                    <tr class="clickable-row" data-href="">
                                                                                        <td><?= $timeslotDate; ?></td>
                                                                                        <td><?= $timeslotTime; ?></td>
                                                                                        <td><?= $timeslotStatus; ?></td>
                                                                                        <td>
                                                                                            <form method="post" action="<?= base_url('delete-timeslot'); ?>">
                                                                                                <input type="hidden" name="timeslotKey" value="<?= $timeslotId; ?>"/>
                                                                                                <button type="submit" class="timeslot-del">
                                                                                                    <i class="i i-trashcan"></i>
                                                                                                </button>
                                                                                            </form>
                                                                                        </td>
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
                                                                        <div class="col-md-4 col-md-offset-4 text-center">Found <?= count($timeslots); ?> records</div>
                                                                    </div>
                                                                </footer>
                                                            </section>


                                                        </div>
                                                        <div class="col-md-6">
                                                            <div id="chart_div" style="width: 100%; height: 240px;"></div>
                                                        </div>  
                                                    </div>

                                                    <div class="<?= $show_error; ?>">
                                                        <div class="alert-danger navbar navbar-fixed-bottom">
                                                            <div class="container">
                                                                <div class="my-error">
                                                                    <strong>Oops! Check the error(s) below :-</strong>
                                                                    <?= $error; ?>
                                                                </div>
                                                            </div>
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
        <script type="text/javascript"
                src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
        </script>
        <script type="text/javascript"
                src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
        </script>


        <script type="text/javascript">
            $(function () {
                $('#datetimepicker2').datetimepicker({
                    language: 'en',
                    pick12HourFormat: true
                });
            });


            var dateToday = new Date();


            $.fn.datetimepicker.defaults = {
                maskInput: true, // disables the text input mask
                pickDate: true, // disables the date picker
                pickTime: true, // disables de time picker
                pick12HourFormat: false, // enables the 12-hour format time picker
                pickSeconds: false, // disables seconds in the time picker
                startDate: dateToday, // set a minimum date
                endDate: Infinity          // set a maximum date
            };
        </script>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages: ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Time of the day', 'Total No. of Timeslots'],
<?php
$g_time = $this->crudmod->read_group_records('timeslot', 'timeslotDate', array('specialistId' => $userId));
if (count($g_time) > 0) {

    foreach ($g_time as $g_row):
        echo "['" . $g_row->timeslotDate . "', " . count($this->crudmod->get_where('timeslot', 'timeslotDate', $g_row->timeslotDate)) . "],";
    endforeach;
}else {
    echo "['NULL',0]";
}
?>
                ]);
                var options = {
                    title: "Total No. of Timeslots",
                    bar: {groupWidth: '100%'},
                    legend: {position: 'none'},
                    hAxis: {
                        title: 'Time of the day'
                    },
                    vAxis: {
                        title: 'Total No. of Timeslots'
                    }
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>
    </body>

</html>