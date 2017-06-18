
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Write a Review</title>

        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">
        <link rel="shortcut icon" href="<?= base_url('khyp/imgs/favicon.png'); ?>">

    </head>
    <body id="main-page">

        <header>

            <?php $this->view('header'); ?>


            <div class="container">
                <div class="search-container page-banner">

                    <div class="text-white">
                        <h2 class="home-logo" id="logo">
                            Write a review for <?= $displayName; ?>    
                        </h2>
                        <div class="centered-title">
                            <p><?= $docLocation; ?> <span class="divider-bullet">•</span> <?= $docPhone; ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </header>


        <div class="provider review">
            <div class="container">

                <?php if (null != validation_errors() || null != $this->session->flashdata('error') || null != $this->session->flashdata('success')) { ?>
                    <div class="alert alert-<?= null == $this->session->flashdata('success') ? 'danger' : 'success' ?>">
                        <?= validation_errors() ?>
                        <?= $this->session->flashdata('error') ?>
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php }
                ?>


                <div class="row">


                    <div class="col-md-7">
                        <div class="media">
                            <div class="media-left photo">
                                <a>
                                    <img class="media-object" src="<?= base_url("avatars/$specialtyPhoto"); ?>" alt="<?= $displayName; ?>">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><?= $displayName; ?></h4>
                                <ul class="list-unstyled">
                                    <li>
                                        <p><i class="i i-study"></i> <i class="i i-dot"></i> <?= $qualification ?></p>
                                    </li>
                                    <li>
                                        <p> Verified by <?= $docCertification['certificationName']; ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <form method="post" action="<?= base_url("publish/review"); ?>">
                            <input type="hidden" name="docKey" value="<?= $specialistId; ?>" required=""/>
                            <div class="form-group">
                                <label>Your review</label>
                                <textarea class="form-mine" required="" name="docReview" style="height: 152px;"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="form-btn-review" value="Post review"/>
                            </div>
                            <small class="subtle-text">* You can always edit or remove reviews later.</small>
                        </form>
                    </div>


                </div>
            </div>
        </div>


        <?php $this->view('footer'); ?>



        <script src="<?= base_url('khyp/js/jquery.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/bootstrap.min.js'); ?>"></script>
        <script src="<?= base_url('khyp/js/custom.min.js'); ?>"></script>
        <script type="text/javascript"
                src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
        </script>
        <script type="text/javascript"
                src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
        </script>


        <script type="text/javascript">
            $(function () {
                $('#datetimepicker2').datetimepicker({
                    language: 'en',
                    pick12HourFormat: true
                });
            });


            var dateToday = new Date();


            $.fn.datetimepicker.defaults = {
                maskInput: true, // disables the text input mask
                pickDate: true, // disables the date picker
                pickTime: false, // disables de time picker
                pick12HourFormat: false, // enables the 12-hour format time picker
                pickSeconds: false, // disables seconds in the time picker
                startDate: dateToday, // set a minimum date
                endDate: Infinity          // set a maximum date
            };
        </script>
    </body>



</html>
