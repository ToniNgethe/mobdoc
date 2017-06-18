
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Visit <?= $displayName; ?></title>

        <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

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
                        <h2 class="home-logo" id="logo">
                            Book an Appointment with <?= $displayName; ?>    
                        </h2>
                        <div class="centered-title">
                            <p><?= $docLocation; ?> <span class="divider-bullet">•</span> <?= $docPhone; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="profile">
            <div class="container">

                <div class="form-error">
                    <div id="errorMessage">

                    </div>
                </div>

                <?php
                if ($this->session->userdata('user_sess')) {
                    $session_data = $this->session->userdata('user_sess');
                    $myid = $session_data['userId'];



                    $my_details = $this->crudmod->get_record('user', 'userId', $myid);
                    ?>

                    <form method="post" action="" id="reserve-form">
                        <input type="hidden" name="placedBy" id="placedBy" required="true" value="<?= $myid; ?>"/>
                        <input type="hidden" name="providerKey" id="providerKey" required="true" value="<?= $providerId; ?>"/>
                        <input type="hidden" name="scheduleKey" id="scheduleKey" required="true" value="<?= $scheduleId; ?>"/>
                        <!-- Medical info -->
                        <div class="row">
                            <div class="col-md-3 hidden-sm hidden-xs">
                                <div class="form-description-medical">
                                    <h4>Medical Information</h4>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <?php
                                //Check if fee is charged
                                $checkFee = $this->crudmod->get_record('billing', 'specialistId', $providerId);
                                if (count($checkFee) > 0) {
                                    if ($checkFee['payLater'] != FALSE) {
                                        $payMessage = " before or upon visiting the doctor";
                                    } else {
                                        $payMessage = " before visiting the doctor";
                                    }
                                    ?>
                                    <div class="alert alert-warning">
                                        <label>Important</label>
                                        <p>You are expected to pay <strong>KSh. <?= $checkFee['billAmount'] . '</strong> ' . $payMessage; ?></p>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="booking-form">
                                    <div class="visiting-time">
                                        <label>
                                            Projected Visiting Time
                                        </label>
                                        <?php
                                        //Get timeslot
                                        $timeslots = $this->crudmod->get_where('timeslot', 'timeslotId', $this->input->get('startTime'));

                                        if (count($timeslots) > 0) {
                                            foreach ($timeslots as $timeslots_row) {
                                                $timeslotId = $timeslots_row->timeslotId;
                                                $timeslotTime = $timeslots_row->timeslotTime;
                                                $timeslotDate = $timeslots_row->timeslotDate;

                                                $new_timeslotdate = str_replace("/", "-", $timeslotDate);

                                                $dateDisplay = date("l d, M Y", strtotime($timeslotDate));
                                            }
                                        } else {
                                            echo '';
                                        }
                                        ?>
                                        <p><?= $dateDisplay; ?> at <?= $timeslotTime; ?></p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="visitBill">Medical bill payments/coverage? <span class="text-danger"><sup>*</sup></span></label>
                                        <select class="form-mine" autocapitalize="off" autocorrect="off" name="visitBill" id="visitBill">                                        
                                            <option selected='true' value="4">I'm paying for myself</option>
                                            <?php
                                            $all_accepted = $this->crudmod->get_where_two('specialist_insurance', 'specialistId', $providerId, 'specInsStatus', TRUE);
                                            foreach ($all_accepted as $all_accepted_row):
                                                $accepted_insurance = $this->crudmod->read_one('insurance', array('insuranceId'=>$all_accepted_row->insuranceId));
                                                printf('<option value="%s">%s</option>', $accepted_insurance['insuranceId'], $accepted_insurance['insuranceName']);
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="visitReason">What's the reason for your visit? <span class="text-danger"><sup>*</sup></span></label>
                                        <select class="form-mine" autocapitalize="off" autocorrect="off" name="visitReason" id="visitReason">                                        
                                            <option selected value="">Select one of the available reasons</option>
                                            <?php
                                            $all_reasons = $this->crudmod->get_all('symptoms', 'symptomId');
                                            foreach ($all_reasons as $all_reasons_row):
                                                $reason_id = $all_reasons_row->symptomId;
                                                $reason_name = $all_reasons_row->symptomName;
                                                printf('<option value="%s">%s</option>', $reason_id, $reason_name);
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="visitMore">Any additional symptoms different from the above selected? </label>
                                        <textarea class="form-mine" name="visitMore" id="visitMore" placeholder=""></textarea>
                                        <p class="help-block">You can write more info  you're feeling, symptoms etc.</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Have you visited this doctor before? <span class="text-danger"><sup>*</sup></span></label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="visitBefore" id="visitBefore" value="1"> Yes
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="visitBefore" id="visitBefore" value="0">  No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Personal info -->
                        <div class="row">
                            <div class="col-md-3 hidden-sm hidden-xs">
                                <div class="form-description-person">
                                    <h4>Personal Information</h4>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="booking-form">

                                    <!-- User yes -->
                                    <div>
                                        <div class="form-group">
                                            <label for="visitName">Full name <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" name="visitName" id="visitName" class="form-mine" required="true" placeholder="" value="<?php echo $my_details['fullname']; ?>"/>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="visitEmail">Email address <span class="text-danger"><sup>*</sup></span></label>
                                                    <input type="email" name="visitEmail" id="visitEmail" class="form-mine" required="true" placeholder="" value="<?php echo $my_details['email']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="visitPhone">Phone number <span class="text-danger"><sup>*</sup></span></label>
                                                    <input type="tel" name="visitPhone" id="visitPhone" class="form-mine" required="true" placeholder="" value="<?php echo $my_details['myphone']; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="visitLocation">Location <span class="text-danger"><sup>*</sup></span></label>
                                                    <input type="text" name="visitLocation" id="visitLocation" class="form-mine" required="true" placeholder="" value="<?php echo $my_details['zipcode']; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="visitOther">Any other details different from the above submitted</label>
                                        <textarea class="form-mine" name="visitOther" id="visitOther" placeholder=""></textarea>
                                    </div>


                                </div>


                                <div class="book-form">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <button type="submit" class="btn-book">
                                                Continue to Confirmation
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <?php
                } else {
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="book">
                                <div class="visit-preperation">
                                    <strong>Have you used Mobdoc before?</strong>
                                    <p>We'll use the information from your account details.</p>


                                    <div class="startchoose">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="startchoosea" id="signin-sc"> I've used Mobdoc before.
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="startchoosea" id="signup-sc">  I'm new to Mobdoc.
                                            </label>
                                        </div>

                                    </div>

                                    <br/>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="startLogin" class="hidden">
                                            <form method="post" action="<?= base_url('login'); ?>">
                                                <input type="hidden" name="red" id="red" value="<?= "startsignin?startTime=" . $this->input->get('startTime') . "&professionalId=$specialistId"; ?>"/>
                                                <div class="form-group">
                                                    <label for="logmailorname">Email address</label>  
                                                    <input type="email" name="logmailorname" id="logmailorname" placeholder="Email address" required="" class="form-mine"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="logpassword">Password</label>  
                                                    <input type="password" name="logpassword" id="logpassword" placeholder="Password" required="" class="form-mine"/>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-account" value="Sign in"/>
                                                </div>
                                            </form>
                                        </div>

                                        <div id="startJoin" class="hidden">
                                            <form method="post" action="<?= base_url('signup'); ?>">
                                                <input type="hidden" name="red" id="red" value="<?= "startsignin?startTime=" . $this->input->get('startTime') . "&professionalId=$specialistId"; ?>"/>
                                                <div class="form-group">
                                                    <label for="signusername">Full name</label>  
                                                    <input type="text" name="signusername" id="signusername" placeholder="Full name" required="" class="form-mine"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="signmail">Email address</label>  
                                                    <input type="email" name="signmail" id="signmail" placeholder="Email address" required="" class="form-mine"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="signpassword">Password</label>  
                                                    <input type="password" name="signpassword" id="signpassword" placeholder="Create a password" required="" class="form-mine"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="signgender">Gender</label> 
                                                    <select name="signgender" id="signgender" required="" class="form-mine">
                                                        <option selected="" disabled="">Please select</option>
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-account" value="Create account"/>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>


            </div>
        </div>

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
