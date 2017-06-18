
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Appointment Payment</title>

        <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">
        <link rel="shortcut icon" href="<?= base_url('khyp/imgs/favicon.png'); ?>">

    </head>
    <body id="main-page">

        <header>
            <div class="container">
                <div class="search-container page-banner pay">

                    <div class="text-white">
                        <h2 class="home-logo" id="logo">
                            Finish by confirming your appointment 
                        </h2>
                        <div class="centered-title">
                            <p>Payment confirmation</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>



        <div class="container">
            <section class="page-content" id="vue-app">
                <div class="info-header">
                    <div class="row">
                        <p class="info-prompt">
                            Confirm payment
                        </p>
                    </div>
                </div>
                <section class="cards-container">
                    <div class="tickets-container" style="overflow: hidden">
                        <div class="paybill zoom-transition">
                            <div>
                                <div id="if-you-have-paid" style="margin-top: 15px">
                                    <p>Enter your payment mobile number and transaction code to confirm payment</p>

                                </div>

                                <?php if (null != validation_errors() || null != $this->session->flashdata('error') || null != $this->session->flashdata('success')) { ?>
                                    <div class="alert alert-<?= null == $this->session->flashdata('success') ? 'danger' : 'success' ?>">
                                        <?= validation_errors() ?>
                                        <?= $this->session->flashdata('error') ?>
                                        <?= $this->session->flashdata('success') ?>
                                    </div>
                                <?php }
                                ?>

                                <form method="post" action="<?= base_url('payment/confirm'); ?>">
                                    <input type="hidden" name="appKey" value="<?= $_GET['refrence']; ?>"/>
                                    <div class="form-group">
                                        <input type="text" class="confirm-input" required="" name="transactionNumber" placeholder="transaction number" value="+2547"/>
                                        <p class="help-block text-danger">Format must be +2547*********</p>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="confirm-input" required="" name="transactionCode" placeholder="transaction code"/>
                                    </div>

                                    <div id="if-you-have-paid" style="margin-top: 15px">
                                        <button type="submit" class="btn btn-block btn-mookh">Confirm payment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </div>






        <script src="<?= base_url('khyp/js/jquery.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/bootstrap.min.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/custom.min.js'); ?>"></script>


    </body>
</html>
