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
                                                <h3 class="m-b-xs text-black">Appointment details</h3> 
                                            </div>
                                        </section>

                                        <div class="pad-content">
                                            <?php if (null != validation_errors() || null != $this->session->flashdata('error') || null != $this->session->flashdata('success')) { ?>
                                                <div class="alert alert-<?= null == $this->session->flashdata('success') ? 'warning' : 'success' ?>">
                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                    <?= validation_errors() ?>
                                                    <?= $this->session->flashdata('error') ?>
                                                    <?= $this->session->flashdata('success') ?>
                                                </div>
                                            <?php }
                                            ?>


                                            <?php
                                            if ($userGroup == 3) {
                                                ?>
                                                <header class="header m-b-md b-b b-light hidden-print">

                                                    <?php
                                                    if ($appointmentDetails['appointmentStatus'] == 1) {
                                                        ?>
                                                        <form method="post" action="<?= base_url("cancel-appointment"); ?>">
                                                            <input type="hidden" name="appKey" id="appKey" value="<?= $appointmentDetails['appointmentId']; ?>"/>
                                                            <button type="submit" class="btn btn-sm btn-danger pull-right">
                                                                <i class="i i-cross2"></i>
                                                                Cancel
                                                            </button>
                                                        </form>
                                                        <form method="post" action="<?= base_url("confirm-appointment"); ?>">
                                                            <input type="hidden" name="appKey" id="appKey" value="<?= $appointmentDetails['appointmentId']; ?>"/>
                                                            <button type="submit" class="btn btn-sm btn-success pull-right m-r-sm">
                                                                <i class="i i-checkmark2"></i>
                                                                Confirm
                                                            </button>
                                                        </form>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($appointmentDetails['appointmentStatus'] == 2) {
                                                        ?>
                                                        <form method="post" action="<?= base_url("cancel-appointment"); ?>">
                                                            <input type="hidden" name="appKey" id="appKey" value="<?= $appointmentDetails['appointmentId']; ?>"/>
                                                            <button type="submit" class="btn btn-sm btn-danger pull-right">
                                                                <i class="i i-cross2"></i>
                                                                Cancel
                                                            </button>
                                                        </form>
                                                        <form method="post" action="<?= base_url("clear-appointment"); ?>">
                                                            <input type="hidden" name="appKey" id="appKey" value="<?= $appointmentDetails['appointmentId']; ?>"/>
                                                            <button type="submit" class="btn btn-sm btn-warning pull-right m-r-sm">
                                                                <i class="i i-checkmark2"></i>
                                                                Clear
                                                            </button>
                                                        </form>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($appointmentDetails['appointmentStatus'] == 0) {
                                                        ?>

                                                        <form method="post" action="<?= base_url("confirm-appointment"); ?>">
                                                            <input type="hidden" name="appKey" id="appKey" value="<?= $appointmentDetails['appointmentId']; ?>"/>
                                                            <button type="submit" class="btn btn-sm btn-success pull-right m-r-sm">
                                                                <i class="i i-checkmark2"></i>
                                                                Re-activate
                                                            </button>
                                                        </form>
                                                        <?php
                                                    }
                                                    ?>


                                                    <p>Confirm or cancel this appointment</p> 
                                                </header>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if ($appointmentDetails['appointmentStatus'] == 0 & $userGroup != 3) {
                                                ?>
                                                <header class="header m-b-md b-b b-light hidden-print">
                                                    <a href="<?= base_url("writeareview/" . $appointmentDetails['specialistId']); ?>" class="btn btn-sm btn-success pull-right m-r-sm">
                                                        <i class="i i-star2"></i>
                                                        Write a review
                                                    </a>
                                                    <p>How did the appointment go? Write a review</p> 
                                                </header>  
                                                <?php
                                            }
                                            ?>




                                            <div class="row">
                                                <div class="col-md-4">
                                                    <section class="panel clearfix bg-white dk">
                                                        <div class="panel-body">
                                                            <a class="thumb pull-left m-r">
                                                                <img src="<?= base_url("avatars/default_profile.png"); ?>" alt="P" class="img-circle b-a b-3x b-white"> 
                                                            </a>
                                                            <div class="clear">
                                                                <a class="text-black">
                                                                    <?= $appointmentDetails['patientName']; ?>
                                                                </a> 
                                                                <small class="block text-muted">
                                                                    <i class="i i-location"></i> <?= $appointmentDetails['patientLocation']; ?>
                                                                    <i class="i i-dot"></i>
                                                                    <i class="i i-phone3"></i> <?= $appointmentDetails['patientMobile']; ?>
                                                                </small> 

                                                                <?php
                                                                if ($appointmentDetails['visitedBefore'] == 1) {
                                                                    ?>
                                                                    <a class="btn btn-xs btn-default m-t-xs">Returning patient</a> 
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a class="btn btn-xs btn-success m-t-xs">New patient</a> 
                                                                    <?php
                                                                }
                                                                ?>

                                                            </div>
                                                        </div>
                                                    </section>

                                                    <?php
                                                    if ($userGroup == 3) {
                                                        ?>
                                                        <section class="panel panel-default">
                                                            <h4 class="padder">Past appointment records</h4>
                                                            <ul class="list-group">

                                                                <?php
                                                                if (count($passedRecords) > 0) {
                                                                    foreach ($passedRecords as $row):
                                                                        $passedReason = $this->crudmod->read_one('symptoms', array('symptomId' => $row->visitMainReason))['symptomName'];
                                                                        $passedDate = $row->appointmentBookTime;
                                                                        ?>
                                                                        <li class="list-group-item">
                                                                            <p><?= $passedReason; ?></p> 
                                                                            <small class="block text-muted">
                                                                                <i class="i i-calendar"></i> 
                                                                                on <?= $passedDate; ?>
                                                                            </small> 
                                                                        </li>
                                                                        <?php
                                                                    endforeach;
                                                                } else {
                                                                    ?>
                                                                    <li class="list-group-item">
                                                                        <div class="alert alert-info">No past records!</div>  
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>


                                                            </ul>
                                                        </section>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <ul class="nav nav-tabs m-b-n-xxs">
                                                                <li class="active"> <a href="#details" data-toggle="tab">Summary</a> </li>
                                                                <?php
                                                                if ($userGroup == 3) {
                                                                    ?>
                                                                    <li class=""> <a href="#reschedule" data-toggle="tab">Update</a> </li>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </ul>

                                                            <div class="tab-content">
                                                                <div class="tab-pane wrapper-lg active" id="details">
                                                                    <div class="row m-b">
                                                                        <div class="col-xs-6">
                                                                            <small class="text-lt font-bold">Status</small>
                                                                            <div class="text-lt">
                                                                                <i class="i i-info"></i>
                                                                                <?php
                                                                                if ($appointmentDetails['appointmentStatus'] == 1) {
                                                                                    ?>
                                                                                    <span class="text-success">Waiting confirmation</span>
                                                                                    <?php
                                                                                } else if ($appointmentDetails['appointmentStatus'] == 2) {
                                                                                    ?>
                                                                                    <span class="text-success">Confirmed</span>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <span class="text-danger">Cleared or canceled</span>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xs-6">
                                                                            <small class="text-lt font-bold">Visiting time</small>
                                                                            <?php
                                                                            $timeslotTime = $timeslotDetails['timeslotTime'];
                                                                            $timeslotDate = $timeslotDetails['timeslotDate'];

                                                                            $new_timeslotdate = str_replace("/", "-", $timeslotDate);

                                                                            $dateDisplay = date("l d, M Y", strtotime($timeslotDate));
                                                                            ?>
                                                                            <div class="text-lt"><?= $dateDisplay; ?> at <?= $timeslotTime; ?></div>
                                                                        </div>
                                                                    </div>
                                                                    <div> 
                                                                        <small class="text-lt font-bold">Visit reason</small>
                                                                        <div class="text-lt">
                                                                            <?= $this->crudmod->read_one('symptoms', array('symptomId' => $appointmentDetails['visitMainReason']))['symptomName']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <br/>
                                                                    <div> 
                                                                        <small class="text-lt font-bold">Other symptoms</small>
                                                                        <div class="text-lt">
                                                                            <?= $appointmentDetails['visitReason']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <br/>
                                                                    <div> 
                                                                        <small class="text-lt font-bold">Other details</small>
                                                                        <div class="text-lt">
                                                                            <?= $appointmentDetails['visitOther']; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                if ($userGroup == 3) {
                                                                    ?>
                                                                    <div class="tab-pane wrapper-lg" id="reschedule">
                                                                        <div class="form-error">
                                                                            <div id="errorMessage">

                                                                            </div>
                                                                        </div>
                                                                        <p class="help-block">Update or reschedule appointment's <strong>time</strong> by changing visiting date or time</p>
                                                                        <form method="post" action="<?= base_url("reschedule"); ?>" id="rev">
                                                                            <input type="hidden" name="appKey" id="appKey" value="<?= $appointmentDetails['appointmentId']; ?>"/>
                                                                            <div id="datetimepicker2" class="input-append form-group">
                                                                                <input data-format="MM/dd/yyyy HH:mm PP" type="text" name="edittimeslot" id="edittimeslot" value="<?= $timeslotDate . ' ' . $timeslotTime; ?>" placeholder="MM/DD/YYYY HH:mm PP" class="form-control">
                                                                                <span class="add-on">
                                                                                    <i data-time-icon="i i-clock2" data-date-icon="i i-calendar"></i>
                                                                                </span>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input value="Save changes" class="btn btn-s-md btn-success" type="submit">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
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
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(".clickable-row").click(function () {
                    window.location = $(this).data("href");
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