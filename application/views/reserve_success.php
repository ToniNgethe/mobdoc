<?php
$reserveDetails = $this->crudmod->get_record('appointment', 'appointmentId', $reserve);
$providerReserveId = $reserveDetails['specialistId'];
$placedbyReserveId = $reserveDetails['patientId'];

$providerSpecDetails = $this->crudmod->get_record('specialist', 'userId', $providerReserveId);
$providerDetails = $this->crudmod->get_record('user', 'userId', $providerReserveId);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Appointment Booking Successful</title>

        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">
        <link rel="shortcut icon" href="<?= base_url('khyp/imgs/favicon.png'); ?>">

    </head>
    <body id="main-page">

        <header>

            <?php $this->view('header'); ?>


            <div class="container">
                <div class="search-container page-banner">

                    <div class="text-white">
                        <div class="img-success">
                            <div class="book-img"></div>
                        </div>
                        <h2 class="home-logo" id="logo">
                            Booked an Appointment with <?= $providerSpecDetails['displayName']; ?>    
                        </h2>
                        <div class="centered-title">
                            <p><?= $providerDetails['zipcode']; ?> <span class="divider-bullet">•</span> <?= $providerDetails['myphone']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </header>


        <div class="container">
            <br/>
            <div class="row">
                <div class="col-md-5">
                    <div class="book">
                        <div class="visit-preperation">
                            <strong>Your appointment has been successfully booked</strong>
                            <p>To view and manage your appointment, click the link below</p>


                            <div class="startchoose">
                                <a href="<?= base_url("patient/pastappointments");?>" class="">
                                    <i class="i i-tag2"></i>
                                    Manage appointment
                                </a>
                            </div>

                            <br>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                When
                                <span class="pull-right">May 05, 2017 - 10:00 PM</span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="service-card card emergency-room regular">
                                <a href="http://localhost/mobdoc/provider/10" title="Dr. Moses Mwendwa" class="service-line-icon emergency-room" style=""></a>

                                <div class="details">
                                    <strong class="service-line-label">Infectious Diseases</strong>
                                    <h4>
                                        <a>Dr. Moses Mwendwa</a>
                                    </h4>



                                    <ul class="metadata">
                                        <li class="location">
                                            Nairobi                                                    <span class="bullet-divider">•</span>
                                            KE
                                        </li>

                                        <li class="facility ">
                                            <a href="">Clinic</a>
                                        </li>
                                        <li class="phone">(254) 0705357155</li>
                                    </ul>
                                    <!-- end .metadata -->
                                </div>
                                <!-- end .details -->

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php $this->view('footer'); ?>



        <script src="<?= base_url('khyp/js/jquery.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/bootstrap.min.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/custom.min.js'); ?>"></script>
    </body>



</html>
