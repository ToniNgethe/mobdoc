<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title> <?= $viewed_user['fullname']; ?>  - Mobdoc</title>

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
                    <li class="active">
                        <a href="<?= base_url('patient/medical'); ?>">
                            <i class="i i-users3"></i> 
                            Medical History
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('patient/pastappointments'); ?>">
                            <i class="i i-alarm"></i> 
                            Past Appointments
                        </a>
                    </li>
                    <li>
                        <a class="last-tab" href="<?= base_url('user/profile'); ?>">
                            <i class="i i-cog2"></i> 
                            Settings
                        </a>
                    </li>
                </ul>


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