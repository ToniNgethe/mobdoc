<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title> Specialist :: My Schedule - Mobdoc</title>

        <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">

        <link rel="shortcut icon" href="<?= base_url('khyp/imgs/favicon.png'); ?>">

    </head>
    <body>


        <?php $this->view('header'); ?>



        <div class="container" id="profile">
            <div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li>
                        <a href="<?= base_url('specialist/dashboard'); ?>">
                            <i class="i i-statistics"></i> 
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('specialist/appointment'); ?>">
                            <i class="i i-alarm"></i> 
                            Appointments
                        </a>
                    </li>
                    <li class="active">
                        <a class="last-tab" href="<?= base_url('specialist/schedule'); ?>">
                            <i class="i i-calendar"></i> 
                            Schedule
                        </a>
                    </li>
                </ul>


            </div>
            <div class="row">
                <div class="col-md-9" id="rev">

                    <div class="page-header">
                        <h1 class="hidden-sm hidden-xs">
                            Available timeslots
                        </h1>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <p class="help-block">Create a <strong>new timeslot</strong> which will be added to your availability schedules</p>
                            <p class="help-block">Click on the <strong><i class="i i-calendar"></i></strong> icon to select date & time</p>
                            <form method="post" action="<?= base_url('save-timeslot'); ?>">
                                <div id="datetimepicker2" class="input-append form-group">
                                    <input data-format="MM/dd/yyyy HH:mm PP" type="text" name="timeslot" placeholder="MM/DD/YYYY HH:mm PP" class="form-mine">
                                    <span class="add-on">
                                        <i data-time-icon="i i-clock2" data-date-icon="i i-calendar"></i>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <input value="Save timeslot" class="form-btn" type="submit">
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
                    </div>






                </div>
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


        <?php $this->view('footer'); ?>


        <script src="<?= base_url('khyp/js/jquery.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/bootstrap.min.js'); ?>"></script>
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

    </body>
</html>