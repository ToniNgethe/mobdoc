<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title> Search &CenterDot; Mobdoc </title>


        <link rel="stylesheet" href="<?= base_url('khyp/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/icons.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('khyp/css/hype.min.css'); ?>">

    </head>
    <body id="main-page">


        <?php $this->view('header'); ?>

        <div class="refine-search">
            <div class="container">
                <div class="search-container">
                    <div class="content">
                        <form method="get" action="<?= base_url("search"); ?>">
                            <div class="row">
                                <div class="col-md-5 col-sm-6">
                                    <div class="form-group is-empty">
                                        <input class="form-control" placeholder="city / province / zip code" type="text" name="zipcode" value="<?= $_GET['zipcode']; ?>">
                                        <i class="i i-location"></i>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-5 col-sm-6">
                                    <div class="form-group is-empty">
                                        <input class="form-control" placeholder="doctor's name / facility / specialty" type="text" name="specialty" value="<?= $_GET['specialty']; ?>">
                                        <i class="i i-user3"></i>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-2 col-sm-6">
                                    <button type="submit" class="btn btn-search form-control"><i class="i i-search2"></i> Find</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="container" id="profile">

            <div class="row">
                <div class="col-md-8">

                    <div class="my-jobs">
                        <?php
                        if (count($s_results) > 0) {
                            ?>

                            <h1 class="job-header">We’ve found <?= $total_result; ?> user results </h1>


                            <?php
                            foreach ($s_results as $s_results_row):
                                $fullname = $s_results_row->fullname;
                                $username = $s_results_row->username;
                                $zipcode = $s_results_row->zipcode;
                                $joindate = $s_results_row->joindate;
                                $useravi = $s_results_row->myavi;
                                ?>
                                <article class="review">
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="<?= base_url("kh/" . $username); ?>">
                                                <img class="media-object img-review" src="<?= base_url("avatars/" . $useravi); ?>" alt="" width="60" height="60">
                                            </a>
                                        </div>
                                        <div class="media-body" id="review-publisher">
                                            <h4 class="media-heading"><a href="<?= base_url("kh/" . $username); ?>"><?= $fullname; ?></a></h4>
                                            <h3><i class="i i-user3"></i> <?= $username; ?></h3>
                                            <h3><i class="i i-location"></i> <?= $zipcode; ?></h3>
                                        </div>
                                    </div>
                                </article>
                                <?php
                            endforeach;
                        } else {
                            ?>
                            <div class="">
                                <strong><i class="i i-info2"></i></strong> No results found
                            </div>
                            <?php
                        }
                        ?>
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