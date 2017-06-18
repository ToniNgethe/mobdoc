<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Mobdoc - Thank You For Listing Your Practice</title>

        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/account.css'); ?>">
        <link rel="shortcut icon" href="<?= base_url('khyp/imgs/favicon.png'); ?>">

    </head>
    <body style="background: #fafafa;">

        <span id="home-root" class="account-home">
            <section class="home-sub-sec">
                <main class="home-main" role="main">

                    <article class="home-article">
                        <div class="home-account-pane">
                            <div class="home-account-pane-top">
                                <h1 class="home-account-pane-top-logo"><a href="<?= base_url(); ?>">mobdoc.</a></h1>
                                <div class="home-account-pane-top-form">

                                    <div class="home-success-thanks">
                                        <div class="alert alert-success">
                                            Application Successful
                                        </div>
                                    </div>

                                    <div class="home-success-mesg">
                                        <?php
                                        $cur_specialist = $this->crudmod->get_record('user', 'userId', $user);
                                        ?>
                                        Hi <?= $cur_specialist['fullname']; ?>,<br/>
                                        Your application was successful. Our team will get back to you
                                    </div>
                                </div>
                            </div>

                            <div class="home-account-copyright">
                                <p class="home-account-copyright-link">© 2017 mobdoc</p>
                            </div>
                        </div>
                    </article>
                </main>

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

        </span>



        <script src="<?= base_url('khyp/js/jquery.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/bootstrap.min.js'); ?>"></script>

    </body>


</html>