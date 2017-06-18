<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title> Admin :: User Profile - Mobdoc</title>

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">
        <link rel="shortcut icon" href="<?= base_url('khyp/imgs/favicon.png'); ?>">

    </head>
    <body>


        <?php $this->view('header'); ?>



        <div class="container" id="profile">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <?php
                        $session_data = $this->session->userdata('user_sess');
                        $myusername = $session_data['username'];
                        ?>
                        <a href="<?= base_url('admin/dashboard'); ?>" class="list-group-item">Dashboard</a>
                        <a href="<?= base_url('admin/specialist'); ?>" class="list-group-item">Specialist</a>
                        <a href="<?= base_url('admin/patient'); ?>" class="list-group-item">Patient</a>
                        <a href="<?= base_url('admin/appointment'); ?>" class="list-group-item">Appointment</a>
                    </div>
                </div>
                <div class="col-md-9" id="rev">

                    <!-- Gather user details -->
                    <?php
                    $viewed_user = $this->crudmod->get_record('user', 'userId', $viewed_id);
                    ?>


                    <div class="page-header">
                        <h1><?= $viewed_user['fullname']; ?>'s profile</h1>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <form>
                                <div class="form-group">
                                    <label for="pname">Name</label>
                                    <input type="text" class="form-mine" disabled="" name="pname" id="pname" placeholder="e.g. joedoe" required="" value="<?= $viewed_user['fullname']; ?>"/>
                                </div>

                                <?php
                                if ($viewed_user['user_group'] == 3) {
                                    $specialist_details = $this->crudmod->get_where('specialist', 'userId', $viewed_user['userId']);
                                    foreach ($specialist_details as $specialist_details_row) {
                                        $regNumber = $specialist_details_row->registrationNumber;
                                        $specialty = $specialist_details_row->specialtyId;
                                    }
                                    $viewed_specialty = $this->crudmod->get_record('specialty', 'specialtyId', $specialty);
                                    ?>
                                    <div class="form-group">
                                        <label for="">Registration Number</label>
                                        <input type="text" class="form-mine" disabled="" name="" id="" placeholder="e.g. MD894" required="" value="<?= $regNumber; ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Specialty</label>
                                        <input type="text" class="form-mine" disabled="" name="" id="" placeholder="e.g. Dentist" required="" value="<?= $viewed_specialty['sName']; ?>"/>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="form-group hidden">
                                    <input type="submit" value="Update profile" class="form-btn"/>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 col-md-offset-1">
                            <label>More user actions</label>

                            <?= form_open('edit-user/activate'); ?>
                            <div class="form-group">
                                <input type="hidden" name="user_key" value="<?= $viewed_user['userId']; ?>"/>
                                <?php
                                if ($viewed_user['mystatus'] != 1) {
                                    ?>
                                    <input type="submit" value="Activate account" class="form-btn-upload"/>
                                    <?php
                                } else {
                                    ?>
                                    <input type="submit" disabled="" value="Account is active" class="form-btn-upload"/>
                                    <?php
                                }
                                ?>
                            </div>
                            </form>

                            <?= form_open('edit-user/disable'); ?>
                            <div class="form-group">
                                <input type="hidden" name="user_key" value="<?= $viewed_user['userId']; ?>"/>
                                <?php
                                if ($viewed_user['mystatus'] == 1) {
                                    ?>
                                    <input type="submit" value="Disable account" class="form-btn-upload"/>
                                    <?php
                                }else {
                                    ?>
                                    <input type="submit" disabled="" value="Account is disabled" class="form-btn-upload"/>
                                    <?php
                                }
                                ?>
                            </div>
                            </form>

                            <?= form_open('edit-user/delete'); ?>
                            <div class="form-group">
                                <input type="hidden" name="user_key" value="<?= $viewed_user['userId']; ?>"/>
                                <?php
                                if ($viewed_user['mystatus'] != 2) {
                                    ?>
                                    <input type="submit" value="Delete account" class="form-btn-upload form-btn-disable"/>
                                    <?php
                                } else {
                                    ?>
                                    <input type="submit" disabled="" value="Account is deleted" class="form-btn-upload form-btn-disable"/>
                                    <?php
                                }
                                ?>
                            </div>                                   
                            </form>
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


    </body>
</html>