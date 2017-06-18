<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Mobdoc - Password Reset</title>

        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/account.css'); ?>">
        <link rel="shortcut icon" href="<?= base_url('khyp/imgs/favicon.png'); ?>">

    </head>
    <body style="background: #fff;">

        <span id="home-root" class="account-home">
            <section class="home-sub-sec">
                <main class="home-main" role="main">

                    <article class="home-article">
                        <div class="home-account-pane">
                            <div class="home-account-pane-top">
                                <h1 class="home-account-pane-top-logo"><a href="<?= base_url();?>">mobdoc.</a></h1>
                                <div class="home-account-pane-top-form">
                                    <form class="home-account-pane-top-form-act" method="post" action="<?= base_url('signup'); ?>">
                                        <div class="home-account-pane-top-form-group">
                                            <p class="help-block">Enter account email to get a reset link</p>
                                            <input class="home-account-pane-top-form-input" required="true" autocapitalize="off" autocorrect="off" maxlength="30" name="signmail" placeholder="email" value="<?= set_value('signmail'); ?>" type="text">
                                        </div>
                                        <span class="home-account-pane-top-form-button">
                                            <button type="submit" class="home-account-pane-top-form-btn home-account-pane-top-form-btn-primary home-cousor home-padding">Reset password</button>
                                        </span>
                                    </form>
                                </div>
                            </div>
                            <div class="home-account-pane-top">
                                <p class="home-account-option">
                                    Already have your password? 
                                    <a class="home-account-option-link" href="<?= base_url('signin'); ?>">Sign In</a>
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