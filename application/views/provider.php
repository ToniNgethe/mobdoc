
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title><?= $displayName; ?></title>

        <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">
        <link rel="shortcut icon" href="<?= base_url('khyp/imgs/favicon.png'); ?>">

    </head>
    <body id="main-page">
        <div id="map"></div>
        <header class="header-map">

            <?php $this->view('header'); ?>


            <div class="container">
                <div class="search-container page-banner">

                    <div class="text-white">
                        <h2 class="home-logo" id="logo">
                            Book an Appointment with <?= $displayName; ?>    
                        </h2>
                        <div class="centered-title">
                            <p><?= $docLocation; ?> <span class="divider-bullet">•</span> <?= $docPhone; ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </header>


        <div class="provider">
            <div class="container">
                <div class="media">
                    <div class="media-left photo">
                        <a>
                            <img class="media-object" src="<?= base_url("avatars/$specialtyPhoto"); ?>" alt="<?= $displayName; ?>">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading"><?= $displayName; ?></h4>
                        <h5>Background</h5>
                        <ul class="list-unstyled">
                            <li>
                                <h6>Academic qualification</h6>
                                <p><?= $qualification ?></p>
                            </li>
                            <li>
                                <h6>Board Certification</h6>
                                <p><?= $docCertification['certificationName']; ?></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile">
            <div class="container">


                <?php if (null != validation_errors() || null != $this->session->flashdata('error') || null != $this->session->flashdata('success')) { ?>
                    <div class="alert alert-<?= null == $this->session->flashdata('success') ? 'danger' : 'success' ?>">
                        <?= validation_errors() ?>
                        <?= $this->session->flashdata('error') ?>
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php }
                ?>


                <div class="service-card card emergency-room regular">
                    <a href="<?= base_url("provider/$specialistId"); ?>" title="<?= $displayName; ?>" class="service-line-icon emergency-room hidden-sm hidden-xs"></a>

                    <div class="details hidden-sm hidden-xs">
                        <strong class="service-line-label"><?= $docSpecialty['sName']; ?></strong>
                        <h4>
                            <a title="<?= $displayName; ?>" href="<?= base_url("provider/$specialistId"); ?>"><?= $displayName; ?></a>
                        </h4>



                        <ul class="metadata">
                            <li class="location">
                                <?= $docLocation; ?>
                                <span class="bullet-divider">•</span>
                                KE
                            </li>

                            <li class="facility <?= $facilityClass; ?>">
                                <a href=""><?= $docFacility['facilityName']; ?></a>
                            </li>
                            <li class="phone">(254) <?= $docPhone; ?></li>
                        </ul>
                        <!-- end .metadata -->
                    </div>
                    <!-- end .details -->

                    <img class="hidden-sm hidden-xs provider-home-logo" src="<?= base_url("khyp/imgs/logo-provider.png"); ?>" alt="mobdoc"/>

                    <div class="week-select">
                        <h3>Today <?= date('M d, Y'); ?></h3>

                        <div class="navigation">
                            <a class="next-week">Choose Date</a>
                            <form method="post" action="" id="filter-provider">
                                <div id="datetimepicker2" class="input-append form-group">
                                    <input data-format="MM/dd/yyyy" type="text" name="filterdate" id="filterdate" placeholder="MM/DD/YYYY" class="form-mine">
                                    <span class="add-on">
                                        <i data-time-icon="i i-clock2" data-date-icon="i i-calendar"></i>
                                    </span>
                                </div>
                                <input type="hidden" name="specialistId" id="specialistId" value="<?= $specialistId; ?>" required=""/>
                                <div class="form-group">
                                    <button class="form-btn" type="submit"><i class="i i-search2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="time-picker-container">
                        <div class="time-picker-times">
                            <div id="timeslot-results">
                                <div class="time-picker">

                                    <ul class="available-times">
                                        <?php
                                        //Get timeslots
                                        $date_today = date("m/d/Y");
                                        $timeslots = $this->crudmod->get_timeslot('timeslot', 'specialistId', $specialistId, 'timeslotId', 'timeslotDate', $date_today);

                                        if (count($timeslots) > 0) {
                                            $time_output = '';
                                            foreach ($timeslots as $timeslots_row):
                                                $timeslotId = $timeslots_row->timeslotId;
                                                $timeslotTime = $timeslots_row->timeslotTime;
                                                ?>
                                                <li class="available-time">
                                                    <a class="button secondary" href="<?= base_url("startsignin?startTime=$timeslotId&professionalId=$specialistId"); ?>"><?= $timeslotTime; ?></a>
                                                </li>
                                                <?php
                                            endforeach;
                                        }else {
                                            echo 'No times available.';
                                        }
                                        ?>

                                    </ul>
                                    <!-- end .available-times -->

                                </div>
                            </div>
                            <!-- end .time-picker -->

                        </div>
                    </div>

                    <div class="week-select">
                        <h4>Verified reviews</h4>
                    </div>

                    <div class="time-picker-container">
                        <div class="time-picker-times">
                            <div id="timeslot-results">


                                <div class="row">
                                    <div class="col-md-7">


                                        <?php
                                        //Get reviews
                                        $reviews = $this->crudmod->read_records('review', array('reviewTarget' => $specialistId));
                                        if (count($reviews) > 0) {
                                            ?>
                                            <div class="list-group list-group-alt" id='reviews'>

                                                <?php
                                                foreach ($reviews as $reviews_row):
                                                    $reviewPublisher = $reviews_row->reviewPublisher;
                                                    $reviewContent = $reviews_row->reviewContent;
                                                    $reviewDate = $reviews_row->reviewDate;

                                                    //publisher
                                                    $publisher = $this->crudmod->read_one('user', array('userId' => $reviewPublisher));
                                                    ?>
                                                    <a class="media list-group-item">
                                                        <span class="pull-left thumb-sm">
                                                            <img src="<?= base_url("avatars/" . $publisher['myavi']); ?>" alt="PB" class="img-circle-review" />
                                                        </span>
                                                        <span class="media-body block m-b-none">
                                                            <?= $reviewContent; ?><br> 
                                                            <small class="text-muted"><?= date("d M", strtotime($reviewDate)); ?> at <?= date("h:m a", strtotime($reviewDate)); ?></small>
                                                        </span> 
                                                    </a>
                                                <?php endforeach; ?>

                                            </div>
                                            <?php
                                        }else {
                                            ?>
                                            <div class="alert alert-warning" role="alert"><?= $displayName; ?> has not yet been reviewed</div>
                                            <?php
                                        }
                                        ?>


                                    </div>


                                    <div class="col-md-5">

                                        <div class="alert alert-warning alert-block">
                                            <strong>Important</strong>
                                            <p>To post a review on <strong><?= $displayName; ?></strong>, you will need to reserve and visit him/her first</p>
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <!-- end .reviews -->

                        </div>
                    </div>



                </div>
            </div>
        </div>

        <script>
            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 18,
                    center: {
                        lat: -34.397,
                        lng: 150.644
                    }
                });
                var geocoder = new google.maps.Geocoder();

                geocodeAddress(geocoder, map);

            }

            function geocodeAddress(geocoder, resultsMap) {
                var address = "<?php echo $docLocation; ?>";
                geocoder.geocode({
                    'address': address
                }, function (results, status) {
                    if (status === 'OK') {
                        resultsMap.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: resultsMap,
                            position: results[0].geometry.location
                        });
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }

        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqpWC20QTDao8n5EeYKSLbLXgrC6HqwIk&callback=initMap">
        </script>


        <?php $this->view('footer'); ?>



        <script src="<?= base_url('khyp/js/jquery.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/bootstrap.min.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/custom.min.js'); ?>"></script>
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
                pickTime: false, // disables de time picker
                pick12HourFormat: false, // enables the 12-hour format time picker
                pickSeconds: false, // disables seconds in the time picker
                startDate: dateToday, // set a minimum date
                endDate: Infinity          // set a maximum date
            };
        </script>

    </body>



</html>
