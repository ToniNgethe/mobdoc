
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
                            Proceed by paying for your appointment 
                        </h2>
                        <div class="centered-title">
                            <p>Procedure listed below</p>
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
                            please follow these instructions to pay via M-PESA.
                        </p>
                    </div>
                </div>
                <section class="cards-container">
                    <div class="tickets-container" style="overflow: hidden">
                        <div class="paybill zoom-transition">
                            <div>
                                <div class="center-block">
                                    <ol class="text-left" style="list-style-type: decimal">
                                        <li>Go to your M-PESA Menu</li>
                                        <li>Select Lipa na M-PESA</li>
                                        <li>Select Buy Goods and Services</li>
                                        <li>Enter Till No <strong>976149 </strong></li>
                                        <li>Enter Amount <strong>KSh. <?= $this->crudmod->get_record('billing', 'specialistId', $this->crudmod->read_one('appointment', array('appointmentId' => $_GET['refrence']))['specialistId'])['billAmount']; ?></strong></li>
                                        <li>Enter Your M-PESA Pin</li>
                                    </ol>
                                </div>
                                <div id="if-you-have-paid" style="margin-top: 15px">
                                    <hr>
                                    <p>If you have paid, please press the button below to continue.</p>
                                    <a href="<?= base_url("pay/confirm?refrence=" . $_GET['refrence']); ?>" class="btn btn-block btn-mookh">Continue</a>
                                </div>
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
