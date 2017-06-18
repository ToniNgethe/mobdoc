<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Mobdoc - Sign In</title>

        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/account.css'); ?>">
        <link rel="shortcut icon" href="<?= base_url('khyp/imgs/favicon.png'); ?>">

    </head>
    <body style="background: #fff;" class="acc">
        
        
        <?php $this->view('header'); ?>


        <span id="home-root" class="account-home">
            <section class="home-sub-sec">
                <main class="home-main" role="main">

                    <article class="home-article">
                        <div class="home-account-pane">
                            <div class="home-account-pane-top">
                                <div class="home-account-pane-top-logo">
                                    <h1>Sign in or Create account</h1>
                                </div>
                                <div class="home-account-pane-top-form">
                                    <form class="home-account-pane-top-form-act" method="post" action="<?= base_url('login'); ?>">
                                        <input type="hidden" name="red" id="red" value="<?= $red; ?>"/>
                                        <div class="home-account-pane-top-form-group">
                                            <input class="home-account-pane-top-form-input" required="true" autocapitalize="off" autocorrect="off" maxlength="30" name="logmailorname" placeholder="email address" value="<?= set_value('logmailorname'); ?>" type="text">
                                        </div>
                                        <div class="home-account-pane-top-form-group">
                                            <input class="home-account-pane-top-form-input" required="true" autocapitalize="off" autocorrect="off" name="logpassword" placeholder="password" value="" type="password">
                                            <div class="home-account-pane-top-form-reset">
                                                <a class="home-account-pane-top-form-reset-link hidden" href="<?= base_url('password/reset'); ?>">Forgot?</a>
                                            </div>
                                        </div>
                                        <span class="home-account-pane-top-form-button">
                                            <button type="submit" class="home-account-pane-top-form-btn home-account-pane-top-form-btn-primary home-cousor home-padding">Sign in</button>
                                        </span>
                                    </form>
                                </div>
                            </div>
                            <div class="home-account-pane-top">
                                <p class="home-account-option">
                                    Don't have an account? 
                                    <a class="home-account-option-link" href="<?= base_url('create-account'); ?>">Create Account</a>
                                </p>
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