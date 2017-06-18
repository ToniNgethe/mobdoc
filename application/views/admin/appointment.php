<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title> Admin :: Appointment - Mobdoc</title>

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
                        <a href="<?= base_url('admin/appointment'); ?>" class="list-group-item active">Appointment</a>
                    </div>
                </div>
                <div class="col-md-9" id="rev">

                    <div class="page-header">
                        <h1 class="hidden-sm hidden-xs"><i class="i i-clock"></i> System appointments</h1>
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