<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Mobdoc - List Your Practice</title>

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
                                    <h1>List practice on Mobdoc</h1>
                                </div>
                                <div class="home-account-pane-top-form">
                                    <form class="home-account-pane-top-form-act" method="post" action="<?= base_url('practice/join'); ?>">
                                        <div class="home-account-pane-top-form-group">
                                            <input class="home-account-pane-top-form-input" required="true" autocapitalize="off" autocorrect="off" maxlength="30" name="specname" placeholder="fullname" value="<?= set_value('specname'); ?>" type="text">
                                        </div>
                                        <div class="home-account-pane-top-form-group">
                                            <input class="home-account-pane-top-form-input" required="true" autocapitalize="off" autocorrect="off" maxlength="30" name="specphone" placeholder="phone number" value="<?= set_value('specphone'); ?>" type="text">
                                        </div>
                                        <div class="home-account-pane-top-form-group">
                                            <input class="home-account-pane-top-form-input" required="true" autocapitalize="off" autocorrect="off" maxlength="30" name="specemail" placeholder="email" value="<?= set_value('specemail'); ?>" type="email">
                                        </div>                                        
                                        <div class="home-account-pane-top-form-group">
                                            <input class="home-account-pane-top-form-input" required="true" autocapitalize="off" autocorrect="off" maxlength="30" name="specpassword" placeholder="create a password" value="<?= set_value('specpassword'); ?>" type="password">
                                        </div>
                                        <div class="home-account-pane-top-form-group">
                                            <input class="home-account-pane-top-form-input" required="true" autocapitalize="off" autocorrect="off" name="specregno" placeholder="registration number" value="<?= set_value('specregno'); ?>" type="text">
                                            <p class="help-block"><sup>*</sup>From the medical board of Kenya</p>
                                        </div>
                                        <div class="home-account-pane-top-form-group">
                                            <label>Specialty</label>
                                            <select class="home-account-pane-top-form-input" required="true" autocapitalize="off" autocorrect="off" name="specspecialty">
                                                <option disabled="" selected="">Please select</option>
                                                <?php
                                                $all_specialty = $this->crudmod->get_all('specialty', 'specialtyId');
                                                foreach ($all_specialty as $all_specialty_row):
                                                    $spe_id = $all_specialty_row->specialtyId;
                                                    $spe_name = $all_specialty_row->sName;
                                                    ?>
                                                    <option value="<?= $spe_id; ?>"><?= $spe_name; ?></option>
                                                    <?php
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                        <span class="home-account-pane-top-form-button">
                                            <button type="submit" class="home-account-pane-top-form-btn home-account-pane-top-form-btn-primary home-cousor home-padding">List Practice</button>
                                        </span>
                                    </form>
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