<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title> <?= $job_details['j_title']; ?> - mobdoc Jobs</title>

        <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url('khyp/imgs/fav/apple-icon-57x57.png'); ?>">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url('khyp/imgs/fav/apple-icon-60x60.png'); ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url('khyp/imgs/fav/apple-icon-72x72.png'); ?>">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('khyp/imgs/fav/apple-icon-76x76.png'); ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url('khyp/imgs/fav/apple-icon-114x114.png'); ?>">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('khyp/imgs/fav/apple-icon-120x120.png'); ?>">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url('khyp/imgs/fav/apple-icon-144x144.png'); ?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('khyp/imgs/fav/apple-icon-152x152.png'); ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('khyp/imgs/fav/apple-icon-180x180.png'); ?>">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?= base_url('khyp/imgs/fav/android-icon-192x192.png'); ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('khyp/imgs/fav/favicon-32x32.png'); ?>">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('khyp/imgs/fav/favicon-96x96.png'); ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('khyp/imgs/fav/favicon-16x16.png'); ?>">
        <link rel="manifest" href="<?= base_url('khyp/imgs/fav/manifest.json'); ?>">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?= base_url('khyp/imgs/fav/ms-icon-144x144.png'); ?>">
        <meta name="theme-color" content="#ffffff">

        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">

    </head>
    <body>


        <?php $this->view('header'); ?>



        <div class="container" id="profile">

            <div class="page-header">
                <h1>
                    <small>
                        <a href="<?= base_url(); ?>">All jobs</a>
                    </small>
                    <br/>
                    <?= $job_details['j_title']; ?>
                </h1>
            </div>

            <div class="row">
                <div class="col-md-8">

                    <div class="job-details">
                        <h5>Your responsibilities will include:</h5>
                        <p>
                            <?= $job_details['j_expectation']; ?>
                        </p>

                        <br/>

                        <h5>The minimum qualifications/requirements are:</h5>
                        <p>
                            <?= $job_details['j_requirement']; ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <b> <i class="i i-home"></i> Company:</b> <?= $job_details['j_company']; ?><br/>
                    <b> <i class="i i-location"></i> Location:</b> <?= $job_details['j_location'];?>
                    
                    <br/>
                    <br/>
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">How to apply</h3>
                        </div>
                        <div class="panel-body">
                            Interested? <?= $job_details['j_howtoapply']; ?>
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