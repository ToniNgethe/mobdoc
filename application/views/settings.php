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
        <title> Your Profile </title>
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url("admn/css/admin.css"); ?>"/>
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
                                        <section class="row m-b-md header-banner">
                                            <div class="col-sm-6">
                                                <h3 class="m-b-xs text-black">My profile</h3> 
                                            </div>
                                        </section>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="list-group">
                                                    <a href="<?= base_url('user/profile'); ?>" class="list-group-item active">Profile</a>
                                                    <a href="<?= base_url('settings/account'); ?>" class="list-group-item">Account</a>
                                                    <a href="<?= base_url('settings/mobile'); ?>" class="list-group-item"><span class="hidden-sm hidden-xs">Mobile and Emails</span><span class="hiddev-md hidden-lg">Contact</span></a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                <form method="post" action="<?= base_url('update-profile'); ?>">
                                                                    <div class="form-group">
                                                                        <label for="pname">Name</label>
                                                                        <input type="text" class="form-mine" name="pname" id="pname" placeholder="e.g. joedoe" required="" value="<?= $user_details['fullname']; ?>"/>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="pgender">Gender</label>
                                                                            <select class="form-mine" required="true" autocapitalize="off" autocorrect="off" name="pgender">                                        
                                                                                <option value="<?= $user_details['gender']; ?>"><?= $user_details['gender']; ?></option>
                                                                                <option disabled="">Please select</option>
                                                                                <option value="M">Male</option>
                                                                                <option value="F">Female</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="pzip">Location</label>
                                                                            <input type="text" class="form-mine" name="pzip" id="pzip" onFocus="geolocate()" placeholder="e.g. Nairobi, Kenya" required="" value="<?= $user_details['zipcode']; ?>"/>
                                                                            <p class="help-block">*Use Google location to appear on map</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="submit" value="Update profile" class="form-btn"/>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
                                                $myusergroup = $session_data['usergroup'];
                                                if ($myusergroup == 3) {

                                                    $more_profile = $this->crudmod->get_record('specialist', 'userId', $user_details['userId']);
                                                    ?>


                                                    <div class="row">
                                                        <div class="col-md-7">

                                                            <div class="panel panel-default">
                                                                <div class="panel-body">
                                                                    <form method="post" action="<?= base_url('update-profesional'); ?>">
                                                                        <div class="form-group">
                                                                            <label for="specqualification">Academic qualification</label>
                                                                            <textarea class="form-mine" required="" name="specqualification" placeholder="Write your academic profile in relation to your medical profile"><?= $more_profile['qualification']; ?></textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="specdisplayname">Display Name</label>
                                                                            <input type="text" class="form-mine" name="specdisplayname" id="pzip" placeholder="e.g. Dr. Joe Doe Snr" required="" value="<?= $more_profile['displayName']; ?>"/>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="specFacility">Facility</label>
                                                                            <select class="form-mine" autocapitalize="off" autocorrect="off" name="specFacility">                                        
                                                                                <option selected value="">Select Facility type</option>
                                                                                <?php
                                                                                $all_facilities = $this->crudmod->get_all('facilities', 'facilityId');
                                                                                foreach ($all_facilities as $all_facilities_row):
                                                                                    $facility_id = $all_facilities_row->facilityId;
                                                                                    $facility_name = $all_facilities_row->facilityName;
                                                                                    printf('<option value="%s" %s>%s</option>', $facility_id, $more_profile['facilityId'] == $facility_id ? "selected" : "", $facility_name);
                                                                                endforeach;
                                                                                ?>
                                                                            </select>
                                                                            <p class="help-block">This is the facility you work from or in.</p>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="submit" value="Update professional profile" class="form-btn"/>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-md-offset-1">

                                                                    <?php echo form_open_multipart('update-photo'); ?>
                                                                    <div class="edit-avi">
                                                                        <div class="form-group">
                                                                            <label>Profile picture</label>
                                                                            <label for="user-avi">
                                                                                <img id="blah" alt="" class="avi-rounded" src="<?= base_url("avatars/" . $user_details['myavi']); ?>" height="200" width="200">
                                                                            </label>

                                                                            <input class="hidden" id="user-avi" type="file" name="userfile" size="20" onchange="readURL(this);" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="submit" value="Upload new picture" class="form-btn-upload"/>
                                                                        </div>
                                                                    </div>
                                                                    </form>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>


                                    </section>
                                </section>
                            </section>


                        </section>
                    </section>



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


                </section>
            </section>
        </section>
        <!-- Bootstrap -->
        <!-- App -->
        <script src="<?= base_url("admn/js/admin.js"); ?>"></script>
        <script src="<?= base_url("admn/js/app.plugin.js"); ?>"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqpWC20QTDao8n5EeYKSLbLXgrC6HqwIk&libraries=places&callback=initAutocomplete" async defer></script>

        <script src="<?= base_url('khyp/js/custom.min.js'); ?>"></script>

        <script type="text/javascript">

                                                                            function readURL(input) {
                                                                                if (input.files && input.files[0]) {
                                                                                    var reader = new FileReader();

                                                                                    reader.onload = function (e) {
                                                                                        $('#blah')
                                                                                                .attr('src', e.target.result);
                                                                                    };

                                                                                    reader.readAsDataURL(input.files[0]);
                                                                                }
                                                                            }
        </script>

    </body>
</html>